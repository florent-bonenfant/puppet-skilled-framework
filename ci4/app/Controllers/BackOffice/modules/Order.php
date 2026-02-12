<?php

namespace App\Controllers\BackOffice\Modules;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \App\Job\MailerContent;
use \App\Model\Order as OrderModel;

class Order extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date',
            'array',
            'url',
            'download'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.modules.order.view',
        'view' => 'backoffice.modules.order.view',
        'delete' => 'backoffice.modules.order.delete',
        'sync' => 'backoffice',
    ];

    public function index()
    {
        $query =  OrderModel::query();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'order_number' => function ($query, $value) {
                        return $query->where('order_number', 'like', '%'.$value.'%');
                    },
                    'customer_id' => function ($query, $value) {
                        return $query->where('customer_id', 'like', '%'.$value.'%');
                    },
                ],
                'save' => 'backoffice_modules_orders_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'customer_id' => 'customer_id',
                    'order_number' => 'order_number',
                    'date' => 'date',
                    'quantity' => 'quantity',
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_modules_orders_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    public function view($id = null)
    {
        if (!$id ||  !($item = OrderModel::find($id))) {
            redirect_referrer('backoffice/modules/order');
        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('order_breadcrumb_view'), $item->order_number),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = sprintf(lang('order_title_view'), $item->order_number);
        // render
        $this->render([
            'item' => $item,
            'page_title' => $page_title
        ]);
    }

    /**
     * Delete the document of the order
     *
     * @param  string $id order's id
     */
    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = OrderModel::find($id))) {
            redirect_referrer('backoffice/modules/order');
        }
        $item->file_name = null;
        $item->update();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/order');
    }

    public function sync()
    {
        // schedule orders import
        $job = new \App\Job\ImportOrders();
        $this->queueService->dispatch($job);

        // notify current user
        $user = $this->authenticationService->user();

        if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
            $email = new MailerContent();
            $email->to($user->username)
            ->setContent(
                'email_orders_sync',
                [
                    'user_first_name' => ucfirst(strtolower($user->first_name)),
                    'user_last_name' => ucfirst(strtolower($user->last_name)),
                    'user_email' =>  $user->email,
                    'customer_code' => '',
                    'front_url' => site_url('backoffice/modules/order'),
                    'nb_notif' => ''
                ]
            );

            $email->handle();
        }
        // redirect
        $this->flashMessage('lang:order_message_sync', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/order');
    }

    public function download($id = null)
    {
        $item = OrderModel::find($id);
        force_download($item->documentPath(), null);
    }
}
