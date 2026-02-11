<?php

class Contrats extends PuppetSkilledMigration
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
        $contrats = $this->table('contrats', ['id' => false, 'primary_key' => ['id']])
                       ->addColumn('id', 'string', ['limit' => 36])
                       ->addColumn('customer_id', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('company_id', 'string', ['null' => true, 'limit' => 36])
                       ->addColumn('city', 'string', ['limit' => 255])
                       ->addColumn('file_name', 'string', ['limit' => 255])
                       ->addColumn('original_file_name', 'string', ['limit' => 255])
                       ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                       ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                       ->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                       ->addForeignKey('company_id', 'companies', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                       ->create();

        $this->insert('modules', [
            [
                'slug'             => 'contrat',
                'permission'       => '',
                'front_permission' => 'webservice.contrat',
                'title_key'        => 'contrat'
            ],
        ]);
    }
}
