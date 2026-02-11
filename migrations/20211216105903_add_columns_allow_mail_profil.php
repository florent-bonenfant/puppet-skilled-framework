<?php

class AddColumnsAllowMailProfil extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('users')
            ->addColumn('allow_email', 'boolean', [
                'null'   => false,
                'default'   => 1,
                'after'  => 'email'
            ])
            ->addColumn('allow_notification', 'boolean', [
                'null'   => false,
                'default'   => 1,
                'after'  => 'allow_email'
            ])
            ->save();
    }
}
