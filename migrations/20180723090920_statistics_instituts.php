<?php
class StatisticsInstituts extends PuppetSkilledMigration
{
    public function up()
    {
        $statistics = $this->table('statistics');
        $statistics->dropForeignKey('customer_id')->save();
        $statistics->renameColumn('customer_id', 'institut_id');
        $statistics->addForeignKey('institut_id', 'instituts', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])->save();
    }

    public function down()
    {
        $statistics = $this->table('statistics');
        $statistics->dropForeignKey('institut_id')->save();
        $statistics->renameColumn('institut_id', 'customer_id');
        $statistics->addForeignKey('customer_id', 'customers', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])->save();
    }
}
