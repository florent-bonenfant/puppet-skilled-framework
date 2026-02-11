<?php
namespace App\Job;

use \App\Model\Customer as CustomerModel;
use Carbon\Carbon;

class ImportFurnitures extends \App\Job\Import
{
    protected $source_file_pattern = '/appareil_([0-9]{8})\.txt$/';
    protected $document_dir_source = 'furnitures';
    protected $model = '\App\Model\Furniture';
    protected $compare = ['customer_id', 'code', 'series'];

    protected $map = [
        'customer_id' => 'client',
        'code' => 'code_produit',
        'label' => 'libelle',
        'series' => 'serie',
        'initial_date' => 'date_initiale',
        'end_date' => 'date_sortie',
        'contract_number' => 'contrat',
        'file_name' => 'nom_du_fichier'
    ];

    protected function buildRow($row)
    {
        if ($row['nom_du_fichier']) {
            // Check if the file can be found and copy it to the right directory, display an error otherwise
            if (is_file($source = config_item('data_import_path').'/'.$this->document_dir_source.'/'.$row['nom_du_fichier'])) {
                if (!is_dir(config_item('data_document_path').'/furnitures')) {
                    mkdir(config_item('data_document_path').'/furnitures', 0777, true);
                }

                $new_name = sha1($row['nom_du_fichier']).'.'.pathinfo($source)['extension'];
                if (!is_file($dest = config_item('data_document_path').'/furnitures/'.$new_name)) {
                    copy($source, $dest);
                }

                $row['nom_du_fichier'] = $new_name;
            } else {
                $this->message_log('WARNING',  $row['nom_du_fichier'] . 'not found');
                $row['nom_du_fichier'] = null;
            }
        }

        // verif existing customer
        $customer = CustomerModel::where('id', $row['client'])->first();
        if (!$customer) {
            $this->message_log('ERROR', $row['libelle'] . ' (code : ' . $row['code_produit'] . ') : the customer does not exists');
            return false;
        }

        $row['date_initiale'] = ($row['date_initiale'] ? new Carbon($row['date_initiale']) : null);
        $row['date_sortie'] = ($row['date_sortie'] ? new Carbon($row['date_sortie']) : null);
        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // output
        $element = 'Customer n°'.$item->customer_id.' / Product code n°'.$item->code;

        if ($isUpdate) {
            $this->message_log('INFO', $element .' updated');
        } else {
            $this->message_log('INFO', $element .' added');
        }
    }

    public function before_set_data() {
        // delete all furnitures before process import
        $furnitures_model = new $this->model();
        $furnitures_model->whereNotNull('id')->delete();
    }
}
