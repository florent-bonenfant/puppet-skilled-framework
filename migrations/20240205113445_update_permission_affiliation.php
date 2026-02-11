<?php

class UpdatePermissionAffiliation extends PuppetSkilledMigration
{

    public function up()
    {
        $this->execute("UPDATE modules SET front_permission = 'webservice.affiliation', permission = 'backoffice.modules.affiliation' WHERE title_key = 'module_affiliation'");
    }

    public function down()
    {
        $this->execute("UPDATE modules SET front_permission = 'webservice.application', permission = 'backoffice.modules.application' WHERE title_key = 'module_affiliation'");
    }
}
