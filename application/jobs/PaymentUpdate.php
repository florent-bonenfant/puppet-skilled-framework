<?php

namespace App\Job;

use \App\Model\Payment as PaymentModel;

class PaymentUpdate extends \Globalis\PuppetSkilled\Queue\Queueable
{
    protected $paymentId;

    const WAITING_PAYMENTS = [
        'requires_payment_method',
        'requires_confirmation',
        'requires_action',
        'processing'
    ];

    public function __construct($paymentId)
    {
        $this->paymentId = $paymentId;
    }

    public function handle()
    {
        $payment = PaymentModel::find($this->paymentId);
        if (!$payment || empty($payment->stripe_id)) {
            log_message('error', '[PaiementUpdate] : Paiement introuvable ' . json_encode(['payment_id' => $this->paymentId,]));
            exit(1);
        }

        // L'état du paiement ne nécessite pas de MAJ
        if (!in_array($payment->state, self::WAITING_PAYMENTS)) {
            $payment->mail_send = 1;
            $payment->save();
            $this->sendMail($payment);
            return true;
        }

        // Le paiement nécessite une mise à jour
        try {
            $paymentIntent = $this->getStripePayment($payment);
        } catch (\Exception $e) {
            log_message('error', '[PaiementUpdate] : Paiement stripe introuvable ' . json_encode(['stripe_id' => $payment->stripe_id]));
        }

        if (is_object($paymentIntent->last_payment_error)) {
            // https://stripe.com/docs/error-codes
            $payment->state = $paymentIntent->last_payment_error->code;
        } else {
            $payment->state = $paymentIntent->status;
        }
        $payment->attempts = $payment->attempts + 1;
        if ($payment->attempts >= PaymentModel::LIMIT_ATTEMPT_FETCH_STATE) {
            $payment->state = 'incomplete_expiry';
        }
        if (!in_array($payment->state, self::WAITING_PAYMENTS)) {
            $payment->mail_send = 1;
            $this->sendMail($payment);
        }

        $payment->save();
        return true;
    }

    protected function getStripePayment(PaymentModel $payment)
    {
        \Stripe\Stripe::setApiKey(config_item('stripe_secret_key_' . $payment->customer->company->slug));
        return \Stripe\PaymentIntent::retrieve($payment->stripe_id);
    }

    public function sendMail(PaymentModel $payment)
    {
        app()->load->helper('date_helper');
        app()->load->helper('language_helper');
        app()->load->language('webservice/payment');

        $customer = $payment->customer;
        if (!$customer->isClosed && !$customer->isRestricted) {
            $email = new MailerContent();

            if ($payment->state === 'succeeded') {
                $email->to($customer->email)
                ->setContent(
                    'email_payment_success',
                    [
                        'user_first_name' => ucfirst(strtolower($customer->first_name)),
                        'user_last_name'  => ucfirst(strtolower($customer->last_name)),
                        'user_email'      => $customer->email,
                        'amount'          => number_format($payment->amount, 2, ',', ' '),
                        'date'            => user_date_format($payment->created_at, false),
                        'reason'          => html_escape(html_escape(substr(strstr($payment->description, ' - '), 3))),
                        'front_url'       => config_item('front_base_url')
                    ]
                );
            } else {
                $email->to($customer->email)
                ->setContent(
                    'email_payment_failed',
                    [
                        'user_first_name' => ucfirst(strtolower($customer->first_name)),
                        'user_last_name'  => ucfirst(strtolower($customer->last_name)),
                        'user_email'      => $customer->email,
                        'payment_status'  => lang('payment_stripe_label_' . $payment->state),
                        'amount'          => number_format($payment->amount, 2, ',', ' '),
                        'date'            => user_date_format($payment->created_at, false),
                        'reason'          => html_escape(html_escape(substr(strstr($payment->description, ' - '), 3))),
                        'front_url'       => config_item('front_base_url')
                    ]
                );
            }
        }

        $email->handle();
    }
}
