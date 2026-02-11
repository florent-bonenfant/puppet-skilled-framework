<?php
class Instituts extends PuppetSkilledMigration
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
        $instituts = $this->table('instituts', ['id' => false, 'primary_key' => ['id']])
                          ->addColumn('id', 'string', ['limit' => 36])
                          ->addColumn('customer_id', 'string', ['null' => true, 'limit' => 36])
                          ->addColumn('name', 'string', ['limit' => 255])
                          ->addColumn('address', 'string', ['limit' => 255])
                          ->addColumn('address2', 'string', ['limit' => 255])
                          ->addColumn('postcode', 'string', ['limit' => 5])
                          ->addColumn('city', 'string', ['limit' => 255])
                          ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                          ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                          ->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                          ->create();

        $inst_times = $this->table('institut_times', ['id' => false, 'primary_key' => ['id']])
                           ->addColumn('id', 'string', ['limit' => 36])
                           ->addColumn('institut_id', 'string', ['null' => true, 'limit' => 36])
                           ->addColumn('day_of_week', 'integer')
                           ->addColumn('start_time', 'time')
                           ->addColumn('end_time', 'time')
                           ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                           ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                           ->addForeignKey('institut_id', 'instituts', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                           ->create();

    }
}
