<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleOrders();
    }

    public function scheduleOrders()
    {
        // schedule orders import
        $job = new \App\Job\ImportOrders();
        $this->queueService->dispatch($job);
    }
}
