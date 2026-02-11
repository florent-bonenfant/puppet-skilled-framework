<?php

class UpdatePrimaryInsitut extends PuppetSkilledMigration
{

    public function up()
    {
        $this->table('instituts')
            ->addIndex(['id'], [
                'unique' => false,
            ])
            ->addIndex(['id', 'customer_id'], [
                'unique' => true,
                'name' => 'insituts_multi_ids',
            ])
            ->changePrimaryKey([])
            ->save();


        $this->table('expired_dates')
            ->changePrimaryKey([])
            ->removeIndexByName('product_code')
            ->addIndex(['id'], [
                'unique' => false,
            ])
            ->addIndex(['product_code', 'company_id', 'lot_number'], [
                'unique' => true,
                'name' => 'expired_multi_ids',
            ])
            ->save();
    }

    public function down()
    {
        $this->execute("ALTER TABLE `instituts` ADD PRIMARY KEY (`id`);");

        $this->table('instituts')
            ->removeIndexByName('insituts_multi_ids')
            ->removeIndexByName('id')
            ->save();

        $this->table('expired_dates')
            ->removeIndexByName('expired_multi_ids')
            ->removeIndexByName('id')
            ->save();
    }

}
