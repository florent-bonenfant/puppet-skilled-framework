<?php

class UpdateNullDate extends PuppetSkilledMigration
{
    private $initialConfig;

    public function disableCheck()
    {
        $initialConfig = $this->fetchRow('SELECT @@GLOBAL.sql_mode global, @@SESSION.sql_mode session;');
        $this->initialConfig = $initialConfig['global'];
        $this->execute("SET GLOBAL sql_mode = '';");
        // fermeture de la requête pour la prise en compte du paramètrage
        $this->getAdapter()->disconnect();
        return $initialConfig;
    }

    public function change()
    {
        $this->disableCheck();
        $dateToCheck = [
            'affiliations' => [
                'publication_date',
                'display_start',
                'display_end',
                'updated_at',
                'deleted_at',
            ],
            'applications' => [
                'deleted_at',
            ],
            'applications_families' => [
                'updated_at',
            ],
            'applications_links' => [
                'updated_at',
            ],
            'banners' => [
                'updated_at',
                'deleted_at',
            ],
            'cgvs' => [
                'publication_date',
                'end_publication_date',
                'updated_at',
                'deleted_at',
            ],
            'cgvs_families' => [
                'updated_at',
            ],
            'commercial_conditions' => [
                'publication_date',
                'end_publication_date',
                'updated_at',
                'deleted_at',
            ],
            'commercial_conditions_companies' => [
                'updated_at',
            ],
            'contents' => [
                'modified_at',
            ],
            'contrats' => [
                'updated_at',
            ],
            'customers' => [
                'closed',
            ],
            'furnitures' => [
                'initial_date',
                'end_date',
            ],
            'instituts' => [
                'updated_at',
            ],
            'institut_files' => [
                'updated_at',
            ],
            'institut_times' => [
                'updated_at',
            ],
            'invoices' => [
                'date',
            ],
            'invoices_lines' => [
                'updated_at',
            ],
            'messages' => [
                'publication_date',
                'end_publication_date',
                'updated_at',
                'deleted_at',
            ],
            'payments' => [
                'updated_at',
                'deleted_at',
            ],
            'roles' => [
                'updated_at',
                'deleted_at',
            ],
            'shippings' => [
                'updated_at',
            ],
            'shippings_carriers' => [
                'updated_at',
            ],
            'shippings_carriers' => [
                'updated_at',
            ],
            'shippings_slips' => [
                'updated_at',
            ],
            'shippings_trackings' => [
                'date',
                'updated_at',
            ],
            'soldes' => [
                'date',
                'updated_at',
            ],
            'statistics' => [
                'updated_at',
            ],
            'users' => [
                'password_reset_datetime',
                'updated_at',
                'deleted_at',
            ],
        ];

        foreach ($dateToCheck as $table => $dates) {
            foreach ($dates as $dateName) {
                $this->execute("
                        UPDATE `{$table}`
                        SET {$dateName} = NULL
                        WHERE {$dateName} = '0000-00-00' OR {$dateName} = '0000-00-00 00:00:00'
                    ");
            }
        }

        // On réactive le SQL mode d'origine
        $this->execute("SET GLOBAL sql_mode = '{$this->initialConfig}';");
    }
}
