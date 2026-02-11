<?php

use HideMe\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = true;
    public $columns = [];
    private $numOrder = 0;

    public function __construct()
    {
        parent::__construct();
        $this->columns['id'] = function () {
            return $this->faker->uuid();
        };
        $this->columns['order_number'] = function () {
            return $this->numOrder++;
        };
    }
}
