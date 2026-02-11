<?php

use HideMe\Model;

class Statistic extends Model
{
    protected $table = 'statistics';

    public $eraseData = false;
    public $timestamps = true;
    public $columns = [];

    public function __construct()
    {
        parent::__construct();
        $this->columns['year'] = function () {
            return $this->faker->numberBetween(1980, 2030);
        };
        $this->columns['month'] = function () {
            return $this->faker->numberBetween(1, 12);
        };
        $this->columns['code'] = function () {
            return $this->faker->text(36);
        };
        $this->columns['label'] = function () {
            return $this->faker->text(255);
        };
        $this->columns['value'] = function () {
            return $this->faker->randomFloat(2, $min = 1, $max = 99999);
        };
        $this->columns['average'] = function () {
            return $this->faker->randomFloat(2, $min = 1, $max = 99999);
        };
        $this->columns['quartile'] = function () {
            return $this->faker->randomFloat(2, $min = 1, $max = 99999);
        };
    }
}

