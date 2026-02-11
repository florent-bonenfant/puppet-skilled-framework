<?php

class UpdateColumnLabelCondition extends PuppetSkilledMigration
{
    public function up()
    {
        $this->table('commercial_conditions')
            ->changeColumn('label', 'string', ['limit' => 50, 'null' => false])
            ->save();
    }
    public function down()
    {
        // no-op
    }
}
