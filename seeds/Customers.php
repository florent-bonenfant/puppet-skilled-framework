<?php

use Phinx\Seed\AbstractSeed;

class Customers extends AbstractSeed
{
    public function getDependencies()
    {
        return ['Reset', 'CustomersSupport'];
    }

    public function run()
    {
        $faker = Faker\Factory::create('fr_FR');

        $family_ids = [];
        foreach($this->fetchAll('SELECT id, slug FROM families') as $family) {
            $family_ids[$family['slug']] = $family['id'];
        }

        $company_ids = [];
        foreach($this->fetchAll('SELECT id, name FROM companies') as $company) {
            $company_ids[$company['name']] = $company['id'];
        }

        $support_ids = [];
        foreach($this->fetchAll('SELECT id, name FROM customers_support') as $support) {
            $support_ids[$support['name']] = $support['id'];
        }

        $customers = [];
        foreach ([10000, 20000, 30000, 40000, 50000] as $id) {
            $first_name = $faker->firstName('female');
            $last_name = $faker->lastName;
            $customers[] = [
                'id' => $id,
                'family_id' => array_rand(array_flip($family_ids)),
                'company_id' => array_rand(array_flip($company_ids)),
                'support_id' => array_rand(array_flip($support_ids)),
                'email' => mb_strtolower($first_name.'.'.$last_name).'@globalis-ms.com',
                'first_name' => mb_strtoupper($first_name),
                'last_name' => mb_strtoupper($last_name),
                'type' => 'CF',
                'title' => 'MME '.mb_strtoupper($last_name).' '.mb_strtoupper($first_name),
                'sign' => 'INSTITUT '.mb_strtoupper($last_name),
                'address' => mb_strtoupper($faker->streetAddress),
                'zip' => $faker->postcode,
                'city' => mb_strtoupper($faker->city),
                'phone' => '06 06 06 06 06',
                'active' => 1,
            ];
        }

        $users = $users_roles = [];
        foreach ($customers as $customer) {
            $user_id = $faker->uuid;
            $users[] = [
                'id' => $user_id,
                'username' => $customer['email'],
                'password' => '$2y$12$N00f9hL9.pOoTMjqQVAVneiwdnoO/vKGEMXXId9mw/t9LjVPC2l2W', // = guinot
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'email' => $customer['email'],
                'language' => 'fr',
                'timezone' => date_default_timezone_get(),
                'date_format' => '%d %B %Y',
                'datetime_format' => '%d %B %Y, %H:%M',
                'active' => 1,
                'visible' => 1,
                'has_accepted_eula' => 0,
            ];

            $users_roles[] = [
                'id' => $faker->uuid,
                'user_id' => $user_id,
                'customer_id' => $customer['id'],
                'role_id' => 'customer',
            ];
        }

        // Add multi-customer user
        $base_customer = $customers[0];
        $base_user = $users[0];
        foreach ([11000, 12000, 13000] as $id) {
            $customers[] = array_merge($base_customer, [
                'id' => $id,
                'company_id' => array_rand(array_flip($company_ids)),
                'address' => mb_strtoupper($faker->streetAddress),
                'zip' => $faker->postcode,
                'city' => mb_strtoupper($faker->city),
            ]);

            $users_roles[] = [
                'id' => $faker->uuid,
                'user_id' => $base_user['id'],
                'customer_id' => $id,
                'role_id' => 'customer',
            ];
        }

        $this->insert('customers', $customers);
        $this->insert('users', $users);
        $this->insert('users_roles', $users_roles);
    }
}
