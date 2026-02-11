<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tata extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleSync();
    }

    public function scheduleSync()
    {
         // deliveries
        $job = new \App\Job\ImportDeliveries();
        $this->queueService->dispatch($job);

        $job = new \App\Job\ImportDeliveryProducts();
        $this->queueService->dispatch($job);
    }
}
