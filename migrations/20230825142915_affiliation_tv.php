<?php

class AffiliationTv extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('affiliations', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', [
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('link', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('publication_date', 'date', [
                'null' => true,
            ])
            ->addColumn('display_start', 'date', [
                'null' => true,
            ])
            ->addColumn('display_end', 'date', [
                'null' => true,
            ])
            ->addColumn('created_by', 'string', [
                'null' => true,
                'limit' => 36
            ])
            ->addColumn('updated_by', 'string', [
                'null' => true,
                'limit' => 36
            ])
            ->addColumn('created_at', 'datetime', [
                'null' => true,
            ])
            ->addColumn('updated_at', 'datetime', [
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('deleted_at', 'datetime', [
                'null' => true,
            ])
            ->addForeignKey('created_by', 'users', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ])
            ->addForeignKey('updated_by', 'users', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE'
            ])
            ->create();


        $this->table('affiliation_families', ['id' => false, 'primary_key' => ['affiliation_id', 'family_id']])
            ->addColumn('affiliation_id', 'string', [
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('family_id', 'string', [
                'limit' => 36,
                'null' => false,
            ])
            // ->addColumn('company_id', 'string', [
            //     'null' => false,
            //     'limit' => 36
            // ])
            ->addForeignKey('affiliation_id', 'affiliations', 'id', [
                'delete' => 'CASCADE', 'update' => 'CASCADE'
            ])
            ->addForeignKey('family_id', 'families', 'id', [
                'delete' => 'CASCADE', 'update' => 'CASCADE'
            ])
            ->create();

        $this->insert('modules', [
            'slug' => 'affiliation',
            'permission' => 'backoffice.modules.application',
            'front_permission' =>  'webservice.application',
            'title_key' => 'module_affiliation',
        ]);
        $this->insert('contents', [
            'slug' => 'module_affiliation',
            'type' => 'module',
            'title_key' => 'lang:module_affiliation',
            'active' => 1
        ]);

        $this->insert('contents_translations', [
            'content_slug' => 'module_affiliation',
            'local' => 'french',
            'title' =>  'Affiliation TV',
            'content' => '',
        ]);
    }

    public function down()
    {
        $this->table('affiliations')->drop();
        $this->table('affiliation_families')->drop();
        $this->execute('DELETE FROM modules WHERE slug = "affiliation"');
        $this->execute('DELETE FROM contents WHERE slug = "module_affiliation"');
        $this->execute('DELETE FROM contents_translations WHERE content_slug = "module_affiliation"');
    }
}
