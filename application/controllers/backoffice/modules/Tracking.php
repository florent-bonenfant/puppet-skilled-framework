<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \App\Model\ShippingTrackings as ShippingTrackingsModel;
use \App\Model\ShippingCarrier;

class Tracking extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url',
            'date',
        ],
        'language' => [
            'backoffice/shipping_tracking',
        ]
    ];

    protected $guards = [
        'index' => 'backoffice.modules.shipping_tracking.view',
        'view' => 'backoffice.modules.shipping_tracking.view',
    ];

    public function index()
    {
        $query = ShippingTrackingsModel::query()->with(['institut', 'orders', 'customer', 'carrier']);
        $filters = new QueryFilter(
            [
                'filters' => [
                    'number' => function ($query, $value) {
                        $query->where('number', 'like', '%' . $value . '%');
                    },
                    'carrier_id' => function ($query, $value) {
                        $query->where('carrier_id', 'like', $value);
                    },
                    'customer_id' => function ($query, $value) {
                        $query->where('customer_id', 'like', $value);
                    },
                    'institut_id' => function ($query, $value) {
                        $query->where('institut_id', 'like', $value);
                    },
                    'date' => function ($query, $value) {
                        $query->where('amount', 'like', $value . '%');
                    },
                ],
                'default_filters' => [],
                'save' => 'backoffice_modules_shipping_tracking_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'created_at' => 'created_at',
                    'carrier_id' => 'carrier_id',
                    'customer_id' => 'customer_id',
                    'date' => 'date',
                ],
                'order' => 'DESC',
                'save' => 'backoffice_modules_shipping_tracking_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));


        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'carriers' => [
                ShippingCarrier::pluck('label', 'id')
            ],
        ]);
    }
}
