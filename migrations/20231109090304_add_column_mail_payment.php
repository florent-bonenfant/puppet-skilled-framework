<?php

use Phinx\Db\Adapter\MysqlAdapter;

class AddColumnMailPayment extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('payments')
            ->addColumn(
                'mail_send',
                'integer',
                [
                    'null' => false,
                    'limit' => MysqlAdapter::INT_TINY,
                    'default' => 0,
                    'after' => 'description'
                ]
            )
            ->addColumn(
                'attempts',
                'integer',
                [
                    'null' => false,
                    'default' => 0,
                    'after' => 'state',
                    'comment' => 'Tentatives de rafraichissement de l\'état'
                ]
            )
            ->addColumn(
                'deleted_at',
                'datetime',
                ['null' => true]
            )
            ->update();
    }
}
