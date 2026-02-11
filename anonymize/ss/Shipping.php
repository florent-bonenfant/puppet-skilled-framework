<?php

use HideMe\Model;

class Shipping extends Model
{
    protected $table = 'shippings';

    public $timestamps = true;
    public $columns = [];

    public function __construct()
    {
        parent::__construct();
        $this->columns['file_name'] = function () {
            return null;
        };
        $this->columns['shipping_number'] = function () {
            return str_pad($this->faker->randomNumber(), 10, STR_PAD_RIGHT);
        };
    }
}

