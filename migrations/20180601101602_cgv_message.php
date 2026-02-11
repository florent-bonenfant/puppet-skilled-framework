<?php


use Phinx\Db\Adapter\MysqlAdapter;

class CgvMessage extends PuppetSkilledMigration
{
    public function up()
    {
        // Add notification test
        $this->insert('contents', [
            'slug' => 'notification_new_cgv',
            'type' => 'notification',
            'title_key' => 'Notification de nouvelles conditions générales de vente',
            'active' => 1
        ]);
        $this->insert('contents_translations', [
            'content_slug' => 'notification_new_cgv',
            'local' => 'french',
            'title' =>  'Nouvelles conditions générales de vente',
            'content' => 'Bonjour {{user_first_name}} {{user_last_name}},

De nouvelles conditions générales de vente sont disponibles dans votre espace personnel.',
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'notification_new_cgv',
            'key' => 'variables',
            'value' => serialize(['customer_first_name', 'customer_last_name']),
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM contents WHERE slug = "notification_new_cgv"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "notification_new_cgv"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "notification_new_cgv"');
    }
}
