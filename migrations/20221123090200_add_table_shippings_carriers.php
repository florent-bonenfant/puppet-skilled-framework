<?php


class AddTableShippingsCarriers extends PuppetSkilledMigration
{
    protected $permission = 'backoffice.configuration.carrier';
    protected $rolesToUpdate = [
        'developer',
        'administrator',
        'manager',
    ];

    public function up()
    {
        $this->table('shippings_carriers', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['limit' => 36])
            ->addColumn('label', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('slug', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('link', 'text')
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $carriers = [
            [
                'id' => $this->uuid(),
                'label' => 'CHRONOPOST',
                'slug' => 'CHRONOPOST',
                'link' => 'http://www.fr.chronopost.com/web/fr/tracking/suivi_inter.jsp?listeNumeros=%NUM_COLIS%',
            ],
            [
                'id' => $this->uuid(),
                'label' => 'TNT',
                'slug' => 'TNT',
                'link' => 'http://www.tnt.com/webtracker/tracker.do?cons=%NUM_COLIS%&trackType=CON&saveCons=N',
            ],
        ];

        $this->insert('shippings_carriers', $carriers);

        foreach ($this->rolesToUpdate as $role_id) {
            try {
                $this->insert('roles_permissions', ['role_id' => $role_id, 'permission_name' => $this->permission]);
            } catch (\Exception $e) {
                echo 'La permission ' . $this->permission . ' n\'a pas été insérée !' . PHP_EOL . $e->getMessage() . PHP_EOL;
            }
        }

        $this->table('shippings')
            ->addColumn('carrier_id', 'string', ['limit' => 36, 'null' => true, 'after'  => 'institut_id',])
            ->addColumn('date', 'date', ['null' => true, 'after'  => 'shipping_number'])
            ->addForeignKey('carrier_id', 'shippings_carriers', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->update();

        $this->table('shippings_trackings', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['limit' => 36])
            ->addColumn('customer_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('institut_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('order_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('carrier_id', 'string', ['limit' => 36, 'null' => true])
            ->addColumn('number', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('date', 'date', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('institut_id', 'instituts', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('carrier_id', 'shippings_carriers', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        $this->table('shippings_slips', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['limit' => 36])
            ->addColumn('customer_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('institut_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('order_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('number', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('date', 'date', ['null' => true])
            ->addColumn('filename', 'string', ['null' => true, 'limit' => 255])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('institut_id', 'instituts', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();
    }

    public function down()
    {
        $this->execute('DELETE FROM roles_permissions WHERE permission_name = "' . $this->permission . '"');
        $shippings = $this->table('shippings');
        $shippings->dropForeignKey('carrier_id')->save();
        $shippings->removeColumn('carrier_id')
            ->removeColumn('date')
            ->save();
        $this->table('shippings_carriers')->drop();
        $this->table('shippings_slips')->drop();
        $this->table('shippings_trackings')->drop();
    }
}
