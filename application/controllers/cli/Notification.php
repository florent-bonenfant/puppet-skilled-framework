<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->notifyCustomers();
    }

    public function notifyCustomers()
    {
        $notif = new \App\Job\Notification();
        $notif->handle();
    }
}
