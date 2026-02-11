<?php

use HideMe\Model;

class ShippingTracking extends Model
{
    protected $table = 'shippings_trackings';

    public $timestamps = true;
    public $columns = [];

    public function __construct()
    {
        parent::__construct();
        $this->columns['number'] = function () {
            return $this->faker->randomNumber();
        };
        $this->columns['date'] = function () {
            return $this->faker->date();
        };
    }
}

