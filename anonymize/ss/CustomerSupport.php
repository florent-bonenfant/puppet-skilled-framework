<?php

use HideMe\Model;

class CustomerSupport extends Model
{
    protected $table = 'customers_support';
    public $timestamps = false;
    public $columns = [
        'name' => 'name'
    ];
}
