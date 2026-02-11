<?php
class Orders extends PuppetSkilledMigration
{
    public function up()
    {
        $orders = $this->table('orders', ['id' => false, 'primary_key' => ['id']])
                       ->addColumn('id', 'string', ['limit' => 36])
                       ->addColumn('customer_id', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('company_id', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('order_number', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('order_type', 'string', ['limit' => 255])
                       ->addColumn('quantity', 'integer')
                       ->addColumn('date', 'date')
                       ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                       ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                       ->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                       ->addForeignKey('company_id', 'companies', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                       ->create();

        $order_lines = $this->table('order_lines', ['id' => false, 'primary_key' => ['id']])
                            ->addColumn('id', 'string', ['null' => false, 'limit' => 36])
                            ->addColumn('order_id', 'string', ['null' => false, 'limit' => 36])
                            ->addColumn('number', 'string', ['null' => false, 'limit' => 255])
                            ->addColumn('description', 'string', ['limit' => 255])
                            ->addColumn('quantity', 'integer')
                            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                            ->create();


        $orders_invoices = $this->table('orders_invoices', ['id' => false, 'primary_key' => ['id']])
                                ->addColumn('id', 'string', ['null' => false, 'limit' => 36])
                                ->addColumn('order_id', 'string', ['null' => false, 'limit' => 36])
                                ->addColumn('invoice_id', 'string', ['null' => false, 'limit' => 36])
                                ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                                ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                                ->addForeignKey('invoice_id', 'invoices', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                                ->create();


        $this->insert('contents', [
            'slug'      => 'email_orders_sync',
            'type'      => 'email',
            'title_key' => 'Email de notification d\'une synchronisation des bons de commande',
            'active'    => 1
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'email_orders_sync',
            'key' => 'variables',
            'value' => serialize(['user_first_name', 'user_last_name', 'user_email', 'customer_code', 'front_url']),
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'email_orders_sync',
            'local' => 'french',
            'title' => '[Guinot - Mary Cohr] Synchronisation des bons de commande terminée',
            'content' => 'La synchronisation des bons de commande est achevée.
Pour accéder à la gestion des bons de commande, cliquez sur le lien suivant :
[Accéder à l\'extranet Guinot]({{front_url}})',
        ]);



        $this->insert('contents', [
            'slug'      => 'notification_new_order',
            'type'      => 'notification',
            'title_key' => 'Notification de nouveau bon de commande',
            'active'    => 1
        ]);

        $this->insert('contents_metas', [
            'content_slug' => 'notification_new_order',
            'key' => 'variables',
            'value' => serialize(['customer_first_name', 'customer_last_name']),
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'notification_new_order',
            'local' => 'french',
            'title' => 'Nouveau bon de commande',
            'content' => 'Bonjour {{user_first_name}} {{user_last_name}},

Un nouveau bon de commande est disponible dans votre espace personnel.',
        ]);



        $this->insert('modules', [
            'slug' => 'order',
            'permission' => 'backoffice.modules.order',
            'title_key' =>  'module_order',
        ]);

        $this->insert('contents', [
            'slug' => 'module_order',
            'type' => 'module',
            'title_key' => 'lang:module_order',
            'active' => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'module_order',
            'local' => 'french',
            'title' =>  'Bons de commande',
            'content' => '',
        ]);
    }

    public function down()
    {
        $this->execute('DROP TABLE order_lines');
        $this->execute('DROP TABLE orders_invoices');
        $this->execute('DROP TABLE orders');

        $this->execute('DELETE FROM contents_metas WHERE content_slug = "email_orders_sync"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "email_orders_sync"');
        $this->execute('DELETE FROM contents WHERE slug = "email_orders_sync"');

        $this->execute('DELETE FROM contents_metas WHERE content_slug = "notification_new_order"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "notification_new_order"');
        $this->execute('DELETE FROM contents WHERE slug = "notification_new_order"');

        $this->execute('DELETE FROM modules WHERE slug = "order"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "module_order"');
        $this->execute('DELETE FROM contents WHERE slug = "module_order"');
    }
}
