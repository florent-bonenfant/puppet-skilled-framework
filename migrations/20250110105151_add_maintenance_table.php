<?php

class AddMaintenanceTable extends PuppetSkilledMigration
{
    protected $permissions = [
        'backoffice.configuration.maintenance',
    ];

    protected $rolesToUpdate = [
        'developer',
        'administrator',
    ];

    public function up()
    {
        $this->table('maintenances', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['null' => false, 'limit' => 36])
            ->addColumn('user_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('message', 'string', ['null' => false, 'limit' => 256])
            ->addColumn('starts_on', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('ends_on', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['user_id', 'message'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();

        foreach ($this->rolesToUpdate as $role_id) {
            foreach ($this->permissions as $permission) {
                try {
                    $this->insert('roles_permissions', ['role_id' => $role_id, 'permission_name' => $permission]);
                } catch (\Exception $e) {
                    echo 'La permission ' . $permission . ' n\'a pas été insérée !' . PHP_EOL . $e->getMessage() . PHP_EOL;
                }
            }
        }
    }

    public function down()
    {
        $this->execute("DELETE FROM roles_permissions WHERE permission_name IN (" . implode(
            ',',
            array_map(
                function ($elem) {
                    return "'$elem'";
                },
                $this->permissions
            )
        ) . ")");

        $this->table('maintenances')->drop();
    }
}
