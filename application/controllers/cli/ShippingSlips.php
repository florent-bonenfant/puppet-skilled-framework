<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ShippingSlips extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleShippingSlips();
    }

    public function scheduleShippingSlips()
    {
        // schedule shippings slips import
        $job = new \App\Job\ImportShippingSlips();
        $this->queueService->dispatch($job);
    }
}
