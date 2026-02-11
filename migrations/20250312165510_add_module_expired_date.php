<?php


class AddModuleExpiredDate extends PuppetSkilledMigration
{
    protected $permission = 'webservice.expired_date';
    protected $modules = [
        // suivi
        [
            'modules' => [
                'slug' => 'expired_date',
                'permission' => '',
                'front_permission' => 'webservice.expired_date',
                'title_key' => 'expired_date',
            ],
            'contents' => [
                'slug' => 'expired_date',
                'type' => 'location',
                'title_key' => 'lang:expired_date',
                'active' => 1,
            ],
            'contents_translations' => [
                'content_slug' => 'expired_date',
                'local' => 'french',
                'title' => 'Date d\'expiration des lots',
                'content' => '',
            ],
        ],
    ];

    public function up()
    {
        $this->execute('DELETE FROM roles_permissions WHERE permission_name = "' . $this->permission . '"');
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
