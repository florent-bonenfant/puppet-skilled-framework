<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\FormValidation;

use \App\Model\User as UserModel;
use \App\Model\Payment as PaymentModel;

class Payment extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    const PAYMENT_REASON = [
        'order' => 'Commande',
        'regularization' => 'Régularisation impayée',
        'bill' => 'Facture',
        'timeline' => 'Echéancier',
        'plan' => 'Plan',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->lang->load('webservice/payment_lang.php', 'french');
        $this->lang->load('general_lang.php', 'french');
    }

    /**
     * @api {post} /payment  Create new payment entry
     * @apiName paymentOne
     * @apiGroup Payment
     * @apiVersion 1
     *
     * @apiSuccess (201)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Parameter error.
     */
    public function create_one()
    {
        \Stripe\Stripe::setApiKey(config_item('stripe_secret_key_' . $this->customer->company->slug));
        $data = $this->input->post();
        $validator = $this->get_validator();
        $validator->set_data($this->input->post());

        if ($validator->run()) {
            $customer = $this->getOrCreateCustomer();
            $user = $this->authenticationService->user();
            if (!empty($this->session->userdata('real_user')) && $user->id !== $this->session->userdata('real_user')) {
                $admin = UserModel::find($this->session->userdata('real_user'));
            }

            try {
                $payment = new PaymentModel();
                // Create a PaymentIntent with amount and currency
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => \bcmul($data['amount'], 100),
                    'currency' => 'eur',
                    'payment_method_types' => ['card'],
                    'description' => $customer->id . ' - ' . self::PAYMENT_REASON[$data['description']],
                    'customer' => $customer->id,
                    'receipt_email' => $this->customer->email,
                    'metadata' => [
                        'customer_id' => $customer->id,
                        'customer_name' => $customer->name,
                        'user_mail' => $admin->email ?? $user->email,
                        'user_id' => $admin->id ?? $user->id,
                        'payment_id' => $payment->id,
                    ]
                ]);

                $output = [
                    'clientSecret' => $paymentIntent->client_secret,
                    'redirectUrl' => config_item('front_base_url') . '/payment/result',
                ];

                $payment->customer_id = $this->customer->id;
                $payment->stripe_id = $paymentIntent->id;
                $payment->state = $paymentIntent->status;
                $payment->description = $paymentIntent->description;
                $payment->amount = bcdiv($paymentIntent->amount, 100, 2);
                $payment->created_by = $admin->id ?? $user->id;
                $payment->save();

                $this->return(200, $output);
            } catch (Error $e) {
                $this->return(500);
                log_message('error', '[Paiement] : ' . json_encode(['error' => $e->getMessage(), 'paymentIntent' => $payment]));
                echo json_encode(['error' => lang('payment_label_error')]);
            }
        } else {
            //if the validator doesn't validate the form
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'CREATE_PAYMENT_ERROR',
                'resultContent' => $validator->error_array(),
            ]);
        }
    }

    /**
     * Finalisation normal du paiement
     *
     * @param     [string]    $id    stripe_id
     *
     * @apiError (Error 4xx) {400}  error   Parameter error.
     */
    public function update_one($id = null)
    {
        $validator = $this->get_validator_update($id);
        $validator->set_data(['stripe_id' => $id]);

        if ($validator->run()) {
            try {
                \Stripe\Stripe::setApiKey(config_item('stripe_secret_key_' . $this->customer->company->slug));
                $paymentIntent = \Stripe\PaymentIntent::retrieve($id);
                $user = $this->authenticationService->user();
                if (!empty($this->session->userdata('real_user')) && $user->id !== $this->session->userdata('real_user')) {
                    $admin = UserModel::find($this->session->userdata('real_user'));
                }

                $payment = PaymentModel::where('stripe_id', $id)->first();

                if (is_object($paymentIntent->last_payment_error)) {
                    // https://stripe.com/docs/error-codes
                    $payment->state = $paymentIntent->last_payment_error->code;
                } else {
                    $payment->state = $paymentIntent->status;
                }
                $payment->amount = bcdiv($paymentIntent->amount, 100, 2);
                $payment->updated_by = $admin->id ?? $user->id;
                $payment->save();

                $this->return(200);
            } catch (\Exception $e) {
                log_message('error', '[Paiement] : ' . json_encode(['stripe_id' => $id, 'user' => $user]));
            }
        } else {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'UPDATE_PAYMENT_ERROR',
            ]);
        }
    }

    /**
     * @api {delete} /payment/{id}  Deletes a payment started
     * @apiName paymentDelete
     * @apiGroup payment
     * @apiVersion 1
     *
     * @see https://stripe.com/docs/api/payment_intents/cancel
     *
     * @apiSuccess (204)    The payment has been deleted
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Payment not found.
     */
    public function delete_one($id = null)
    {
        $validator = $this->get_validator_update($id);
        $validator->set_data(['stripe_id' => $id]);
        if ($validator->run()) {
            try {
                $stripe = new \Stripe\StripeClient(config_item('stripe_secret_key_' . $this->customer->company->slug));
                $stripe->paymentIntents->cancel(
                    $id
                );
                $user = $this->authenticationService->user();
                if (!empty($this->session->userdata('real_user')) && $user->id !== $this->session->userdata('real_user')) {
                    $admin = UserModel::find($this->session->userdata('real_user'));
                }

                PaymentModel::where('stripe_id', $id)->delete();
            } catch (\Exception $e) {
                log_message('error', '[Paiement] : ' . json_encode(['stripe_id' => $id, 'user' => $admin->id ?? $user->id]));
            }
            $this->return(static::HTTP_NO_CONTENT, [
                'resultCode' => 'PAYMENT_CANCEL_PAYMENT',
            ]);
        } else {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'CANCEL_PAYMENT_ERROR',
            ]);
        }
    }

    /**
     * @api {get} /payment  Get all payments for a given company
     * @apiName paymentAll
     * @apiGroup Payment
     * @apiVersion 1
     *
     * @apiSuccess (200)    {result}       result       Array of payments
     *
     */
    public function all()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            // On force le rafraichissement
            'resultContent' => $this->customer->payments()->get(),
        ]);
    }

    public function get_validator()
    {
        $validator = new FormValidation();

        $validator->set_rules(
            'amount',
            'lang:payment_label_amount',
            [
                'trim',
                'required',
                'numeric',
                'greater_than[0]'
            ],
            [
                'required' => 'Le montant est requis.',
            ]
        );

        $validator->set_rules(
            'description',
            'lang:payment_label_description',
            [
                'trim',
                'required',
                'in_list[' . implode(',', array_keys(self::PAYMENT_REASON)) . ']',
                'max_length[255]'
            ]
        );
        return $validator;
    }

    public function get_validator_update()
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'stripe_id',
            'lang:adminToken',
            [
                'trim',
                [
                    'stripe_id',
                    function ($value) {
                        if (empty($value)) {
                            return false;
                        }
                        return !!PaymentModel::where('stripe_id', $value)->where('customer_id', $this->customer->id)->first();
                    }
                ],
            ]
        );
        return $validator;
    }

    //
    // STRIPE
    //
    protected function getOrCreateCustomer()
    {
        try {
            $customer = \Stripe\Customer::retrieve($this->customer->id);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $customer = \Stripe\Customer::create([
                "id" => $this->customer->id,
                "name" => $this->customer->title,
                "address" => [
                    'line1' => $this->customer->address,
                    'line2' => $this->customer->address2,
                    'postal_code' => $this->customer->zip,
                    'city' => $this->customer->city,
                ],
                "description" => $this->customer->company->name,
                "email" => $this->customer->email,
                // "metadata" => {},
                "phone" => $this->customer->phone,
                "preferred_locales" => [
                    'fr',
                    'en',
                ],
            ]);
        }
        return $customer;
    }
}
