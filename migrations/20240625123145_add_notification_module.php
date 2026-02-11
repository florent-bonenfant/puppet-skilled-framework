<?php

class AddNotificationModule extends PuppetSkilledMigration
{
    public function up()
    {
        $this->insert('modules', [
            [
                'slug'             => 'notification',
                'permission'       => '',
                'front_permission' => 'webservice.notification',
                'title_key'        => 'module_notification'
            ],
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM modules WHERE slug = "notification"');
    }
}
