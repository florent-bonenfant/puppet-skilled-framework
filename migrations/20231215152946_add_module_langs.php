<?php


class AddModuleLangs extends PuppetSkilledMigration
{
    public function up()
    {
        $this->insert('contents', [
            ['slug' => 'location_shippings', 'type' => 'location', 'title_key' => 'lang:general_location_shippings'],
            ['slug' => 'location_orders', 'type' => 'location', 'title_key' => 'lang:general_location_orders'],
            ['slug' => 'location_application', 'type' => 'location', 'title_key' => 'lang:general_location_application'],
            ['slug' => 'location_statistics', 'type' => 'location', 'title_key' => 'lang:general_location_statistics'],
            ['slug' => 'location_instituts', 'type' => 'location', 'title_key' => 'lang:general_location_instituts'],
            ['slug' => 'location_affiliation', 'type' => 'location', 'title_key' => 'lang:general_location_affiliation'],
        ]);

        $this->insert('contents_translations', [
            ['content_slug' => 'location_orders', 'local' => 'french', 'title' => 'Bons de commande', 'content' => ''],
            ['content_slug' => 'location_shippings', 'local' => 'french', 'title' => 'Bons de livraison', 'content' => ''],
            ['content_slug' => 'location_application', 'local' => 'french', 'title' => 'Application et liens', 'content' => ''],
            ['content_slug' => 'location_statistics', 'local' => 'french', 'title' => 'Statistique', 'content' => ''],
            ['content_slug' => 'location_instituts', 'local' => 'french', 'title' => 'Institut', 'content' => ''],
            ['content_slug' => 'location_affiliation', 'local' => 'french', 'title' => 'Affiliation TV', 'content' => ''],
        ]);
    }

    public function down()
    {
        $this->execute('DELETE FROM contents WHERE slug IN ("location_orders", "location_shippings", "location_application", "location_statistics", "location_instituts", "location_affiliation")');
        $this->execute('DELETE FROM contents_translations WHERE content_slug IN ("location_orders", "location_shippings", "location_application", "location_statistics", "location_instituts", "location_affiliation")');
    }
}
