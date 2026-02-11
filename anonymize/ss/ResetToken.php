<?php

use HideMe\Model;

class ResetToken extends Model
{
    protected $table = 'reset_tokens';

    public $eraseData = true;
    public $timestamps = false;
    public $columns = [];
}

