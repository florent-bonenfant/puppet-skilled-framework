<?php

class UpdateTableLogToPersistData extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('logs')
            ->addColumn('first_name', 'string', [
                'null' => true,
                'limit' => 255,
                'after' => 'customer_id'
            ])
            ->addColumn('last_name', 'string', [
                'null' => true,
                'limit' => 255,
                'after' => 'first_name'
            ])
            ->addColumn('email', 'string', [
                'null' => false,
                'limit' => 255,
                'after' => 'last_name'
            ])
            ->addColumn('city', 'string', [
                'null' => true,
                'limit' => 255,
                'after' => 'email'
            ])
            ->addColumn('family_id', 'string', [
                'null' => true,
                'limit' => 36,
                'after' => 'city'
            ])
            ->addColumn('company_id', 'string', [
                'null' => true,
                'limit' => 36,
                'after' => 'family_id'
            ])
            ->addForeignKey('family_id', 'families', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ])
            ->addForeignKey('company_id', 'companies', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ])
            ->save();
    }
}
