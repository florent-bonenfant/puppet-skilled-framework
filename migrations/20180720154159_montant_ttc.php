<?php


class MontantTtc extends PuppetSkilledMigration
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
        $invoices_table = $this->table('invoices');
        $invoices_table->addColumn('amount_ttc', 'decimal', ['after' => 'amount', 'precision' => 10, 'scale' => 2, 'null' => true])
                       ->update();

        $invoices_lines_table = $this->table('invoices_lines');
        $invoices_lines_table->addColumn('amount_ttc', 'decimal', ['after' => 'amount', 'precision' => 10, 'scale' => 2, 'null' => true])
                             ->update();
    }
}
