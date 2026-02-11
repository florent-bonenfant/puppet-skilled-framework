<?php


class AddColumnDescPayments extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('payments')
            ->addColumn(
                'description',
                'string',
                [
                    'null' => true,
                    'limit' => 255,
                    'after' => 'amount'
                ]
            )
            ->update();
    }
}
