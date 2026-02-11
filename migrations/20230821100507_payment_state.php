<?php

class PaymentState extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('companies')
            ->addColumn('slug', 'string', ['limit' => 255, ])
            ->update();

        $previous_data = $this->fetchAll('SELECT * FROM `companies`;');
        foreach ($previous_data as $data) {
            $name = str_replace(' ', '_', strtolower($data['name']));
            $this->execute("
                UPDATE `companies`
                SET slug = '{$name}'
                WHERE id = '{$data['id']}'
            ");
        }

        $this->table('payments', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', ['limit' => 36])
            ->addColumn('stripe_id', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('customer_id', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('state', 'string', ['null' => true, 'limit' => 255])
            ->addColumn('amount', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('created_by', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('updated_by', 'string', ['null' => true, 'limit' => 36])
            ->addColumn('created_at', 'datetime', ['null' => false,])
            ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('created_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('updated_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();
    }

    public function down()
    {
        $this->table('payments')->drop();
        $this->table('companies')->removeColumn('slug')->update();
    }
}
