<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LinkShippingsInvoices extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleLinkShippingsInvoices();
    }

    public function scheduleLinkShippingsInvoices()
    {
        // schedule the import of the links between shippings and invoices
        $job = new \App\Job\ImportLinkShippingsInvoices();
        $this->queueService->dispatch($job);
    }
}
