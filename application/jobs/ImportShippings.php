<?php
namespace App\Job;

use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Institut as InstitutModel;

class ImportShippings extends \App\Job\Import
{
    protected $source_file_pattern = '/livraison_([0-9]{8})\.txt$/';
    protected $document_dir_source = 'shippings';
    protected $model = '\App\Model\Shipping';
    protected $compare = ['customer_id', 'shipping_number'];

    protected $map = [
        'customer_id'           => 'code_client_facture',
        'institut_id'           => 'code_client_livre',
        'shipping_number'       => 'bon_de_livraison',
        'file_name'             => 'nom_du_fichier',
    ];

    protected $dataInline = [];

    protected $companies = [];

    protected $shippings_id = [];

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
        if ($row['nom_du_fichier']) {
            // Check if the file can be found and copy it to the right directory, display an error otherwise
            if (is_file($source = config_item('data_import_path').'/'.$this->document_dir_source.'/'.$row['nom_du_fichier'])) {
                if (!is_dir(config_item('data_document_path').'/shippings')) {
                    mkdir(config_item('data_document_path').'/shippings', 0777, true);
                }

                $new_name = sha1($row['nom_du_fichier']).'.'.pathinfo($source)['extension'];
                if (!is_file($dest = config_item('data_document_path').'/shippings/'.$new_name)) {
                    copy($source, $dest);
                }

                $row['nom_du_fichier'] = $new_name;
            } else {
                $this->message_log('WARNING',  $row['nom_du_fichier'] . ' not found');
                $row['nom_du_fichier'] = null;
            }
        }

        // verif existing customer
        $customer = CustomerModel::where('id', $row['code_client_facture'])->first();
        if (!$customer) {
            $this->message_log('ERROR', 'document number ' . $row['bon_de_livraison'] . ' -> the customer does not exists');
            return false;
        }

        // verif existing institute
        $institut = InstitutModel::where('id', $row['code_client_livre'])->first();
        if (!$institut) {
            $this->message_log('ERROR', 'shipping number ' . $row['bon_de_livraison'] . ' -> the institute does not exists');
            return false;
        }

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {

        if ($isUpdate) {
            $this->message_log('INFO', $item->shipping_number .' updated');
        } else {
            $this->message_log('INFO', $item->shipping_number .' added');
        }
    }
}
