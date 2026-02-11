<?php

class UpdateTableLog extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('logs')
            ->addColumn('admin_id', 'string', [
                'null' => true,
                'limit' => 36,
                'comment' => 'Adminisrateur ayant réalisé l\'action'
            ])
            ->addForeignKey('admin_id', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->save();
    }
}
