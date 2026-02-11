<?php
class ContratNullFileName extends PuppetSkilledMigration
{
    public function up()
    {
        $contrats = $this->table('contrats');
        $contrats->changeColumn('file_name', 'string', ['limit' => 255, 'null' => true])
                 ->save();
    }

    public function down()
    {
        $contrats = $this->table('contrats');
        $contrats->changeColumn('file_name', 'string', ['limit' => 255, 'null' => false])
                 ->save();
    }
}
