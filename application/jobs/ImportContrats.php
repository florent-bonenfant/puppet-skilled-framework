<?php
namespace App\Job;

use \App\Model\Customer as CustomerModel;
use \App\Model\Company as CompanyModel;
use Carbon\Carbon;

class ImportContrats extends \App\Job\Import
{
    protected $source_file_pattern = '/contrat_([0-9]{8})\.txt$/';
    protected $document_dir_source = 'contracts';
    protected $model               = '\App\Model\Contrat';
    protected $compare             = ['customer_id', 'company_id'];
    protected $companies           = [];

    protected $map = [
        'customer_id' => 'client',
        'company_id'  => 'societe',
        'city'        => 'ville',
        'file_name'   => 'nom_fichier',
    ];

    public function __construct()
    {
        $companies_keys = [
            'Guinot'    => '00001',
            'Mary Cohr' => '00002',
        ];

        // builds an array with the company shortname as key, and company id as value
        foreach (CompanyModel::all() as $item) {
            $key = $companies_keys[$item->name];
            $this->companies[$key] = $item->id;
        }
    }

    protected function buildRow($row)
    {
        if ($row['nom_fichier']) {
            $source = config_item('data_import_path') . '/' . $this->document_dir_source . '/' . $row['nom_fichier'];
            // Check if the file can be found and copy it to the right directory, display an error otherwise
            if (is_file($source)) {
                if (!is_dir(config_item('data_document_path') . '/contrats')) {
                    mkdir(config_item('data_document_path') . '/contrats', 0777, true);
                }

                $new_name = sha1($row['nom_fichier']) . '.' . pathinfo($source)['extension'];
                if (!is_file($dest = config_item('data_document_path').'/contrats/'.$new_name)) {
                    copy($source, $dest);
                }

                // won't be saved in the table for now, because "nom_fichier_original" does not exist in the csv headers (and the import script throws an error if you try to map it and write it) but it will be used in the callback() mathod later
                $row['nom_fichier_original'] = $row['nom_fichier'];
                // replaces the nom_fichier with the sha1
                $row['nom_fichier'] = $new_name;
                
            } else {
                $this->message_log('WARNING',  $row['nom_fichier'] . ' not found');
                $row['nom_du_fichier'] = null;
            }
        }

        $customer = CustomerModel::where('id', $row['client'])->first();

        if (!$customer) {
            $this->message_log('ERROR', $row['client'] . ' (societe : ' . $row['societe'] . ') : the customer does not exist');
            return false;
        }

        $row['societe'] = $this->companies[$row['societe']];

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // writes the original_file_name field with "nom_fichier_original" created earlier in the row
        if (!empty($row['nom_fichier_original'])) {
            $item->original_file_name = $row['nom_fichier_original'];
            $item->save();
        }

        // output
        $element = 'Customer n°' . $item->customer_id . ' / Contrat';

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }

}