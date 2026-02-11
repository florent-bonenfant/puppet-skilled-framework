<?php

class InstitutStatisticAcl extends PuppetSkilledMigration
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
    public function change()
    {

        $this->insert('modules', [
            ['slug' => 'statistic', 'permission' => '', 'front_permission' => 'webservice.statistic', 'title_key' => 'statistic'],
            ['slug' => 'institut', 'permission' => '', 'front_permission' => 'webservice.institut', 'title_key' => 'institut'],
        ]);
    }
}
