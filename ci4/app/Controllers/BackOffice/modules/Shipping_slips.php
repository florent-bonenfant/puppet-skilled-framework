<?php

namespace App\Controllers\BackOffice\Modules;

use \App\Model\Family as FamilyModel;
use \App\Model\ShippingSlips;
use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;

class Shipping_slips extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'url',
            'date',
            'download',
        ],
        'language' => [
            'backoffice/shipping_slip',
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.modules.shipping_slipss.view',
        'view' => 'backoffice.modules.shipping_slips.view',
        'download' => 'backoffice.modules.shipping_slips.download',
    ];

    public function index()
    {
        $query = ShippingSlips::query();
        $filters = new QueryFilter(
            [
                'filters' => [
                    'number' => function ($query, $value) {
                        $query->where('number', 'like', '%' . $value . '%');
                    },
                    'customer_id' => function ($query, $value) {
                        $query->where('customer_id', 'like', $value);
                    },
                ],
                'default_filters' => [],
                'save' => 'backoffice_modules_shipping_slips_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'created_at' => 'created_at',
                    'number' => 'number',
                    'date' => 'date',
                ],
                'order' => 'DESC',
                'save' => 'backoffice_modules_shipping_slips_pager',
                'unique_order_key' => $query->getModel()->getKeyName(),
            ]
        );

        $pager->run($filters->run($query));

        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'families' => FamilyModel::query()->get(),
        ]);
    }

    public function add()
    {
    }

    public function edit($id = null)
    {
    }

    public function download($id = null)
    {
        $item = ShippingSlips::find($id);
        if (!file_exists(dirname(APPPATH) . DIRECTORY_SEPARATOR . $item->documentPath())) {
            show_404();
        }
        force_download(dirname(APPPATH) . DIRECTORY_SEPARATOR . $item->documentPath(), null);
    }
}
