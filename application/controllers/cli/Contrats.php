<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contrats extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleContrats();
    }

    public function scheduleContrats()
    {
        // schedule contrats import
        $job = new \App\Job\ImportContrats();
        $this->queueService->dispatch($job);
    }
}
