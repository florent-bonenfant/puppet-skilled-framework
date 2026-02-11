<?php

use HideMe\Model;

class Institut extends Model
{
    protected $table = 'instituts';
    public $timestamps = true;
    public $columns = [
        'address' => 'address',
        'city' => 'city',
        'name' => 'company',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->columns['postcode'] = function () {
            return $this->faker->numberBetween($min = 1000, $max = 99999);
        };
    }
}
