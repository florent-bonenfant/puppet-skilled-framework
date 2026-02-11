<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Soldes extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleSoldes();
    }

    public function scheduleSoldes()
    {
        // schedule soldes import
        $job = new \App\Job\ImportSoldes();
        $this->queueService->dispatch($job);
    }
}
