<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ExpiredDates extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleExpiredDates();
    }

    public function scheduleExpiredDates()
    {
        // schedule expired date import
        $job = new \App\Job\ImportExpiredDates();
        $this->queueService->dispatch($job);
    }
}
