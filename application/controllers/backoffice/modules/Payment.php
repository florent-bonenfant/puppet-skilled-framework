<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \App\Model\Payment as PaymentModel;

class Payment extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url',
            'date',
        ],
        'language' => [
            'backoffice/payment',
            'webservice/payment',
        ]
    ];

    protected $guards = [
        'index' => 'backoffice.modules.payment.view',
        'view' => 'backoffice.modules.payment.view',
        'delete' => 'backoffice.modules.payment.delete',
    ];

    public function index()
    {
        $query = PaymentModel::withTrashed()->with(['customer', 'creator']);
        $filters = new QueryFilter(
            [
                'filters' => [
                    'description' => function ($query, $value) {
                        $query->where('description', 'like', '%' . $value . '%');
                    },
                    'state' => function ($query, $value) {
                        $query->where('state', 'like', $value);
                    },
                    'stripe_id' => function ($query, $value) {
                        $query->where('stripe_id', 'like', $value);
                    },
                    'customer_id' => function ($query, $value) {
                        $query->where('customer_id', 'like', $value);
                    },
                    'amount' => function ($query, $value) {
                        $query->where('amount', 'like', $value . '%');
                    },
                    'mail_send' => function ($query, $value) {
                        if (!$value) {
                            $query->whereNull('mail_send');
                        }
                    },
                ],
                'save' => 'backoffice_modules_payement_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'created_at' => 'created_at',
                    'state' => 'state',
                    'customer_id' => 'customer_id',
                    'description' => 'description',
                    'mail_send' => 'mail_send',
                    'amount' => 'amount',
                ],
                'order' => 'DESC',
                'save' => 'backoffice_modules_payement_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));
        $states = [];
        foreach (PaymentModel::distinct('state')->pluck('state') as $map) {
            $states[$map] = lang('payment_stripe_label_' . $map);
        }

        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'states' => $states,
        ]);
    }
}
