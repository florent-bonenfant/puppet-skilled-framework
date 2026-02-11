<?php

class NewMessage extends PuppetSkilledMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->insert('contents', [
            'slug'      => 'email_new_message',
            'type'      => 'email',
            'title_key' => 'Notification de nouveau message',
            'active'    => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'email_new_message',
            'local'        => 'french',
            'title'        => 'Notification de nouveau message',
            'content'      => "Bonjour {{user_first_name}} {{user_last_name}}, un nouveau message vous a été adressé dans votre espace personnel.\r\n\r\nVous pouvez y accéder en consultant le lien suivant : <a href=\"{{front_url}}\" target=\"_blank\">{{front_url}}</a>",
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'email_new_message',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'front_url']),
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM contents WHERE slug = "email_new_message"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_new_message"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_new_message"');
    }

}
