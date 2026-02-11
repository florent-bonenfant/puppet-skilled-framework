<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Model\User as UserModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\UsersRoles as UsersRolesModel;

class RecreateRoles extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $customers = CustomerModel::get();
        foreach ($customers as $customer) {
            $users = UserModel::where('email', $customer->email)->get();
            foreach ($users as $user) {
                UsersRolesModel::insert([
                    'id' => (new UsersRolesModel())->generateUuid(),
                    'user_id' => $user->id,
                    'customer_id' => $customer->id,
                    'role_id' => 'customer'
                ]);
            }
        }
    }
}