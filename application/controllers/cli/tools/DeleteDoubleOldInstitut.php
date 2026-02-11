<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Core\Application;
use \App\Model\Institut;

class DeleteDoubleOldInstitut extends \Globalis\PuppetSkilled\Controller\Cli
{
    protected $filename;
    protected $queryBuilder;

    public function index($filename = '/institut.txt')
    {
        log_message('info', 'Lancement du script : ' . __CLASS__);
        $this->filename = config_item('data_document_path') . '/' . $filename;
        if (!is_file($this->filename)) {
            echo 'Fichier non trouvé : ' . $this->filename . PHP_EOL;
            log_message('error', 'Fichier non trouvé : ' . $this->filename);
            return false;
        }

        if (!$handle = fopen($this->filename, 'r' )) {
            log_message('error', 'Erreur d\'ourverture : ' . $this->filename);
            return false;
        }

        $keepList = [];
        while ($line = fgetcsv($handle, 0, '|')) {
            list($code_client_facture, $code_client_livre, $enseigne, $adresse1, $adresse2, $cp, $ville, $statut,) = $line;

            if ($code_client_facture === 'code_client_facture') {
                continue;
            }
            $keepList[] = $code_client_facture;
        }

        $db = Application::getInstance()->get('db');
        $institutToDelete = $db->query("SELECT i.id
        FROM instituts i
        INNER JOIN (
            SELECT name, customer_id, address, COUNT(*) AS qty
            FROM instituts
            GROUP BY name, customer_id, address
            HAVING COUNT(*) > 1
        ) t ON i.name = t.name AND i.customer_id = t.customer_id AND i.address = t.address
        WHERE i.id NOT IN (" . implode(',', $keepList) . ")");

        $institutsToDelete = [];
        if ($institutToDelete->num_rows() > 0) {
            $institutsToDelete = array_column($institutToDelete->result(), 'id');
        }

        log_message('info', 'Instituts à supprimer : ' . json_encode($institutsToDelete));
        Institut::whereIn('id', $institutsToDelete)->delete();

        echo count($institutsToDelete) . ' Instituts supprimés.';
        log_message('info', 'Fin du script : ' . __CLASS__);
    }

    public function initQb()
    {
        return Application::getInstance()->get('queryBuilder');
    }
}
