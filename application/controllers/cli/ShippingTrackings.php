<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ShippingTrackings extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleShippingTrackings();
    }

    public function scheduleShippingTrackings()
    {
        // schedule shippings Trackings import
        $job = new \App\Job\ImportShippingTrackings();
        $this->queueService->dispatch($job);
    }
}
