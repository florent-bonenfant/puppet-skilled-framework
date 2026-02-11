<?php
namespace App\Job;

use \App\Model\Customer as CustomerModel;
use \App\Model\InstitutTime as InstitutTimeModel;
use Carbon\Carbon;

class ImportInstituts extends \App\Job\Import
{
    protected $source_file_pattern = '/institut_([0-9]{8})\.txt$/';
    protected $model = '\App\Model\Institut';
    protected $compare = ['id', 'customer_id'];

    protected $map = [
        'id' => 'code_client_livre',
        'customer_id' => 'code_client_facture',
        'name' => 'enseigne',
        'address' => 'adresse1',
        'address2' => 'adresse2',
        'postcode' => 'cp',
        'city' => 'ville',
        'status' => 'statut',
    ];

    protected function buildRow($row)
    {
        $customer = CustomerModel::where('id', $row['code_client_facture'])->first();

        if (!$customer) {
            $this->message_log('ERROR', $row['code_client_livre'] . ' (enseigne : ' . $row['enseigne'] . ') : the customer ' . $row['code_client_facture'] . ' does not exists');
            return false;
        }

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = 'Customer n°' . $item->customer_id . ' / Institut id : ' . $item->id . ' / Institut name : ' . $item->name;

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }
}
