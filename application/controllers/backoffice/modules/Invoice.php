<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \App\Job\MailerContent;
use \App\Model\Invoice as InvoiceModel;

class Invoice extends \App\Core\Controller\BackOffice
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
        'index' => 'backoffice.modules.invoice.view',
        'view' => 'backoffice.modules.invoice.view',
        'delete' => 'backoffice.modules.invoice.delete',
        'sync' => 'backoffice',
    ];

    public function index()
    {
        $query =  InvoiceModel::query();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'document_number' => function ($query, $value) {
                        return $query->where('document_number', 'like', '%'.$value.'%');
                    },
                    'customer_id' => function ($query, $value) {
                        return $query->where('customer_id', 'like', '%'.$value.'%');
                    },
                ],
                'save' => 'backoffice_modules_invoices_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'document_type' => 'document_type',
                    'customer_id' => 'customer_id',
                    'document_number' => 'document_number',
                    'product_number' => 'product_number',
                    'date' => 'date',
                    'amount' => 'amount',
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_modules_invoices_pager',
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
        if (!$id ||  !($item = InvoiceModel::find($id))) {
            redirect_referrer('backoffice/modules/invoice');
        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('invoice_breadcrumb_view'), $item->document_number),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = sprintf(lang('invoice_title_view'), $item->document_number);
        // render
        $this->render([
            'item' => $item,
            'page_title' => $page_title
        ]);
    }

    /**
     * Delete the document of the invoice
     *
     * @param  string $id invoice's id
     */
    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = InvoiceModel::find($id))) {
            redirect_referrer('backoffice/modules/invoice');
        }
        $item->file_name = null;
        $item->update();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/invoice');
    }

    public function sync()
    {
        // schedule invoices import
        $job = new \App\Job\ImportInvoices();
        $this->queueService->dispatch($job);

        // notify current user
        $user = $this->authenticationService->user();

        if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
            $email = new MailerContent();
            $email->to($user->username)
            ->setContent(
                'email_invoices_sync',
                [
                    'user_first_name' => ucfirst(strtolower($user->first_name)),
                    'user_last_name' => ucfirst(strtolower($user->last_name)),
                    'user_email' =>  $user->email,
                    'customer_code' => '',
                    'front_url' => site_url('backoffice/modules/invoice'),
                    'nb_notif' => ''
                ]
            );

            $email->handle();
        }
        // redirect
        $this->flashMessage('lang:invoice_message_sync', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/invoice');
    }

    public function download($id = null)
    {
        $item = InvoiceModel::find($id);
        force_download($item->documentPath(), null);
    }
}
