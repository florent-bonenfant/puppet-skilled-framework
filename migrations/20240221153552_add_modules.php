<?php

class AddModules extends PuppetSkilledMigration
{
    protected $modules = [
        // Paiement
        [
            'modules' => [
                'slug' => 'payment',
                'permission' => 'backoffice.modules.payment',
                'title_key' => 'module_payment',
            ],
            'contents' => [
                'slug' => 'module_payment',
                'type' => 'module',
                'title_key' => 'lang:module_payment',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'module_payment',
                'local' => 'french',
                'title' => 'Paiement en ligne',
                'content' => '',
            ],
        ],
        // suivi
        [
            'modules' => [
                'slug' => 'tracking',
                'permission' => 'backoffice.modules.tracking',
                'title_key' => 'module_tracking',
            ],
            'contents' => [
                'slug' => 'module_tracking',
                'type' => 'module',
                'title_key' => 'lang:module_tracking',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'module_tracking',
                'local' => 'french',
                'title' => 'Suivi colis',
                'content' => '',
            ],
        ],
        // bordereaux
        [
            'modules' => [
                'slug' => 'shipping_slips',
                'permission' => 'backoffice.modules.shipping_slips',
                'title_key' => 'module_shipping_slips',
            ],
            'contents' => [
                'slug' => 'module_shipping_slips',
                'type' => 'module',
                'title_key' => 'lang:module_shipping_slips',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'module_shipping_slips',
                'local' => 'french',
                'title' => 'Bordereaux d\'expédition',
                'content' => '',
            ],
        ],
        // Parents
        [
            'modules' => [
                'slug' => 'order_invoices',
                'permission' => 'backoffice.modules.order_invoices',
                'title_key' => 'module_order_invoices',
            ],
            'contents' => [
                'slug' => 'module_order_invoices',
                'type' => 'module',
                'title_key' => 'lang:module_order_invoices',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'module_order_invoices',
                'local' => 'french',
                'title' => 'Commandes et factures',
                'content' => '',
            ],
        ],
        [
            'modules' => [
                'slug' => 'contract',
                'permission' => 'backoffice.modules.contract',
                'title_key' => 'module_contract',
            ],
            'contents' => [
                'slug' => 'module_contract',
                'type' => 'module',
                'title_key' => 'lang:module_contract',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'module_contract',
                'local' => 'french',
                'title' => 'Contrats',
                'content' => '',
            ],
        ],
        // Logs payment
        [
            'modules' => [
                'slug' => 'payment',
                'permission' => 'backoffice.modules.payment',
                'title_key' => 'location_payment',
            ],
            'contents' => [
                'slug' => 'location_payment',
                'type' => 'location',
                'title_key' => 'lang:location_payment',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'location_payment',
                'local' => 'french',
                'title' => 'Paiement en ligne',
                'content' => '',
            ],
        ],
        // Logs historique paiement
        [
            'modules' => [
                'slug' => 'payment_history',
                'permission' => 'backoffice.modules.payment',
                'title_key' => 'location_payment_history',
            ],
            'contents' => [
                'slug' => 'location_payment_history',
                'type' => 'location',
                'title_key' => 'lang:location_payment_history',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'location_payment_history',
                'local' => 'french',
                'title' => 'Historique des paiements en ligne',
                'content' => '',
            ],
        ],
        // Logs contract
        [
            'modules' => [
                'slug' => 'contract',
                'permission' => 'backoffice.modules.contract',
                'title_key' => 'location_contract',
            ],
            'contents' => [
                'slug' => 'location_contract',
                'type' => 'location',
                'title_key' => 'lang:location_contract',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'location_contract',
                'local' => 'french',
                'title' => 'Autres documents contractuels',
                'content' => '',
            ],
        ],
    ];

    protected $permissions = [
        'backoffice.modules.payment.view',
        'backoffice.modules.payment.delete',
        'backoffice.modules.shipping.view',
        'backoffice.modules.shipping.delete',
        'backoffice.modules.shipping_tracking.view',
        'backoffice.modules.shipping_slips.view',
        'backoffice.modules.shipping_slips.download',
    ];

    protected $rolesToUpdate = [
        'developer',
        'administrator',
    ];

    public function up()
    {
        foreach ($this->modules as $module) {
            foreach ($module as $table => $content) {
                try {
                    $this->insert($table, $content);
                } catch (\Exception $e) {
                    echo 'La ligne n\'a pas été insérée, car elle existe déjà !' . PHP_EOL . $e->getMessage() . PHP_EOL;
                }
            }
        }

        foreach ($this->rolesToUpdate as $role_id) {
            foreach ($this->permissions as $permission) {
                try {
                    $this->insert('roles_permissions', ['role_id' => $role_id, 'permission_name' => $permission]);
                } catch (\Exception $e) {
                    echo 'La permission ' . $permission . ' n\'a pas été insérée !' . PHP_EOL . $e->getMessage() . PHP_EOL;
                }
            }
        }
    }

    public function down()
    {
        foreach ($this->modules as $module) {
            foreach ($module as $table => $content) {
                if ($table !== 'contents_translations') {
                    $this->execute('DELETE FROM ' . $table . ' WHERE slug LIKE "' . $content['slug'] . '"');
                } else {
                    $this->execute('DELETE FROM ' . $table . ' WHERE content_slug LIKE "' . $content['content_slug'] . '"');
                }
            }
        }

        $this->execute("DELETE FROM roles_permissions WHERE permission_name IN (" . implode(
            ',',
            array_map(
                function ($elem) {
                    return "'$elem'";
                },
                $this->permissions
            )
        ) . ")");
    }
}
