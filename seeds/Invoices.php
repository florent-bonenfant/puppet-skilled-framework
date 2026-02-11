<?php

use Phinx\Seed\AbstractSeed;

class Invoices extends AbstractSeed
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

        $company_ids = [];
        foreach($this->fetchAll('SELECT id, name FROM companies') as $company) {
            $company_ids[$company['name']] = $company['id'];
        }

        $invoices = $invoices_lines = [];
        for ($i = 0; $i < 100; $i++) {
            $invoice_id = $faker->uuid;
            $invoice_amount = 0;

            for ($j = 0; $j < $faker->numberBetween(3, 15); $j++) {
                $amount = $faker->randomFloat(2, 10, 200);
                $invoices_lines[] = [
                    'id' => $faker->uuid,
                    'number' => $faker->randomNumber(8),
                    'description' => mb_strtoupper(implode(' ', $faker->words(3))),
                    'batch' => $faker->randomNumber(9),
                    'invoice_id' => $invoice_id,
                    'amount' => $amount,
                    'amount_ttc' => $amount,
                ];
                $invoice_amount += $amount;
            }

            $invoices[] = [
                'id' => $invoice_id,
                'customer_id' => array_rand(array_flip($customer_ids)),
                'company_id' => array_rand(array_flip($company_ids)),
                'document_number' => $faker->randomNumber(8),
                'document_type' => $faker->randomElement(['RI', 'RJ']),
                'file_name' => 'sample.pdf',
                'amount' => $invoice_amount,
                'amount_ttc' => $invoice_amount * 1.2,
                'date' => $faker->dateTimeBetween('-3 years')->format('Y-m-d'),
            ];
        }

        $this->insert('invoices', $invoices);
        $this->insert('invoices_lines', $invoices_lines);
    }
}
