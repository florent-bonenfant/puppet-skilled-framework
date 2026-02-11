<?php

class CgvNewPublication extends PuppetSkilledMigration
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
            'slug'      => 'email_new_cgv',
            'type'      => 'email',
            'title_key' => 'Notification de nouvelles CGV',
            'active'    => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'email_new_cgv',
            'local'        => 'french',
            'title'        => 'Notification de nouvelles CGV',
            'content'      => "Bonjour {{user_first_name}} {{user_last_name}}, de nouvelles conditions générales de vente sont disponibles dans votre espace personnel.\r\n\r\nVous pouvez y accéder en consultant le lien suivant : <a href=\"{{front_url}}\" target=\"_blank\">{{front_url}}</a>",
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'email_new_cgv',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'front_url']),
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM contents WHERE slug = "email_new_cgv"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_new_cgv"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_new_cgv"');
    }
}
