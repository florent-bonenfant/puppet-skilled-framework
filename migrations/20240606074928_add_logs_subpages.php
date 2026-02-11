<?php


class AddLogsSubpages extends PuppetSkilledMigration
{

    protected $modules = [
        // suivi
        [
            'modules' => [
                'slug' => 'tracking',
                'permission' => 'backoffice.modules.tracking',
                'title_key' => 'location_tracking',
            ],
            'contents' => [
                'slug' => 'location_tracking',
                'type' => 'location',
                'title_key' => 'lang:location_tracking',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'location_tracking',
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
                'title_key' => 'location_shipping_slips',
            ],
            'contents' => [
                'slug' => 'location_shipping_slips',
                'type' => 'location',
                'title_key' => 'lang:location_shipping_slips',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'location_shipping_slips',
                'local' => 'french',
                'title' => 'Bordereaux d\'expédition',
                'content' => '',
            ],
        ],
        // Logs E-training
        [
            'modules' => [
                'slug' => 'application',
                'permission' => 'backoffice.modules.application',
                'title_key' => 'location_application',
            ],
            'contents' => [
                'slug' => 'location_application',
                'type' => 'location',
                'title_key' => 'lang:location_application',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'location_application',
                'local' => 'french',
                'title' => 'Téléchargement E-Training',
                'content' => '',
            ],
        ],
        // Logs statistiques
        [
            'modules' => [
                'slug' => 'statistics',
                'permission' => 'backoffice.modules.payment',
                'title_key' => 'location_statistics',
            ],
            'contents' => [
                'slug' => 'location_statistics',
                'type' => 'location',
                'title_key' => 'lang:location_statistics',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'location_statistics',
                'local' => 'french',
                'title' => 'Statistiques',
                'content' => '',
            ],
        ],
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
    }
}
