<?php

use HideMe\Model;

class ShippingSlip extends Model
{
    protected $table = 'shippings_slips';

    public $timestamps = true;
    public $columns = [];

    public function __construct()
    {
        parent::__construct();
        $this->columns['filename'] = function () {
            return null;
        };
        $this->columns['number'] = function () {
            return $this->currentItem->number . '.' . $this->faker->randomNumber(5);
        };
    }
}

