<?php

use HideMe\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    public $timestamps = false;
    public $columns = [
        'city' => 'city',
        'name' => 'company',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->columns['id'] = function () {
            return $this->faker->uuid();
        };
        $this->columns['document_number'] = function () {
            return $this->faker->numberBetween($min = 1000, $max = 999999999);
        };
        $this->columns['file_name'] = function () {
            return null;
        };
    }
}
