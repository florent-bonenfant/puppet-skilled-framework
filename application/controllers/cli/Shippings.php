<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shippings extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleShippings();
    }

    public function scheduleShippings()
    {
        // schedule shippings import
        $job = new \App\Job\ImportShippings();
        $this->queueService->dispatch($job);
    }
}
