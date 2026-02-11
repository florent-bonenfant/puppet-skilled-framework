<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sync extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $this->scheduleSync();
    }

    public function scheduleSync()
    {
        // schedule family import
        $job = new \App\Job\ImportFamilies();
        $this->queueService->dispatch($job);

        // schedule customers import
        $job = new \App\Job\ImportCustomers();
        $this->queueService->dispatch($job);

        // schedule expired dates import
        $job = new \App\Job\ImportExpiredDates();
        $this->queueService->dispatch($job);

        // schedule customers support import
        $job = new \App\Job\ImportSupport();
        $this->queueService->dispatch($job);

        // schedule invoices import
        $job = new \App\Job\ImportInvoices();
        $this->queueService->dispatch($job);

        // schedule furnitures import
        $job = new \App\Job\ImportFurnitures();
        $this->queueService->dispatch($job);

        // schedule statistics import
        $job = new \App\Job\ImportStatistics();
        $this->queueService->dispatch($job);

        // schedule institutes import
        $job = new \App\Job\ImportInstituts();
        $this->queueService->dispatch($job);

        // schedule orders import
        $job = new \App\Job\ImportOrders();
        $this->queueService->dispatch($job);

        // schedule the link between orders and invoices import
        $job = new \App\Job\ImportLinkOrdersInvoices();
        $this->queueService->dispatch($job);

        // schedule shippings import -> disabled for new page, old shippings are in archive
        // $job = new \App\Job\ImportShippings();
        // $this->queueService->dispatch($job);

        // // schedule the link between shippings and invoices import
        // $job = new \App\Job\ImportLinkShippingsInvoices();
        // $this->queueService->dispatch($job);

        // schedule new system of shipping
        $job = new \App\Job\ImportShippingSlips();
        $this->queueService->dispatch($job);

        $job = new \App\Job\ImportShippingTrackings();
        $this->queueService->dispatch($job);

        // schedule soldes import
        $job = new \App\Job\ImportSoldes();
        $this->queueService->dispatch($job);

        // schedule contrats import
        $job = new \App\Job\ImportContrats();
        $this->queueService->dispatch($job);
    }
}
