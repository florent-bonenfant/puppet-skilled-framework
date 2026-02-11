<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Library\Upload;
use \App\Model\CommercialCondition as CommercialConditionModel;
use \App\Model\Family as FamilyModel;
use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\User as UserModel;
use Carbon\Carbon;
use \App\Model\UsersRoles as UsersRolesModel;
use Ramsey\Uuid\Uuid as Uuid;

class Commercial_condition extends \App\Core\Controller\BackOffice
{

    protected $autoload = [
        'helper' => [
            'form',
            'date',
            'download'
        ],
        'language' => [
            'backoffice/commercial_condition'
        ]
    ];

    protected $guards = [
        'index' => 'backoffice.modules.commercial_condition.view',
        'add' => 'backoffice.modules.commercial_condition.add',
        'edit' => 'backoffice.modules.commercial_condition.edit',
        'download' => 'backoffice.modules.commercial_condition.view',
        'delete' => 'backoffice.modules.commercial_condition.delete',
        'restore' => 'backoffice.modules.commercial_condition.delete',
    ];

    public function index()
    {
        $query =  CommercialConditionModel::withTrashed()->with('companies')->with('families');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'label' => function ($query, $value) {
                        $query->where('label', 'like', '%'.$value.'%');
                    },
                    'deleted' => function ($query, $value) {
                        if (!$value) {
                          $query->whereNull('deleted_at');
                        }
                    },
                    'families' => function($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('families', function($query) use ($value) {
                                return $query->whereIn('families.id', (array) $value);
                            });
                        }
                    },
                    'companies' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('companies', function($query) use ($value) {
                                return $query->whereIn('companies.id', (array) $value);
                            });
                        }
                    },
                ],
                'default_filters' => [
                    'deleted' => 0
                ],
                'save' => 'backoffice_modules_commercial_condition_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'label' => 'label',
                    'publication_date' => 'publication_date',
                    'end_publication_date' => 'end_publication_date',
                ],
                'save' => 'backoffice_modules_commercial_condition_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );
        // recup list companies / families
        $companies = CompanyModel::query()->get();
        $families = FamilyModel::query()->get();

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'companies' => $companies,
            'families' => $families,
        ]);
    }

    public function add()
    {
        $this->addOrEdit();
    }

    public function edit($id = null)
    {
        if (!$id ||  !($item = CommercialConditionModel::find($id))) {
            redirect_referrer('backoffice/modules/commercial_condition');
        }

        $this->addOrEdit($item);
    }

    protected function addOrEdit(CommercialConditionModel $item = null)
    {
        $validator = $this->getValidator($item);
        $page_title = lang('commercial_condition_breadcrumb_add');
        if ($item) {
            $this->breadcrumb['method'] = [
                'label' => sprintf(lang('commercial_condition_breadcrumb_edit'), $item->label),
                'uri' => current_url(),
            ];
            $page_title = sprintf(lang('commercial_condition_title_edit'), $item->label);
        }

        if ($validator->run()) {
            $publication_date = new Carbon($validator->set_value('publication_date'));
            $publication_date = $publication_date->format('Y-m-d');

            if ($end_publication_date = new Carbon($validator->set_value('end_publication_date'))) {
                $end_publication_date = $end_publication_date->format('Y-m-d');
            }

            // flash message
            $flashMessage = ($item ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');

            $item = ($item ?: new CommercialConditionModel());
            $item->label = $validator->set_value('label');
            $item->publication_date = $publication_date;
            $item->end_publication_date = $end_publication_date;

            // upload document
            $document = $validator->set_value('document');
            if ($document instanceof Upload) {
                $document->do_upload();
                $item->document = $document->data('file_name');
            }
            //saving
            $item->save();

            // saving publics
            $post_companies = $validator->set_value('companies[]');
            $post_families = $validator->set_value('families[]');

            $item->companies()->sync($post_companies);
            $item->families()->sync($post_families);

            //Send a notification if selected
            $today_int = strtotime(date('Y-m-d'));
            if ($validator->set_value('send_notification') && $today_int >= strtotime($publication_date) && $today_int <= strtotime($end_publication_date)) {
                $customers = CustomerModel::whereIn('customers.company_id', $post_companies)
                    ->join((new UsersRolesModel)->getTable(), 'customers.id', '=', 'users_roles.customer_id')
                    ->join((new UserModel)->getTable(), 'users_roles.user_id', '=', 'users.id')
                    ->where('users.allow_notification', 1)
                    ->whereIn('customers.family_id', $post_families)
                    ->get(['customers.id']);
                $customer_ids = [];
                foreach ($customers as $customer) {
                    $customer_ids[] = $customer->id;
                }

                $notif = new \App\Service\Notification\Notification();
                $notif->send('notification_new_commercial_condition', $customer_ids);
            }

            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/modules/commercial_condition/edit/' . $item->getRouteKey());
        }

        $this->render([
            'validator' => $validator,
            'item' => $item,
            'companies' => CompanyModel::query()->get(),
            'families' => FamilyModel::query()->get(),
            'page_title' => $page_title
        ]);
    }

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = CommercialConditionModel::find($id))) {
            redirect_referrer('backoffice/modules/commercial_condition');
        }

        $item->delete();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/commercial_condition');
    }

    public function restore($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = CommercialConditionModel::withTrashed()->find($id))) {
            redirect_referrer('backoffice/modules/commercial_condition');
        }

        $item->deleted_at = null;
        $item->save();
        $this->flashMessage('lang:general_message_restore-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/commercial_condition');
    }

    public function download($id = null)
    {
        $item = CommercialConditionModel::find($id);
        force_download($item->documentPath(), null);
    }

    protected function getValidator($item)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'label',
            'lang:commercial_condition_label_label',
            [
                'trim',
                'required',
                'max_length[50]',
            ]
        );
        $validator->set_rules(
            'companies[]',
            'lang:commercial_condition_label_companies',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'families[]',
            'lang:commercial_condition_label_families',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'publication_date',
            'lang:commercial_condition_label_publication_date',
            [
                'required',
                'get_input_date'
            ]
        );
        $validator->set_rules(
            'end_publication_date',
            'lang:commercial_condition_label_end_publication_date',
            [
                [
                    'date_lt_than',
                    function($value) use ($validator) {
                        if ($value = get_input_date($value)) {
                            $date = $validator->set_value('publication_date');
                            if ($date instanceof Carbon && $date->gt($value)) {
                                return false;
                            }
                            return $value;
                        }
                        return null;
                    },
                ]
            ],
            [
                'date_lt_than' => sprintf(
                    lang('form_validation_date_greater_than'),
                    lang('commercial_condition_label_end_publication_date'),
                    lang('commercial_condition_label_publication_date')
                ),
            ]
        );

        $documentUploadConf = new Upload('document', [
            'upload_path' => CommercialConditionModel::getUploadDir(),
            'allowed_types' => 'pdf',
            'file_name' => sha1(uniqid()),
            'max_size' => 0
        ]);

        $validator->set_rules(
            'document',
            'lang:commercial_condition_label_document',
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

        $validator->set_rules(
            'send_notification',
            'lang:commercial_condition_label_order',
            [
                'trim',
            ]
        );

        return $validator;
    }
}
