<?php

use HideMe\Model;

class Customer extends Model
{
    protected $table = 'customers';
    public $timestamps = false;
    public $columns = [
        'first_name' => 'firstName',
        'last_name' => 'lastName',
        'email' => 'email',
        'address' => 'address',
        'zip' => 'postcode',
        'city' => 'city',
        'phone' => 'e164PhoneNumber',
        'title' => 'company',
    ];
}
