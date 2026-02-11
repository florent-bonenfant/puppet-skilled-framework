<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InstitutTimes extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleInstitutTimes();
    }

    public function scheduleInstitutTimes()
    {
        // schedule institut times import
        $job = new \App\Job\ImportInstitutTimes();
        $this->queueService->dispatch($job);
    }
}
