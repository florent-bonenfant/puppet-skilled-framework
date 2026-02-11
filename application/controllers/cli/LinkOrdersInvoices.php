<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LinkOrdersInvoices extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleLinkOrdersInvoices();
    }

    public function scheduleLinkOrdersInvoices()
    {
        // schedule the import of the links between orders and invoices
        $job = new \App\Job\ImportLinkOrdersInvoices();
        $this->queueService->dispatch($job);
    }
}
