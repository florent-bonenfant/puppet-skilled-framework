<?php

class ProfileDelegate extends PuppetSkilledMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */


    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('parent_user', 'string', ['length' => 36, 'null' => true, 'after' => 'id'])
              ->addForeignKey('parent_user', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
              ->save();

        $modules = $this->table('modules');
        $modules->addColumn('front_permission', 'string', ['length' => 255, 'null' => true, 'after' => 'permission'])
                ->save();

        $this->execute("UPDATE modules SET front_permission = 'webservice.application' WHERE permission = 'backoffice.modules.application'");
        $this->execute("UPDATE modules SET front_permission = 'webservice.cgv' WHERE permission = 'backoffice.modules.cgv'");
        $this->execute("UPDATE modules SET front_permission = 'webservice.commercial_condition' WHERE permission = 'backoffice.modules.commercial_condition'");
        $this->execute("UPDATE modules SET front_permission = 'webservice.furniture' WHERE permission = 'backoffice.modules.furniture'");
        $this->execute("UPDATE modules SET front_permission = 'webservice.invoice' WHERE permission = 'backoffice.modules.invoice'");
        $this->execute("UPDATE modules SET front_permission = 'webservice.message' WHERE permission = 'backoffice.modules.message'");
    }

    public function down()
    {
        $users = $this->table('users');
        $users->dropForeignKey('parent_user')
              ->removeColumn('parent_user', 'string', ['length' => 36, 'null' => true, 'after' => 'id'])
              ->save();

        $modules = $this->table('modules');
        $modules->removeColumn('front_permission')
                ->save();
    }
}
