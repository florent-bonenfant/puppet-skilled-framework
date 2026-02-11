<?php

use HideMe\Model;

class InvoiceLine extends Model
{
    protected $table = 'invoices_lines';
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
        $this->columns['batch'] = function () {
            $tmp = $this->faker->numberBetween(0,200);
            if ($tmp % 2 === 0) {
                return $this->faker->numberBetween($min = 1000, $max = 999999999);
            }
            return '';
        };
    }
}
