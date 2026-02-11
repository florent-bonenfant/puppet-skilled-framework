<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Core\Application;

class RenumberingCustomers extends \Globalis\PuppetSkilled\Controller\Cli
{
    protected $customersUpdated = 0;
    protected $filename;
    protected $queryBuilder;
    protected $tablesWithoutFk = [
        'customers' => 'id',
        'notifications_backup' => 'customer_id', // pas de cascade
        'users_roles' => 'customer_id',          // pas de cascade
        'users_roles_old' => 'customer_id',      // pas de cascade
    ];
    protected $tables = [
        'furnitures' => 'customer_id',
        'instituts' => 'customer_id',
        'invoices' => 'customer_id',
        'logs' => 'customer_id',
        'notifications' => 'customer_id',
        'orders' => 'customer_id',
        'shippings' => 'customer_id',
    ];
    protected $errorsFk = [];
    protected $errorsWFk = [];
    protected $newIds = [];
    protected $ignoreIds = [
        22428,
        22952
    ];

    public function index($filename = 'renumerotation_final_extranet.csv')
    {
        log_message('info', 'Lancement du script : ' . __CLASS__);
        $this->filename = config_item('data_document_path') . '/renumbering_customers/' . $filename;
        if (!is_file($this->filename)) {
            log_message('error', 'Fichier non trouvé : ' . $this->filename);
            return false;
        }

        if (!$handle = fopen($this->filename, 'r' )) {
            log_message('error', 'Erreur d\'ourverture : ' . $this->filename);
            return false;
        }

        while ($line = fgetcsv($handle, 0, ';')) {
            list($old, $new,) = $line;

            if ($old === 'ANCIEN_CODE') {
                continue;
            }
            $this->newIds[] = $new;
            $this->treatmentLine($old, $new);
        }

        $db = Application::getInstance()->get('db');
        $db->query("UPDATE `customers` SET `id` = `old_num`
        WHERE (
            `customers`.`active` = '0'
            AND old_num NOT IN (" . implode( ',', $this->newIds) . ")
        )");

        foreach ($this->errorsFk as $table => $errors) {
            echo 'Erreurs sur la table "'.$table.'" avec liaison :' . PHP_EOL . json_encode($errors) . PHP_EOL;
        }
        foreach ($this->errorsWFk as $table => $errors) {
            echo 'Erreurs sur la table "'.$table.'" :' . PHP_EOL . json_encode($errors) . PHP_EOL;
        }
        log_message('info', 'Fin du script : ' . __CLASS__);
    }

    public function initQb()
    {
        return Application::getInstance()->get('queryBuilder');
    }

    public function treatmentLine($old, $new)
    {
        foreach ($this->tablesWithoutFk as $table => $fk) {
            if (
                $this->initQb()->from($table)->where($fk, $old)->update([$fk => $new])
            ) {
                if (!in_array($new, $this->ignoreIds)) {
                    $this->errorsWFk[$table][] = [
                        'oldId' => $old,
                        'newId' => $new,
                    ];
                    log_message('error', 'Echec update ancien customer : ' . $old . ', nouveau customer : ' . $new);
                }
            }
        }

        foreach ($this->tables as $table => $fk) {
            if (
                is_null($this->initQb()->select()->from($table)->where($fk, $new)->first())
            ) {
                log_message('debug', 'Entité non trouvée sur : ' . $table . ' ancien customer : ' . $old . ', nouveau customer : ' . $new . ', lancement d\'un update');
                if (
                    !$this->initQb()->from($table)->where($fk, $old)->update([$fk => $new])
                ) {
                    $this->errorsFk[$table][] = [
                        'oldId' => $old,
                        'newId' => $new,
                    ];
                    log_message('error', 'Echec update sur la table : ' . $table . ' ancien customer : ' . $old . ', nouveau customer : ' . $new);
                }
            }
        }
    }
}
