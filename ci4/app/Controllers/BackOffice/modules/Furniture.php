<?php

namespace App\Controllers\BackOffice\Modules;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Library\Upload;
use \App\Job\MailerContent;
use \App\Model\Furniture as FurnitureModel;

class Furniture extends \App\Core\Controller\BackOffice
{

    protected $autoload = [
        'helper' => [
            'form',
            'download',
            'date'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.modules.furniture.view',
        'edit' => 'backoffice.modules.furniture.edit',
        'delete' => 'backoffice.modules.furniture.delete',
        'sync' => 'backoffice',
        'upload' => 'backoffice.modules.furniture.edit',
        'download' => 'backoffice.modules.furniture.view'
    ];

    public function index()
    {
        $query =  FurnitureModel::query();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'contract_number' =>function ($query, $value) {
                        return $query->where('contract_number', 'like', '%'.$value.'%');
                    },
                    'product' => function ($query, $value) {
                        return $query->where('code', 'like', '%'.$value.'%')
                            ->orWhere('label', 'like', '%'.$value.'%')
                            ->orWhere('series', 'like', '%'.$value.'%');
                    },
                    'customer' => function ($query, $value) {
                        return $query->where('customer_id', 'like','%'.$value.'%');
                    }
                ],
                'save' => 'backoffice_modules_furnitures_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'code' => 'code',
                    'label' => 'label',
                    'series' => 'series',
                    'contract_number' => 'contract_number',
                    'initial_date' => 'initial_date',
                    'end_date' => 'end_date',
                    'customer_id' => 'customer_id',
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_modules_furnitures_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
        ]);
    }

    public function edit($id = null)
    {
        $item = FurnitureModel::find($id);
        if (!$item || $item->file_name) {
            redirect('backoffice/modules/furniture');
        }

        $validator = $this->getValidator($item);
        if ($validator->run()) {
            // upload contract
            $contract = $validator->set_value('contract');
            if ($contract instanceof Upload) {
                $contract->do_upload();
                $item->file_name = $contract->data('file_name');
            }
            //saving
            $item->save();
            $this->flashMessage('lang:furniture_message_upload-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/modules/furniture');
        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('furniture_breadcrumb_edit'), $item->contract_number),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = sprintf(lang('furniture_title_edit'), $item->contract_number);
        // render
        $this->render([
            'item' => $item,
            'error' => isset($error) ? $error : '',
            'page_title' => $page_title
        ]);
    }

    /**
     * Delete the document of the furniture
     *
     * @param  string $id furniture's id
     */
    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = FurnitureModel::find($id))) {
            redirect_referrer('backoffice/modules/furniture');
        }
        $item->file_name = null;
        $item->save();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/furniture');
    }

    public function sync()
    {
        // schedule furnitures import
        $job = new \App\Job\ImportFurnitures();
        $this->queueService->dispatch($job);

        // notify current user
        $user = $this->authenticationService->user();

        if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
            $email = new MailerContent();
            $email->to($user->username)
            ->setContent(
                'email_furnitures_sync',
                [
                    'user_first_name' => ucfirst(strtolower($user->first_name)),
                    'user_last_name' => ucfirst(strtolower($user->last_name)),
                    'user_email' =>  $user->email,
                    'customer_code' => '',
                    'front_url' => site_url('backoffice/modules/furniture'),
                    'nb_notif' => ''
                ]
            );

            $email->handle();
        }

        // redirect
        $this->flashMessage('lang:furniture_message_sync', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/furniture');
    }

    public function download($id = null)
    {
        $item = FurnitureModel::find($id);
        force_download($item->documentPath(), null);
    }

    protected function getValidator($item)
    {
        $validator = new FormValidation();

        $documentUploadConf = new Upload('contract', [
            'upload_path' => config_item('data_document_path') .'/furnitures/',
            'allowed_types' => 'pdf',
            'file_name' => sha1(uniqid()),
            'max_size' => 0
        ]);

        $validator->set_rules(
            'contract',
            'lang:furniture_label_contract',
            [
                [
                    // Test required document
                    'form_validation_required',
                    function () use ($documentUploadConf, $item) {
                        if (!$documentUploadConf->upload_file_exists()) {
                            if ($item) {
                                // Set value for required
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return true;
                        }
                    }
                ],
                [
                    // Test valid file,
                    'valid_file',
                    function () use ($validator, $documentUploadConf) {
                        if (!$documentUploadConf->upload_file_exists()) {
                            return true;
                        }
                        if (!$documentUploadConf->check_upload()) {
                            $validator->add_error($documentUploadConf->get_errors(), $documentUploadConf->get_field_name());
                            // return true dynamic error
                            return true;
                        } else {
                            return $documentUploadConf;
                        }
                    }
                ]
            ]
        );
        return $validator;
    }
}
