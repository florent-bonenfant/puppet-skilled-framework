<?php
class Shippings extends PuppetSkilledMigration
{
    public function up()
    {
        $shippings = $this->table('shippings', ['id' => false, 'primary_key' => ['id']])
                       ->addColumn('id', 'string', ['limit' => 36])
                       ->addColumn('customer_id', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('institut_id', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('shipping_number', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('file_name', 'string', ['null' => true, 'limit' => 255])
                       ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                       ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                       ->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                       ->addForeignKey('institut_id', 'instituts', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                       ->create();


        $shippings_invoices = $this->table('shippings_invoices', ['id' => false, 'primary_key' => ['id']])
                                ->addColumn('id', 'string', ['null' => false, 'limit' => 36])
                                ->addColumn('shipping_id', 'string', ['null' => false, 'limit' => 36])
                                ->addColumn('invoice_id', 'string', ['null' => false, 'limit' => 36])
                                ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                                ->addForeignKey('shipping_id', 'shippings', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                                ->addForeignKey('invoice_id', 'invoices', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                                ->create();


        $this->insert('contents', [
            'slug'      => 'email_shippings_sync',
            'type'      => 'email',
            'title_key' => 'Email de notification d\'une synchronisation des bons de livraison',
            'active'    => 1
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'email_shippings_sync',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'customer_code', 'front_url']),
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'email_shippings_sync',
            'local' => 'french',
            'title' => '[Guinot - Mary Cohr] Synchronisation des bons de livraison terminée',
            'content' => 'La synchronisation des bons de livraison est achevée.
Pour accéder à la gestion des bons de livraison, cliquez sur le lien suivant :
[Accéder à l\'extranet Guinot]({{front_url}})',
        ]);



        $this->insert('contents', [
            'slug'      => 'notification_new_shipping',
            'type'      => 'notification',
            'title_key' => 'Notification de nouveau bon de livraison',
            'active'    => 1
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'notification_new_shipping',
            'key' => 'variables',
            'value' => serialize(['customer_first_name', 'customer_last_name']),
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'notification_new_shipping',
            'local' => 'french',
            'title' => 'Nouveau bon de livraison',
            'content' => 'Bonjour {{user_first_name}} {{user_last_name}},

Un nouveau bon de livraison est disponible dans votre espace personnel.',
        ]);



        $this->insert('modules', [
            'slug' => 'shipping',
            'permission' => 'backoffice.modules.shipping',
            'title_key' =>  'module_shipping',
        ]);

        $this->insert('contents', [
            'slug' => 'module_shipping',
            'type' => 'module',
            'title_key' => 'lang:module_shipping',
            'active' => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'module_shipping',
            'local' => 'french',
            'title' =>  'Bons de livraison',
            'content' => '',
        ]);
    }

    public function down()
    {
        $this->execute('DROP TABLE shippings_invoices');
        $this->execute('DROP TABLE shippings');

        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_shippings_sync"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_shippings_sync"');
        $this->execute('DELETE FROM contents WHERE slug = "email_shippings_sync"');

        $this->execute('DELETE FROM contents_metas WHERE content_slug = "notification_new_shipping"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "notification_new_shipping"');
        $this->execute('DELETE FROM contents WHERE slug = "notification_new_shipping"');

        $this->execute('DELETE FROM modules WHERE slug = "shipping"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "module_shipping"');
        $this->execute('DELETE FROM contents WHERE slug = "module_shipping"');
    }
}
