<?php

use Phinx\Db\Adapter\MysqlAdapter;

class ChangeRulesForRestrictCustomer extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('customers')
            ->addColumn('restrict_access_date', 'date', [
                'null' => true,
                'default' => null,
                'after' => 'active',
                'comment' => "Compte client fermé, accès restreint pendant 1an",
            ])
            ->removeColumn('restriction')
            ->save();
    }

    public function down()
    {
        $this->table('customers')
            ->removeColumn('restrict_access_date')
            ->addColumn('restriction', 'integer', [
                'null' => false,
                'default' => 0,
                'limit' => MysqlAdapter::INT_TINY,
                'after' => 'active',
                'comment' => "Compte client fermé, accès restreint pendant 1an",
            ])
            ->save();
    }

}
