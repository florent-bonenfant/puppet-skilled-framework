<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddAccessRestrictionBeforeClosure extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('customers')
            ->addColumn('restriction', 'integer', [
                'null' => false,
                'default' => 0,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'active',
                'comment' => "Compte client fermé, accès restreint pendant 1an",
            ])
            ->addColumn('closing_date', 'date', [
                'null' => true,
                'default' => null,
                'after' => 'restriction',
                'comment' => "Date de fermeture définitive",
            ])
            ->save();

        $this->insert('contents', [
            'slug' => 'email_alert_closing_account',
            'type' => 'email',
            'title_key' => 'Email Alerte suppression de compte',
            'active' => 1,
        ]);
        $this->insert('contents_translations', [
            'content_slug' => 'email_alert_closing_account',
            'local' => 'french',
            'title' => '[Portail Client Guinot - Mary Cohr] Suppression dans 7 jours de votre compte client.',
            'content' => "Bonjour {{user_first_name}},\r\n\r\nVotre compte client {{customer_code}} va être definitivement fermé le {{date_fermeture_extranet}} . Pensez à télécharger vos factures.\r\n\r\nPour vous connecter, cliquez sur le bouton ci-dessous :\r\n\r\n[Se connecter à l'application]({{front_url}})",
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'email_alert_closing_account',
            'key' => 'variables',
            'value' => serialize(['customer_code', 'user_first_name', 'user_last_name', 'user_email', 'date_fermeture_extranet', 'front_url']),
        ]);
    }

    public function down()
    {
        $this->table('customers')
            ->removeColumn('restriction')
            ->removeColumn('closing_date')
            ->save();

        $this->execute('DELETE FROM contents WHERE slug = "email_alert_closing_account"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_alert_closing_account"');
        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_alert_closing_account"');

    }
}
