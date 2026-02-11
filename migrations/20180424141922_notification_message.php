<?php

use Phinx\Db\Adapter\MysqlAdapter;

class NotificationMessage extends PuppetSkilledMigration
{

    public function up()
    {
        // Add notification test
        $this->insert('contents', [
            'slug' => 'notification_new_message',
            'type' => 'notification',
            'title_key' => 'Notification de nouveau message',
            'active' => 1
        ]);
        $this->insert('contents_translations', [
            'content_slug' => 'notification_new_message',
            'local' => 'french',
            'title' =>  'Nouveau message',
            'content' => 'Bonjour {{user_first_name}} {{user_last_name}},

Un nouveau message est disponible dans votre espace personnel.',
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'notification_new_message',
            'key' => 'variables',
            'value' => serialize(['customer_first_name', 'customer_last_name']),
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM contents WHERE slug = "notification_new_message"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "notification_new_message"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "notification_new_message"');
    }
}
