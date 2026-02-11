<?php

use HideMe\Model;

class Message extends Model
{
    protected $table = 'messages';
    public $timestamps = true;
    public $columns = [];

    public function __construct()
    {
        parent::__construct();
        $this->columns['title'] = function () {
            return $this->faker->sentence(3, true);
        };
        $this->columns['content'] = function () {
            return $this->faker->paragraph(15, true);
        };
    }
}
