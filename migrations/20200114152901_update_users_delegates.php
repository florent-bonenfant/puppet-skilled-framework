<?php

class UpdateUsersDelegates extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('users_delegates', [
            'id'          => false,
            'primary_key' => ['id'],
        ])
            ->addColumn('id', 'string', [
                'length' => 36,
                'null'   => false,
            ])
            ->addColumn('user_id', 'string', [
                'length' => 36,
                'null'   => false,
                'after'  => 'id',
            ])
            ->addColumn('parent_user_id', 'string', [
                'length' => 36,
                'null'   => false,
                'after'  => 'user_id',
            ])
        ->create();

        $this->table('users_delegates')
            ->addForeignKey('user_id', 'users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('parent_user_id', 'users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addIndex(['user_id'], [
                'unique' => false,
            ])
            ->addIndex(['parent_user_id'], [
                'unique' => false,
            ])
            ->addIndex(['user_id', 'parent_user_id'], [
                'unique' => true,
            ])
        ->save();

        $previous_data = $this->fetchAll('
            SELECT u.id AS user_id, u.parent_user AS parent_user_id, c.id AS customer_id
            FROM `users` AS u, `users` AS p
            LEFT JOIN `customers` AS c ON c.email = p.email
            WHERE u.parent_user IS NOT NULL
            AND u.parent_user = p.id
        ');
        $rows = [];

        foreach ($previous_data as $data) {
            $rows[] = [
                'id'             => $this->uuid(),
                'user_id'        => $data['user_id'],
                'parent_user_id' => $data['parent_user_id'],
            ];
        }

        $this->table('users_delegates')->insert($rows)->save();
        $this->table('users')->dropForeignKey('parent_user')->save();
        $this->table('users')->removeColumn('parent_user')->save();
    }

    public function down()
    {
        $this->table('users')
            ->addColumn('parent_user', 'string', [
                'length' => 36,
                'null'   => true,
                'after'  => 'id',
            ])
            ->addForeignKey('parent_user', 'users', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ])
            ->save();

        $previous_data = $this->fetchAll('SELECT user_id, parent_user_id FROM users_delegates');

        foreach ($previous_data as $data) {
            $this->execute("
                UPDATE `users`
                SET parent_user = '{$data['parent_user_id']}'
                WHERE id = '{$data['user_id']}'
            ");
        }

        $this->table('users_delegates')->drop();
    }
}
