<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Misc extends \App\Core\Controller\Webservice
{
    protected $isPublic = true;

    public function hello()
    {
        $this->return(static::HTTP_OK, [
            'resultCode' => 'HELLO'
        ]);
    }
}
