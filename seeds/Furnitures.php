<?php

use Phinx\Seed\AbstractSeed;

class Furnitures extends AbstractSeed
{
    public function getDependencies()
    {
        return ['Reset', 'Customers'];
    }

    public function run()
    {
        $faker = Faker\Factory::create('fr_FR');

        $customer_ids = [];
        foreach($this->fetchAll('SELECT id FROM customers') as $customer) {
            $customer_ids[] = $customer['id'];
        }

        $furnitures = $furnitures_lines = [];
        for ($i = 0; $i < 100; $i++) {
            $initial_datetime = $faker->dateTimeBetween('-2 years');
            $end_datetime = (clone $initial_datetime)->add(new DateInterval('P1Y'));

            $furnitures[] = [
                'id' => $faker->uuid,
                'customer_id' => array_rand(array_flip($customer_ids)),
                'code' => $faker->randomNumber(6),
                'label' => mb_strtoupper(implode(' ', $faker->words(3))),
                'series' => mb_strtoupper($faker->bothify('??######')),
                'initial_date' => $initial_datetime->format('Y-m-d'),
                'end_date' => $end_datetime->format('Y-m-d'),
                'contract_number' => $faker->randomNumber(4),
                'file_name' => 'sample.pdf',
            ];
        }

        $this->insert('furnitures', $furnitures);
    }
}
