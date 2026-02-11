<?php

use Phinx\Seed\AbstractSeed;

class Reset extends AbstractSeed
{
    public function run()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');

        $this->execute('TRUNCATE TABLE `invoices_lines`');
        $this->execute('TRUNCATE TABLE `invoices`');

        $this->execute('TRUNCATE TABLE `furnitures`');

        $this->execute('TRUNCATE TABLE `customers`');
        $this->execute('TRUNCATE TABLE `customers_support`');

        $this->execute('DELETE u FROM `users` u INNER JOIN `users_roles` ur ON ur.user_id = u.id WHERE ur.role_id = "customer"');
        $this->execute('DELETE FROM `users_roles` WHERE role_id = "customer"');

        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }
}
