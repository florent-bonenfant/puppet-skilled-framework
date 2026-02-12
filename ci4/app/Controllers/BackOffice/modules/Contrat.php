<?php

namespace App\Controllers\BackOffice\Modules;

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Library\Upload;
use \App\Job\MailerContent;
use \App\Model\Contrat as ContratModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Company as CompanyModel;

class Contrat extends \App\Core\Controller\BackOffice
{

    protected $autoload = [
        'helper' => [
            'form',
            'download',
            'date'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.modules.contrat.view',
        'edit' => 'backoffice.modules.contrat.edit',
        'delete' => 'backoffice.modules.contrat.delete',
        'sync' => 'backoffice',
        'upload' => 'backoffice.modules.contrat.edit',
        'download' => 'backoffice.modules.contrat.view'
    ];

    public function index()
    {
        $query =  ContratModel::query();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'city' => function ($query, $value) {
                        return $query->where('city', 'like', '%'.$value.'%');
                    },
                    'customer' => function ($query, $value) {
                        return $query->where('customer_id', 'like','%'.$value.'%');
                    }
                ],
                'save' => 'backoffice_modules_contrats_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'original_file_name' => 'original_file_name',
                    'city'               => 'city',
                    'customer_id'        => 'customer_id',
                    'company_id'         => 'company_id',
                    'created_at'         => 'created_at',
                ],
                'save' => 'backoffice_modules_contrats_pager',
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
        $item = ContratModel::find($id);
        if (!$item) {
            redirect('backoffice/modules/contrat');
        }

        $companies = CompanyModel::query()->get();
        $validator = $this->getValidator($item);
        if ($validator->run()) {
            // upload contract
            $item = $this->hydrateContrat($item, $validator);
            //saving
            $item->save();
            $this->flashMessage('lang:contrat_message_upload-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/modules/contrat');
        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('contrat_breadcrumb_edit'), $item->original_file_name),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = sprintf(lang('contrat_title_edit'), $item->original_file_name);
        // render
        $this->render([
            'validator'  => $validator,
            'item'       => $item,
            'companies'  => $companies,
            'page_title' => $page_title
        ]);
    }

    public function add()
    {
        $companies = CompanyModel::query()->get();
        $validator = $this->getValidator();

        if ($validator->run()) {

            $contrat = new ContratModel();
            $contrat = $this->hydrateContrat($contrat, $validator);
            //saving
            $contrat->save();
            $this->flashMessage('lang:contrat_message_add-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/modules/contrat');

        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => lang('contrat_breadcrumb_add'),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = lang('contrat_title_add');
        // render
        $this->render([
            'validator'  => $validator,
            'companies'  => $companies,
            'error'      => isset($error) ? $error: '',
            'page_title' => $page_title
        ]);
    }

    /**
     * Delete the contrat
     *
     * @param  string $id contrat's id
     */
    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = ContratModel::find($id))) {
            redirect_referrer('backoffice/modules/contrat');
        }
        $item->delete();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/contrat');
    }

    /**
     * Delete the document of the contrat
     *
     * @param  string $id furniture's id
     */
    public function delete_file($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = ContratModel::find($id))) {
            redirect_referrer('backoffice/modules/contrat');
        }
        $item->file_name = null;
        $item->save();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/contrat/edit/' . $id);
    }

    public function sync()
    {
        // schedule contrats import
        $job = new \App\Job\ImportContrats();
        $this->queueService->dispatch($job);

        // notify current user
        $user = $this->authenticationService->user();
        if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
            $email = new MailerContent();
            $email->to($user->username)
            ->setContent(
                'email_contrats_sync',
                [
                    'user_first_name' => ucfirst(strtolower($user->first_name)),
                    'user_last_name' => ucfirst(strtolower($user->last_name)),
                    'user_email' =>  $user->email,
                    'customer_code' => '',
                    'front_url' => site_url('backoffice/modules/contrat'),
                    'nb_notif' => ''
                ]
            );

            $email->handle();
        }

        // redirect
        $this->flashMessage('lang:contrat_message_sync', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/contrat');
    }

    public function download($id = null)
    {
        $item = ContratModel::find($id);
        force_download($item->documentPath(), null);
    }

    /**
     * Hydrates a ContratModel object
     *
     * @param ContratModel $contrat
     * @param FormValidation $validator
     * @return void
     */
    private function hydrateContrat(ContratModel $contrat, FormValidation $validator)
    {
        // hydrates the contrat object
        //we know the customer exists because the validator has verified that it can be found
        $contrat->customer_id        = $validator->set_value('customer_id');
        $contrat->company_id         = $validator->set_value('companies');
        $contrat->city               = $validator->set_value('city');
        $contrat->original_file_name = $validator->set_value('original_file_name');
        // upload contract
        $contract = $validator->set_value('contract');
        // executes the file upload of necessary, or deletes the file_name field if no file was chosen
        if ($contract instanceof Upload) {
            $contract->do_upload();
            $contrat->file_name = $contract->data('file_name');
        }
        return $contrat;
    }

    protected function getValidator($item = null)
    {
        $validator = new FormValidation();

        $documentUploadConf = new Upload('contract', [
            'upload_path' => config_item('data_document_path') .'/contrats/',
            'allowed_types' => 'pdf',
            'file_name' => sha1(uniqid()),
            'max_size' => 0
        ]);

        $validator->set_rules(
            'original_file_name',
            'lang:contrat_label_original_file_name',
            [
                'trim',
                'max_length[255]',
                'required'
            ]
        );

        $validator->set_rules(
            'city',
            'lang:contrat_label_city',
            [
                'trim',
                'max_length[255]',
                'required'
            ]
        );

        $validator->set_rules(
            'customer_id',
            'lang:contrat_label_customer_id',
            [
                [
                    'valid_customer_id',
                    function ($customer_id) {
                        if (CustomerModel::find($customer_id)) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                ],
            ],
            [
                'valid_customer_id' => 'Le code client doit être valide et correspondre à un client existant.',
            ]
        );
        $validator->set_rules(
            'companies',
            'lang:message_label_companies',
            [
                'trim',
                'required',
            ]
        );

        $validator->set_rules(
            'contract',
            'lang:contrat_label_contract',
            [
                [
                    // Test valid file,
                    'valid_file',
                    function () use ($validator, $documentUploadConf) {

                        if (!$documentUploadConf->upload_file_exists()) {
                            return true;
                        }
                        if (!$documentUploadConf->check_upload()) {
                            $validator->add_error(lang('contrat_error_document_format'), $documentUploadConf->get_field_name());
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
