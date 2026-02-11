<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Model\Institut;

class DeleteDoubleInstitutWithFile extends \Globalis\PuppetSkilled\Controller\Cli
{
    protected $filename;
    protected $queryBuilder;

    public function index($filename = '/2022.06.20.institut.txt')
    {
        log_message('info', 'Lancement du script : ' . __CLASS__);
        $this->filename = config_item('data_document_path') . '/cli' . $filename;
        if (!is_file($this->filename)) {
            echo 'Fichier non trouvé : ' . $this->filename . PHP_EOL;
            log_message('error', 'Fichier non trouvé : ' . $this->filename);
            return false;
        }

        if (!$handle = fopen($this->filename, 'r' )) {
            log_message('error', 'Erreur d\'ourverture : ' . $this->filename);
            return false;
        }

        $arrayInstitutToDelete = [];
        while ($line = fgetcsv($handle, 0, '|')) {
            list($code_client_facture, $code_client_livre, $enseigne, $adresse1, $adresse2, $cp, $ville, $statut,) = $line;

            if ($code_client_livre === 'code_client_livre') {
                continue;
            }
            $arrayInstitutToDelete[] = $code_client_facture;
        }

        log_message('info', 'Instituts à supprimer : ' . json_encode($arrayInstitutToDelete));
        Institut::whereIn('customer_id', $arrayInstitutToDelete)->delete();

        echo count($arrayInstitutToDelete) . ' Instituts supprimés.';
        log_message('info', 'Fin du script : ' . __CLASS__);
    }
}