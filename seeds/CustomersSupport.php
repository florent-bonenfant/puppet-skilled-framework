<?php

use Phinx\Seed\AbstractSeed;

class CustomersSupport extends AbstractSeed
{
    public function getDependencies()
    {
        return ['Reset'];
    }

    public function run()
    {
        $faker = Faker\Factory::create('fr_FR');

        foreach (range(1, 9) as $id) {
            $customers_support[] = [
                'id' => $id,
                'name' => mb_strtoupper($faker->lastName.' '.$faker->firstName),
            ];
        }

        $this->insert('customers_support', $customers_support);
    }
}
 
