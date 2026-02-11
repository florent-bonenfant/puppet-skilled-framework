<?php
class ContratNavigation extends PuppetSkilledMigration
{
    public function up()
    {
        $this->insert('contents', [
            'slug'      => 'email_contrats_sync',
            'type'      => 'email',
            'title_key' => 'Email de notification d\'une synchronisation des autres documents contractuels',
            'active'    => 1
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'email_contrats_sync',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'customer_code', 'front_url']),
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'email_contrats_sync',
            'local' => 'french',
            'title' => '[Guinot - Mary Cohr] Synchronisation des autres documents contractuels terminée',
            'content' => 'La synchronisation des autres documents contractuels est achevée.
Pour accéder à la gestion des autres documents contractuels, cliquez sur le lien suivant :
[Accéder à l\'extranet Guinot]({{front_url}})',
        ]);


        $this->execute('UPDATE modules SET permission="backoffice.modules.contrat", title_key="module_contrat" WHERE slug="contrat"');

        $this->insert('contents', [
            'slug' => 'module_contrat',
            'type' => 'module',
            'title_key' => 'lang:module_contrat',
            'active' => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'module_contrat',
            'local' => 'french',
            'title' =>  'Autres documents contractuels',
            'content' => '',
        ]);

    }

    public function down()
    {
        $this->execute('UPDATE modules SET permission="", title_key="contrat" WHERE slug="contrat"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "module_contrat"');
        $this->execute('DELETE FROM contents WHERE slug = "module_contrat"');

        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_contrats_sync"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_contrats_sync"');
        $this->execute('DELETE FROM contents WHERE slug = "email_contrats_sync"');
    }
}
