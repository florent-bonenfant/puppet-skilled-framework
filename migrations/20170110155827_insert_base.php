<?php

use Phinx\Db\Adapter\MysqlAdapter;

class InsertBase extends PuppetSkilledMigration
{
    public function up()
    {
        $a = $this->insert('companies',[
            ['id' => $this->uuid(), 'name' => 'Guinot'],
            ['id' => $this->uuid(), 'name' => 'Mary Cohr'],
        ]);

        $this->insert('roles', [
            ['id' => 'developer', 'type' => 'default', 'slug' => 'role_developer'],
            ['id' => 'administrator', 'type' => 'default', 'slug' => 'role_admin'],
            ['id' => 'manager', 'type' => 'default', 'slug' => 'role_manager'],
            ['id' => 'customer', 'type' => 'default', 'slug' => 'role_customer', 'resources_support' => serialize(['\App\Service\Secure\Resource\Customer'])],
        ]);

        $roles_permissions = [
            'developer' => [
                'backoffice',
                'frontoffice',
            ],
            'administrator' => [
                'backoffice.user',
                'backoffice.customer',
                'backoffice.modules',
                'backoffice.configuration.setting',
                'backoffice.configuration.content_simple',
                'backoffice.configuration.page',
                'backoffice.configuration.email',
                'backoffice.configuration.notification',
                'frontoffice',
            ],
            'manager' => [],
            'customer' => [
                'webservice',
            ]
        ];

        foreach ($roles_permissions as $role_id => $permissions) {
            foreach ($permissions as $permission) {
                $this->insert('roles_permissions', ['role_id' => $role_id, 'permission_name' => $permission]);
            }
        }

        $user_id = $this->uuid();
        $this->insert('users', [[
            'id' => $user_id,
            'username' => 'developer@globalis-ms.com',
            'password' => '$2y$12$N00f9hL9.pOoTMjqQVAVneiwdnoO/vKGEMXXId9mw/t9LjVPC2l2W', // = guinot
            'first_name' => 'Michel',
            'last_name' => 'Developer',
            'email' => 'developer@globalis-ms.com',
            'language' => 'fr',
            'timezone' => date_default_timezone_get(),
            'date_format' => '%d %B %Y',
            'datetime_format' => '%d %B %Y, %H:%M',
        ]]);

        $this->insert('users_roles', [[
            'id' => $this->uuid(),
            'user_id' => $user_id,
            'role_id' => 'developer',
        ]]);

        $this->output->writeln('<fg=green>Developer user created</>');
        $this->output->writeln('<options=bold>username: developer@globalis-ms.com</>');
        $this->output->writeln('<options=bold>password: guinot</>');

        $this->insert('settings', [
            [
                'name' => 'authentication.expires_reset_password',
                'value' => 3600,
                'autoload' => 0
            ], [
                'name' => 'email.from',
                'value' => 'no-reply@guinot.com',
                'autoload' => 1
            ], [
                'name' => 'email.reply_to',
                'value' => 'no-reply@guinot.com',
                'autoload' => 1
            ],
        ]);

        $this->insert('families', [
            ['id' => $this->uuid(), 'slug' => 'REA'],
            ['id' => $this->uuid(), 'slug' => 'REF'],
            ['id' => $this->uuid(), 'slug' => 'REP'],
        ]);

        $this->insert('modules', [
            ['slug' => 'cgv', 'permission' => 'backoffice.modules.cgv', 'title_key' => 'module_cgv'],
            ['slug' => 'commercial_condition', 'permission' => 'backoffice.modules.commercial_condition', 'title_key' => 'module_commercial_condition'],
            ['slug' => 'furniture', 'permission' => 'backoffice.modules.furniture', 'title_key' => 'module_furniture'],
            ['slug' => 'invoice', 'permission' => 'backoffice.modules.invoice', 'title_key' => 'module_invoice'],
            ['slug' => 'log', 'permission' => 'backoffice.modules.log', 'title_key' => 'module_log'],
            ['slug' => 'message', 'permission' => 'backoffice.modules.message', 'title_key' => 'module_message'],
            ['slug' => 'sale_term', 'permission' => 'backoffice.modules.sale_term', 'title_key' => 'module_sale_term'],
        ]);

        $this->insert('contents', [
            ['slug' => 'email_customers_sync', 'type' => 'email', 'title_key' => 'Email de notification d\'une synchronisation des clients'],
            ['slug' => 'email_furnitures_sync', 'type' => 'email', 'title_key' => 'Email de notification d\'une synchronisation des appareils et meubles'],
            ['slug' => 'email_invoices_sync', 'type' => 'email', 'title_key' => 'Email de notification d\'une synchronisation des factures'],
            ['slug' => 'email_new_customer', 'type' => 'email', 'title_key' => 'Email de notification d\'un nouveau compte client'],
            ['slug' => 'email_new_user', 'type' => 'email', 'title_key' => 'Email de notification d\'un nouveau compte utilisateur'],
            ['slug' => 'email_reset_password', 'type' => 'email', 'title_key' => 'Email de récupération de mot de passe'],
            ['slug' => 'email_unread_notification', 'type' => 'email', 'title_key' => 'Email de notification de nouvelles notifications non lues'],
            ['slug' => 'location_cgv', 'type' => 'location', 'title_key' => 'lang:general_location_cgv'],
            ['slug' => 'location_commercial_condition', 'type' => 'location', 'title_key' => 'lang:general_location_commercial_condition'],
            ['slug' => 'location_furnitures', 'type' => 'location', 'title_key' => 'lang:general_location_furnitures'],
            ['slug' => 'location_homepage', 'type' => 'location', 'title_key' => 'lang:general_location_homepage'],
            ['slug' => 'location_invoices', 'type' => 'location', 'title_key' => 'lang:general_location_invoices'],
            ['slug' => 'location_message', 'type' => 'location', 'title_key' => 'lang:general_location_message'],
            ['slug' => 'module_cgv', 'type' => 'module', 'title_key' => 'lang:module_cgv'],
            ['slug' => 'module_commercial_condition', 'type' => 'module', 'title_key' => 'lang:module_commercial_condition'],
            ['slug' => 'module_furniture', 'type' => 'module', 'title_key' => 'lang:module_furniture'],
            ['slug' => 'module_invoice', 'type' => 'module', 'title_key' => 'lang:module_invoice'],
            ['slug' => 'module_log', 'type' => 'module', 'title_key' => 'lang:module_log'],
            ['slug' => 'module_message', 'type' => 'module', 'title_key' => 'lang:module_message'],
            ['slug' => 'module_sale_term', 'type' => 'module', 'title_key' => 'lang:module_sale_term'],
            ['slug' => 'notification_new_invoice', 'type' => 'notification', 'title_key' => 'Notification de nouvelle facture'],
            ['slug' => 'page_help', 'type' => 'page', 'title_key' => 'Aide utilisateur'],
            ['slug' => 'page_legal_mentions', 'type' => 'page', 'title_key' => 'Mentions légales'],
            ['slug' => 'page_terms_of_use', 'type' => 'page', 'title_key' => 'Conditions générales d\'utilisation'],
            ['slug' => 'REA', 'type' => 'family', 'title_key' => 'lang:REA'],
            ['slug' => 'REF', 'type' => 'family', 'title_key' => 'lang:REF'],
            ['slug' => 'REP', 'type' => 'family', 'title_key' => 'lang:REP'],
            ['slug' => 'role_admin', 'type' => 'role', 'title_key' => 'lang:role_admin'],
            ['slug' => 'role_customer', 'type' => 'role', 'title_key' => 'lang:role_customer'],
            ['slug' => 'role_developer', 'type' => 'role', 'title_key' => 'lang:role_developer'],
            ['slug' => 'role_manager', 'type' => 'role', 'title_key' => 'lang:role_manager'],
            ['slug' => 'text_dashboard', 'type' => 'content_simple', 'title_key' => 'Texte de bienvenue de la page d\'accueil'],
            ['slug' => 'text_dashboard_commercial_condition', 'type' => 'content_simple', 'title_key' => 'Texte du bloc Conditions commerciales de la page d\'accueil'],
            ['slug' => 'text_dashboard_invoice', 'type' => 'content_simple', 'title_key' => 'Texte du bloc Dernières Factures de la page d\'accueil'],
            ['slug' => 'text_dashboard_message', 'type' => 'content_simple', 'title_key' => 'Texte du bloc Dernier message de la page d\'accueil'],
            ['slug' => 'text_eula', 'type' => 'content_simple', 'title_key' => 'Conditions générales d\'utilisation'],
        ]);

        $this->insert('contents_translations', [
            ['content_slug' => 'email_customers_sync', 'local' => 'french', 'title' => '[Guinot - Mary Cohr] Synchronisation des clients terminée', 'content' => ''],
            ['content_slug' => 'email_furnitures_sync', 'local' => 'french', 'title' => '[Guinot - Mary Cohr] Synchronisation des contrats d\'appareils et meubles terminée', 'content' => ''],
            ['content_slug' => 'email_invoices_sync', 'local' => 'french', 'title' => '[Guinot - Mary Cohr] Synchronisation des factures terminée', 'content' => ''],
            ['content_slug' => 'email_new_customer', 'local' => 'french', 'title' => '[Guinot - Mary Cohr] Mise à disposition de votre compte client', 'content' => ''],
            ['content_slug' => 'email_new_user', 'local' => 'french', 'title' => '[Guinot - Mary Cohr] Mise à disposition de votre compte utilisateur', 'content' => ''],
            ['content_slug' => 'email_reset_password', 'local' => 'french', 'title' => '[Guinot - Mary Cohr] Récupération de votre mot de passe', 'content' => ''],
            ['content_slug' => 'email_unread_notification', 'local' => 'french', 'title' => '[Guinot - Mary Cohr] Vous avez des notifications non lues', 'content' => ''],
            ['content_slug' => 'location_cgv', 'local' => 'french', 'title' => 'Conditions générales de vente', 'content' => ''],
            ['content_slug' => 'location_commercial_condition', 'local' => 'french', 'title' => 'Conditions commerciales', 'content' => ''],
            ['content_slug' => 'location_furnitures', 'local' => 'french', 'title' => 'Appareils et meubles', 'content' => ''],
            ['content_slug' => 'location_homepage', 'local' => 'french', 'title' => 'Page d\'accueil', 'content' => ''],
            ['content_slug' => 'location_invoices', 'local' => 'french', 'title' => 'Factures', 'content' => ''],
            ['content_slug' => 'location_message', 'local' => 'french', 'title' => 'Messages', 'content' => ''],
            ['content_slug' => 'module_cgv', 'local' => 'french', 'title' => 'CGV', 'content' => ''],
            ['content_slug' => 'module_commercial_condition', 'local' => 'french', 'title' => 'Conditions Commerciales', 'content' => ''],
            ['content_slug' => 'module_furniture', 'local' => 'french', 'title' => 'Appareils et meubles', 'content' => ''],
            ['content_slug' => 'module_invoice', 'local' => 'french', 'title' => 'Factures', 'content' => ''],
            ['content_slug' => 'module_log', 'local' => 'french', 'title' => 'Logs', 'content' => ''],
            ['content_slug' => 'module_message', 'local' => 'french', 'title' => 'Messages', 'content' => ''],
            ['content_slug' => 'module_sale_term', 'local' => 'french', 'title' => 'Conditions générales de vente', 'content' => ''],
            ['content_slug' => 'notification_new_invoice', 'local' => 'french', 'title' => 'Nouvelle facture', 'content' => ''],
            ['content_slug' => 'page_help', 'local' => 'french', 'title' => 'Aide utilisateur', 'content' => ''],
            ['content_slug' => 'page_legal_mentions', 'local' => 'french', 'title' => 'Mentions légales', 'content' => ''],
            ['content_slug' => 'page_terms_of_use', 'local' => 'french', 'title' => 'Conditions générales d\'utilisation', 'content' => ''],
            ['content_slug' => 'REA', 'local' => 'french', 'title' => 'REPRESENTANT AFFILIE', 'content' => ''],
            ['content_slug' => 'REF', 'local' => 'french', 'title' => 'REPRESENTANTS FRANCHISE', 'content' => ''],
            ['content_slug' => 'REP', 'local' => 'french', 'title' => 'REPRESENTANT TRADITIONNEL', 'content' => ''],
            ['content_slug' => 'role_admin', 'local' => 'french', 'title' => 'Administrateur', 'content' => ''],
            ['content_slug' => 'role_customer', 'local' => 'french', 'title' => 'Client', 'content' => ''],
            ['content_slug' => 'role_developer', 'local' => 'french', 'title' => 'Développeur', 'content' => ''],
            ['content_slug' => 'role_manager', 'local' => 'french', 'title' => 'Gestionnaire module', 'content' => ''],
            ['content_slug' => 'text_dashboard', 'local' => 'french', 'title' => 'Texte de la page d\'accueil', 'content' => ''],
            ['content_slug' => 'text_dashboard_commercial_condition', 'local' => 'french', 'title' => 'Texte du bloc Conditions commerciales de la page d\'accueil', 'content' => ''],
            ['content_slug' => 'text_dashboard_invoice', 'local' => 'french', 'title' => 'Texte du bloc Facture de la page d\'accueil', 'content' => ''],
            ['content_slug' => 'text_dashboard_message', 'local' => 'french', 'title' => 'Texte du bloc Dernier message de la page d\'accueil', 'content' => ''],
            ['content_slug' => 'text_eula', 'local' => 'french', 'title' => 'Texte des conditions générales d\'utilisation', 'content' => ''],
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM users_roles');
        $this->execute('DELETE FROM roles_permissions');
        $this->execute('DELETE FROM roles');
        $this->execute('DELETE FROM users');
        $this->execute('DELETE FROM customers');
        $this->execute('DELETE FROM companies');
        $this->execute('DELETE FROM settings');
        $this->execute('DELETE FROM families');
        $this->execute('DELETE FROM modules');
        $this->execute('DELETE FROM contents');
        $this->execute('DELETE FROM contents_translations');
    }
}
