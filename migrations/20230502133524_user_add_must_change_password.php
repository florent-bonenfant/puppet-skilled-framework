<?php

class UserAddMustChangePassword extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('users')
        ->addColumn('must_change_password', 'boolean', [
            'default' => 0,
            'null'   => false,
            'after' => 'password_reset_datetime'
        ])
        ->update();
    }
}
