<?php
namespace App\Service\Notification;

class Notification
{
    /**
     * Queue service
     * @var \Globalis\PuppetSkilled\Queue\Service
     */
    protected $queueService;

    public function __construct(\Globalis\PuppetSkilled\Queue\Service $queueService = null)
    {
        $this->queueService = $queueService;
    }

    /**
     * Send notification
     *
     * @param  string $slug  content slug
     * @param  miwed $customers Customer_id list (array|string|\Globalis\PuppetSkilled\Database\Query)
     * @param  array  $data
     * @return void
     */
    public function send(string $slug, $customers, array $data = [])
    {
        $job = new Job($slug, $customers, $data);
        // Send to queue
        if ($this->queueService) {
            $this->queueService->dispatch($job);
        } else { // or handle
            $job->handle();
        }
    }
}
