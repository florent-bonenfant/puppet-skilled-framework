<?php

class AddPermissionRoleBanner extends PuppetSkilledMigration
{
    protected $permission = 'backoffice.configuration.banner';
    protected $rolesToUpdate = [
        'developer',
        'administrator',
        'manager',
    ];

    public function up()
    {
        $this->table('banners', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['limit' => 36])
            ->addColumn('file_name', 'string', ['length' => 255, 'null' => false])
            ->addColumn('original_file_name', 'string', ['length' => 255, 'null' => false])
            ->addColumn('mime', 'string', ['length' => 100, 'null' => true])
            ->addColumn('title', 'string', ['length' => 255, 'null' => true])
            ->addColumn('company_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('created_by', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('updated_by', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('deleted_at', 'datetime', ['null' => true])
            ->addForeignKey('created_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('updated_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('company_id', 'companies', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
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

        $this->table('banners')->drop();
    }
}
