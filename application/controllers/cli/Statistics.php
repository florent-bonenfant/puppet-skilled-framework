<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Statistics extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleStatistics();
    }

    public function scheduleStatistics()
    {
        // schedule statistics import
        $job = new \App\Job\ImportStatistics();
        $this->queueService->dispatch($job);
    }
}
