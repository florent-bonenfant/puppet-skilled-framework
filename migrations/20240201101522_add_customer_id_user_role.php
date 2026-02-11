<?php

class AddCustomerIdUserRole extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('users_delegates')
            ->addColumn('customer_id', 'string', [
                'null' => true,
                'limit' => 36
            ])
            ->addForeignKey('customer_id', 'customers', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ])
            ->update();

        $previous_data = $this->fetchAll('select ur.customer_id, u.email, u.id from users u
            inner join users_roles ur on ur.user_id = u.id and ur.role_id like "customer" and ur.customer_id LIKE "PY%"
            where u.id in
            (select parent_user_id from users_delegates where customer_id is null)');

        // Intégration des customer_id
        foreach ($previous_data as $data) {
            $this->execute("
                    UPDATE `users_delegates`
                    SET customer_id = '{$data['customer_id']}'
                    WHERE parent_user_id = '{$data['id']}'
                ");
        }
    }

    public function down()
    {
        $this->table('users_delegates')
            ->dropForeignKey('customer_id')
            ->save();
        $this->table('users_delegates')
            ->removeColumn('customer_id')
            ->update();
    }
}
