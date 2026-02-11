<?php
class InstitutStatus extends PuppetSkilledMigration
{
    public function change()
    {
        $this->table('instituts')
             ->addColumn('status', 'boolean', ['after' => 'customer_id'])
             ->save();
    }
}
