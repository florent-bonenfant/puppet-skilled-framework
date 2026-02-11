<?php

namespace App\Job;

use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Institut as InstitutModel;
use \App\Model\Order as OrderModel;
use \App\Model\ShippingOrder;
use Carbon\Carbon;

class ImportShippingSlips extends \App\Job\Import
{
    protected $source_file_pattern = '/bordereau_expeditions_([0-9]{8})\.txt$/';
    protected $document_dir_source = 'shipping_slips';
    protected $model = '\App\Model\ShippingSlips';
    protected $compare = ['customer_id', 'number'];

    protected $map = [
        // 'societe'           => 'client_fac',
        'customer_id'           => 'client_fac',
        'institut_id'           => 'client_liv',
        'number'                => 'num_expedition',
        'order_id'              => 'num_cde',
        'filename'              => 'nom_fichier',
        'date'                  => 'date',
    ];

    protected $dataInline = [];

    protected $companies = [];

    protected $shippings_id = [];

    protected $orderId;

    protected $ignore_fields = ['order_id'];

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
    }

    protected function buildRow($row)
    {

        if ($row['nom_fichier']) {
            // Check if the file can be found and copy it to the right directory, display an error otherwise
            if (is_file($source = config_item('data_import_path') . DIRECTORY_SEPARATOR . $this->document_dir_source . DIRECTORY_SEPARATOR . $row['nom_fichier'])) {
                if (!is_dir(config_item('data_document_path') . DIRECTORY_SEPARATOR . $this->document_dir_source)) {
                    mkdir(config_item('data_document_path') . DIRECTORY_SEPARATOR . $this->document_dir_source, 0777, true);
                }

                $new_name = sha1($row['nom_fichier']) . '.' . pathinfo($source)['extension'];
                if (!is_file($dest = config_item('data_document_path') . DIRECTORY_SEPARATOR . $this->document_dir_source . DIRECTORY_SEPARATOR . $new_name)) {
                    copy($source, $dest);
                }

                $row['nom_fichier'] = $new_name;
            } else {
                $this->message_log('WARNING',  $row['nom_fichier'] . ' not found');
                $row['nom_fichier'] = null;
            }
        }

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

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        $order = ShippingOrder::where('entity_id', $item->id)->where('order_id', $this->orderId)->where('resource_type', \App\Model\ShippingSlips::class)->first();

        if (!empty($this->orderId) && !$order) {
            $shippingOrder = new ShippingOrder();
            $shippingOrder->order_id = $this->orderId;
            $shippingOrder->entity_id = $item->id;
            $shippingOrder->resource_type = \App\Model\ShippingSlips::class;
            $shippingOrder->save();
        }

        if ($isUpdate) {
            $this->message_log('INFO', $item->number . ' updated');
        } else {
            $this->message_log('INFO', $item->number . ' added');
        }
    }
}
