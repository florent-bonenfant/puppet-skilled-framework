<?php

use HideMe\Model;

class OrderLine extends Model
{
    protected $table = 'order_lines';
    public $timestamps = true;
    public $columns = [];

    public function __construct()
    {
        parent::__construct();
        $this->columns['id'] = function () {
            return $this->faker->uuid();
        };
        $this->columns['description'] = function () {
            return $this->faker->text(255);
        };
        $this->columns['number'] = function () {
            return $this->faker->numberBetween(1, 999999999);
        };
    }
}
