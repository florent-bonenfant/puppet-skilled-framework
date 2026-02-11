<?php

class AddColumnsCustomersHistory extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('customers')
            ->addColumn('old_num', 'string', [
                'length' => 36,
                'null'   => true,
            ])
            ->save();

        // historisation des ids pour les clients inactifs
        $this->execute("UPDATE `customers` SET `old_num` = `id`;");
        $this->execute("UPDATE `customers` SET `id` = CONCAT('old_', `id`) WHERE `customers`.`active` = '0' OR `customers`.`id` IN (22428, 22952);");
    }

    public function down()
    {
        // no op
        // Restauration des ids dans le script de renumérotation si possible
    }
}
