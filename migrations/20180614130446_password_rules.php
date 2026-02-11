<?php


//use PuppetSkilledMigration;

class PasswordRules extends PuppetSkilledMigration
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
        $users = $this->table('users');
        $users->addColumn('login_tries', 'integer', ['null' => true, 'after' => 'password_reset_datetime'])
              ->update();

        $settings = $this->table('settings');
        $settings->insert([
            'name' => 'authentication.allowed_login_tries',
            'value' => 3,
            'autoload' => 1,
        ]);
        $settings->saveData();

        // Add reset password text
        $this->insert('contents', [
            'slug'      => 'password_reset_text',
            'type'      => 'page',
            'title_key' => 'Réinitialisation de mot de passe',
            'active'    => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'password_reset_text',
            'local'        => 'french',
            'title'        => 'Réinitialisation de mot de passe',
            'content'      => 'Votre compte a été bloqué car vous avez tenté de vous connecter plusieurs fois avec des identifiants incorrects. Veuillez réinitialiser votre mot de passe pour débloquer votre compte.',
        ]);
    }

    public function down()
    {
        $users = $this->table('users');
        $users->removeColumn('login_tries')
              ->save();

        $this->execute('DELETE FROM settings WHERE name = "authentication.allowed_login_tries"');
        $this->execute('DELETE FROM contents WHERE slug = "password_reset_text"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "password_reset_text"');
    }
}
