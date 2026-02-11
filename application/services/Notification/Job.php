<?php

namespace App\Service\Notification;

use App\Model\Customer;
use App\Service\Notification\Model;
use Carbon\Carbon;
use \Illuminate\Database\Query\Builder as QueryBuilder;
use \Illuminate\Database\Eloquent\Builder as MagicBuilder;

class Job extends \Globalis\PuppetSkilled\Queue\Queueable
{

    protected $slug;

    protected $customers_id;

    protected $customerQuery;

    protected $customerQueryBindings;

    protected $data;

    public function __construct(string $slug, $customers, array $data = [])
    {
        $this->slug = $slug;
        if ($customers instanceof QueryBuilder || $customers instanceof MagicBuilder) {
            $this->customerQuery = $this->toSql();
            $this->customerQueryBindings = $this->getBindings();
        } else {
            $this->customers_id = (array) $customers;
        }
        $this->data = $data;
    }

    protected function getcustomers()
    {
        if ($this->customerQuery !== null) {
            return app()->db()->query($this->customerQuery, $this->customerQueryBindings)->cursor();
        }
        return customer::whereHas('users', function ($query) {
            $query->where('allow_notification', 1);
        })->find($this->customers_id);
    }

    public function send()
    {
        $date = Carbon::now();
        foreach ($this->getcustomers() as $customer) {
            $data = $this->data + ['user_first_name' => $customer->first_name, 'user_last_name' => $customer->last_name];
            $m = new Model();
            $m->customer_id = $customer->id;
            $m->content_slug = $this->slug;
            $m->data = $data;
            $m->read = 0;
            $m->created_at = $date;
            $m->save();
        }
    }
    public function handle()
    {
        $this->send();
    }
}
