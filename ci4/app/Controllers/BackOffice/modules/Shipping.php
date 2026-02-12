<?php

namespace App\Controllers\BackOffice\Modules;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \Illuminate\Database\Query\Expression;
use \App\Job\MailerContent;
use \App\Model\Shipping as ShippingModel;

class Shipping extends \App\Core\Controller\BackOffice
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
        'index' => 'backoffice.modules.shipping.view',
        'view' => 'backoffice.modules.shipping.view',
        'delete' => 'backoffice.modules.shipping.delete',
        'sync' => 'backoffice',
    ];

    public function index()
    {
        $query =  ShippingModel::query();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'shipping_number' => function ($query, $value) {
                        return $query->where('shipping_number', 'like', '%'.$value.'%');
                    },
                    'customer_id' => function ($query, $value) {
                        return $query->where('customer_id', 'like', '%'.$value.'%');
                    },
                    'institut_id' => function ($query, $value) {
                        return $query->where('institut_id', 'like', '%'.$value.'%');
                    },
                ],
                'save' => 'backoffice_modules_shippings_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'customer_id' => 'customer_id',
                    'institut_id' => 'institut_id',
                    'shipping_number' => 'shipping_number',
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_modules_shippings_pager',
                'unique_shipping_key' => $query->getModel()->getKeyName()
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
        if (!$id ||  !($item = ShippingModel::find($id))) {
            redirect_referrer('backoffice/modules/shipping');
        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('shipping_breadcrumb_view'), $item->shipping_number),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = sprintf(lang('shipping_title_view'), $item->shipping_number);
        // render
        $this->render([
            'item' => $item,
            'page_title' => $page_title
        ]);
    }

    /**
     * Delete the document of the shipping
     *
     * @param  string $id shipping's id
     */
    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = ShippingModel::find($id))) {
            redirect_referrer('backoffice/modules/shipping');
        }
        $item->file_name = null;
        $item->update();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/shipping');
    }

    public function sync()
    {
        // schedule shippings import
        $job = new \App\Job\ImportShippings();
        $this->queueService->dispatch($job);

        // notify current user
        $user = $this->authenticationService->user();
        if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
            $email = new MailerContent();
            $email->to($user->username)
            ->setContent(
                'email_shippings_sync',
                [
                    'user_first_name' => ucfirst(strtolower($user->first_name)),
                    'user_last_name' => ucfirst(strtolower($user->last_name)),
                    'user_email' =>  $user->email,
                    'customer_code' => '',
                    'front_url' => site_url('backoffice/modules/shipping'),
                    'nb_notif' => ''
                ]
            );

            $email->handle();
        }
        // redirect
        $this->flashMessage('lang:shipping_message_sync', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/shipping');
    }

    public function download($id = null)
    {
        $item = ShippingModel::find($id);
        force_download($item->documentPath(), null);
    }
}
