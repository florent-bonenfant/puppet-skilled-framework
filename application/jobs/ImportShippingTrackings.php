<?php

namespace App\Job;

use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Institut as InstitutModel;
use \App\Model\Order as OrderModel;
use \App\Model\ShippingCarrier as ShippingCarrierModel;
use \App\Model\ShippingOrder;
use Carbon\Carbon;

class ImportShippingTrackings extends \App\Job\Import
{
    protected $source_file_pattern = '/suivi_colis_([0-9]{8})\.txt$/';
    protected $document_dir_source = 'shippings_trackings';
    protected $model = '\App\Model\ShippingTrackings';
    protected $compare = ['customer_id', 'number'];
    protected $carriers;

    protected $map = [
        'customer_id'           => 'client_fac',
        'institut_id'           => 'client_liv',
        'number'                => 'code_suivi',
        'order_id'              => 'num_cde',
        'carrier_id'            => 'transporteur',
        'date'                  => 'date',
    ];

    protected $ignore_fields = ['order_id'];

    protected $dataInline = [];

    protected $companies = [];

    protected $shippings_id = [];

    protected $orderId;

    public function __construct()
    {
        $companiesKeys = [
            'Guinot'    => 'RG',
            'Mary Cohr' => 'MC',
        ];
        foreach (CompanyModel::all() as $item) {
            $key = $companiesKeys[$item->name];
            $this->companies[$key] = $item->id;
        }
        foreach (ShippingCarrierModel::all() as $item) {
            $this->carriers[$item->slug] = $item->id;
        }
    }

    protected function buildRow($row)
    {
        // verif existing customer
        $customer = CustomerModel::where('id', $row['client_fac'])->first();
        if (!$customer) {
            $this->message_log('ERROR', 'Customer ' . $row['client_fac'] . ' -> the customer does not exists');
            return false;
        }

        // verif existing institute
        $institut = InstitutModel::where('id', $row['client_liv'])->first();
        if (!$institut) {
            $this->message_log('ERROR', 'institute ' . $row['client_liv'] . ' -> the institute does not exists');
            return false;
        }

        if (!empty($row['num_cde']) && !($order = OrderModel::where('order_number', $row['num_cde'])->first())) {
            $this->message_log('ERROR', 'Order number ' . $row['num_cde'] . ' -> the order does not exists');
            return false;
        }

        $row['date'] = ($row['date'] ? new Carbon($row['date']) : null);
        $this->orderId = empty($row['num_cde']) ? null : $order->id;
        $row['transporteur'] = $this->carriers[$row['transporteur']];

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        $order = ShippingOrder::where('entity_id', $item->id)->where('order_id', $this->orderId)->where('resource_type', \App\Model\ShippingTrackings::class)->first();

        if (!empty($this->orderId) && !$order) {
            $shippingOrder = new ShippingOrder();
            $shippingOrder->order_id = $this->orderId;
            $shippingOrder->entity_id = $item->id;
            $shippingOrder->resource_type = \App\Model\ShippingTrackings::class;
            $shippingOrder->save();
        }

        if ($isUpdate) {
            $this->message_log('INFO', $item->number . ' updated');
        } else {
            $this->message_log('INFO', $item->number . ' added');
        }
    }
}
