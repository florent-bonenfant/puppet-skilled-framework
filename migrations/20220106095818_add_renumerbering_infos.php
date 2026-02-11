<?php


class AddRenumerberingInfos extends PuppetSkilledMigration
{
    public function up()
    {
        if (!$this->table('customers')->hasColumn('closed')) {
            $this->table('customers')
                ->addColumn('closed', 'datetime', [
                    'null' => true,
                    'after' => 'phone'
                ])
                ->save();
        }
        if (!$this->table('customers')->hasColumn('old_renum')) {
            $this->table('customers')
                ->addColumn('old_renum', 'string', [
                    'length' => 36,
                    'null'   => true,
                    'comment' => 'Ancien identifiant renuméroté en 2021'
                ])
                ->save();

            // historisation des ids pour les clients inactifs
            $this->execute("UPDATE `customers` SET `old_renum` = `id`;");
        }
    }

    public function down()
    {
        // no op
    }
}
