<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instituts extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleInstituts();
    }

    public function scheduleInstituts()
    {
        // schedule institut import
        $job = new \App\Job\ImportInstituts();
        $this->queueService->dispatch($job);
    }
}
