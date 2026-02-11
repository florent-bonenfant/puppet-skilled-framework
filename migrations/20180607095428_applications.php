<?php


//use Phinx\Db\Adapter\MysqlAdapter;

class Applications extends PuppetSkilledMigration
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
        $applications = $this->table('applications', ['id' => false, 'primary_key' => ['id']]);
        $applications->addColumn('id', 'string', ['limit' => 36])
                     ->addColumn('label', 'string', ['null' => false, 'limit' => 255])
                     ->addColumn('created_by', 'string', ['null' => true, 'limit' => 36])
                     ->addColumn('updated_by', 'string', ['null' => true, 'limit' => 36])
                     ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                     ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                     ->addColumn('deleted_at', 'datetime', ['null' => true])
                     ->addForeignKey('created_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                     ->addForeignKey('updated_by', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
                     ->create();

        $applications_families = $this->table('applications_families', ['id' => false, 'primary_key' => ['id']]);
        $applications_families->addColumn('id', 'string', ['limit' => 36])
                              ->addColumn('application_id', 'string', ['null' => false])
                              ->addColumn('family_id', 'string', ['null' => false])
                              ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                              ->addForeignKey('application_id', 'applications', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                              ->addForeignKey('family_id', 'families', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                              ->create();

        $application_links = $this->table('applications_links', ['id' => false, 'primary_key' => ['id']]);
        $application_links->addColumn('id', 'string', ['limit' => 36])
                          ->addColumn('application_id', 'string', ['null' => false, 'limit' => 36])
                          ->addColumn('company_id', 'string', ['null' => false, 'limit' => 36])
                          ->addColumn('platform', 'string', ['limit' => 36])
                          ->addColumn('platform_label', 'string', ['limit' => 255])
                          ->addColumn('link', 'text')
                          ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                          ->addColumn('updated_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                          ->addForeignKey('application_id', 'applications', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                          ->addForeignKey('company_id', 'companies', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                          ->create();


        $this->insert('modules', [
            'slug' => 'application',
            'permission' => 'backoffice.modules.application',
            'title_key' =>  'module_application',
        ]);

        $this->insert('contents', [
            'slug' => 'module_application',
            'type' => 'module',
            'title_key' => 'lang:module_application',
            'active' => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'module_application',
            'local' => 'french',
            'title' =>  'Applications',
            'content' => '',
        ]);
    }
}
