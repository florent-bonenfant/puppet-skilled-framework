<?php

class UpdateTableUsers extends PuppetSkilledMigration
{
    public function up()
    {
        $users = $this->table('users');
        $users->changeColumn('first_name', 'string', ['limit' => 255, 'null' => true])
            ->changeColumn('last_name', 'string', ['limit' => 255, 'null' => true])
            ->update();
    }

    public function down()
    {
        $users = $this->table('users');
        $users->changeColumn('first_name', 'string', ['limit' => 255, 'null' => false])
            ->changeColumn('last_name', 'string', ['limit' => 255, 'null' => false])
            ->save();
    }
}
