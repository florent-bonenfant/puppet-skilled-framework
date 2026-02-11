<?php

class AddExpiredDateTable extends PuppetSkilledMigration
{
    protected $permission = 'webservice.expired_date';
    protected $rolesToUpdate = [
        'developer',
        'administrator',
        'manager',
        'customer',
    ];

    public function up()
    {
        $this->table('expired_dates', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['limit' => 36])
            ->addColumn('company_id', 'string', ['null' => false, 'limit' => 36])
            ->addColumn('product_code', 'string', ['null' => false, 'limit' => 36])
            ->addColumn('lot_number', 'string', ['null' => false, 'limit' => 36])
            ->addColumn('libelle_fr', 'string', ['null' => false, 'limit' => 255])
            ->addColumn('date_peremption', 'date', ['null' => true, 'default' => null])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])

            ->addForeignKey('company_id', 'companies', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addIndex(['product_code', 'lot_number'], [
                'unique' => true,
            ])
            ->create();

        foreach ($this->rolesToUpdate as $role_id) {
            try {
                $this->insert('roles_permissions', ['role_id' => $role_id, 'permission_name' => $this->permission]);
            } catch (\Exception $e) {
                echo 'La permission ' . $this->permission . ' n\'a pas été insérée !' . PHP_EOL . $e->getMessage() . PHP_EOL;
            }
        }
    }

    public function down()
    {
        $this->execute('DELETE FROM roles_permissions WHERE permission_name = "' . $this->permission . '"');
        $this->table('expired_dates')->drop();
    }
}
