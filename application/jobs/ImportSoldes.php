<?php
namespace App\Job;

use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Solde as SoldeModel;
use Carbon\Carbon;

class ImportSoldes extends \App\Job\Import
{
    protected $source_file_pattern = '/solde_([0-9]{8})\.txt$/';
    //protected $document_dir_source = 'invoices';
    protected $model = '\App\Model\Solde';
    protected $compare = ['customer_id', 'company_id'];

    protected $map = [
        'customer_id' => 'client',
        'company_id'  => 'societe',
        'amount'      => 'montant',
        'date'        => 'date_du_jour',
    ];

    protected $companies = [];

    public function __construct()
    {
        $companiesKeys = [
            'Guinot'    => 'RG',
            'Mary Cohr' => 'MC',
        ];
        // builds an array with the company shortname as key, and company id as value
        foreach (CompanyModel::all() as $item) {
            $key = $companiesKeys[$item->name];
            $this->companies[$key] = $item->id;
        }

        SoldeModel::query()->delete();
    }

    protected function buildRow($row)
    {
        $customer = CustomerModel::where('id', $row['client'])->first();

        if (!$customer) {
            $this->message_log('ERROR', $row['client'] . ' (societe : ' . $row['societe'] . ') : the customer does not exist');
            return false;
        }

        $carbon = new Carbon($row['date_du_jour']);
        $row['date_du_jour'] = $carbon->format('Y-m-d');
        // gets the company id
        $row['societe'] = $this->companies[$row['societe']];
        // if the amount is a float with comma decimal separator
        // just in case
        if (preg_match('/\d+,\d+$/', $row['montant'])) {
            $row['montant'] = str_replace(',', '.', $row['montant']);
        }
        // formats the amount to store it in decimal(10,2) mysql column
        $row['montant'] = number_format((float) $row['montant'], 2, '.', '');

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = 'Customer n°' . $item->customer_id . ' / Solde';

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }
}
