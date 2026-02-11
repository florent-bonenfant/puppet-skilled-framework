<?php

use Phinx\Db\Adapter\MysqlAdapter;

class CustomerAndUserModules extends PuppetSkilledMigration
{
    public function up()
    {
        $this->insert('modules', [
            ['slug' => 'customer', 'permission' => 'backoffice.customer', 'title_key' => 'module_customer'],
            ['slug' => 'user_connect_as', 'permission' => 'backoffice.user.connect_as', 'title_key' => 'module_user'],
        ]);

        $this->insert('contents', [
            ['slug' => 'module_customer', 'type' => 'modules',  'title_key' => 'lang:module_customer'],
            ['slug' => 'module_user', 'type' => 'modules',  'title_key' => 'lang:module_user'],
        ]);

        $this->insert('contents_translations', [
            ['content_slug' => 'module_customer', 'local' => 'french',  'title' => 'Client', 'content' => ''],
            ['content_slug' => 'module_user', 'local' => 'french',  'title' => 'Se connecter en tant que', 'content' => ''],
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM modules WHERE slug IN ("customer", "user_connect_as")');
        $this->execute('DELETE FROM contents WHERE slug IN ("module_customer", "module_user")');
        $this->execute('DELETE FROM contents_translations WHERE content_slug IN ("module_customer", "module_user")');
    }
}




