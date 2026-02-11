<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoices extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleInvoices();
    }

    public function scheduleInvoices()
    {
        // schedule shippings import
        $job = new \App\Job\ImportInvoices();
        $this->queueService->dispatch($job);
    }
}
