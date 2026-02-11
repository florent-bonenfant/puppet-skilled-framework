<?php
class BlbcWebservice extends PuppetSkilledMigration
{
    public function up()
    {
        $this->execute("UPDATE modules SET front_permission = 'webservice.order' WHERE permission = 'backoffice.modules.order'");
        $this->execute("UPDATE modules SET front_permission = 'webservice.shipping' WHERE permission = 'backoffice.modules.shipping'");
    }

    public function down()
    {
        $this->execute("UPDATE modules SET front_permission = NULL WHERE permission = 'backoffice.modules.order'");
        $this->execute("UPDATE modules SET front_permission = NULL WHERE permission = 'backoffice.modules.shipping'");
    }
}
