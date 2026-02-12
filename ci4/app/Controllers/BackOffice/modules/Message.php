<?php

namespace App\Controllers\BackOffice\Modules;

use Carbon\Carbon;
use \App\Job\MailerContent;
use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Family as FamilyModel;
use \App\Model\Message as MessageModel;
use \App\Model\User as UserModel;
use \App\Model\UsersRoles as UsersRolesModel;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use Ramsey\Uuid\Uuid as Uuid;

class Message extends \App\Core\Controller\BackOffice
{

    protected $autoload = [
        'helper' => [
            'form',
            'date',
            'download',
        ],
        'language' => [
            'backoffice/message',
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.modules.message.view',
        'add' => 'backoffice.modules.message.add',
        'edit' => 'backoffice.modules.message.edit',
        'delete' => 'backoffice.modules.message.delete',
        'restore' => 'backoffice.modules.message.delete',
    ];

    public function index()
    {
        $query = MessageModel::withTrashed()->with('companies')->with('families');
        $filters = new QueryFilter(
            [
                'filters' => [
                    'title' => function ($query, $value) {
                        $query->where('title', 'like', '%' . $value . '%');
                    },
                    'deleted' => function ($query, $value) {
                        if (!$value) {
                            $query->whereNull('deleted_at');
                        }
                    },
                    'families' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('families', function ($query) use ($value) {
                                return $query->whereIn('families.id', (array) $value);
                            });
                        }
                    },
                    'companies' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereHas('companies', function ($query) use ($value) {
                                return $query->whereIn('companies.id', (array) $value);
                            });
                        }
                    },
                ],
                'default_filters' => [
                    'deleted' => 0,
                ],
                'save' => 'backoffice_modules_message_filters',
            ]
        );

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'title' => 'title',
                    'type' => 'type',
                    'order' => 'order',
                    'publication_date' => 'publication_date',
                    'end_publication_date' => 'end_publication_date',
                ],
                'save' => 'backoffice_modules_message_pager',
                'unique_order_key' => $query->getModel()->getKeyName(),
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
        if (!$id || !($item = MessageModel::find($id))) {
            redirect_referrer('backoffice/modules/message');
        }
        $this->addOrEdit($item);
    }

    protected function addOrEdit(MessageModel $item = null)
    {
        $validator = $this->getValidator($item);
        $page_title = lang('message_breadcrumb_add');
        if ($item) {
            $this->breadcrumb['method'] = [
                'label' => sprintf(lang('message_breadcrumb_edit'), $item->title),
                'uri' => current_url(),
            ];
            $page_title = sprintf(lang('message_title_edit'), $item->title);
        }
        if ($validator->run()) {

            $publication_date = new Carbon($validator->set_value('publication_date'));
            $publication_date = $publication_date->format('Y-m-d');

            if ($end_publication_date = new Carbon($validator->set_value('end_publication_date'))) {
                $end_publication_date = $end_publication_date->format('Y-m-d');
            }

            // flash message
            $flashMessage = ($item ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');

            $item = ($item ?: new MessageModel());
            $item->title = $validator->set_value('title');
            $item->content = $validator->set_value('content');
            $item->order = $validator->set_value('order');
            $item->publication_date = $publication_date;
            $item->end_publication_date = $end_publication_date;

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
                    ->isNotClosed()
                    ->isNotRestricted()
                    ->whereIn('customers.family_id', $post_families)
                    ->get(['customers.id']);

                $customer_ids = [];
                foreach ($customers as $customer) {
                    $customer_ids[] = $customer->id;
                }
                $notif = new \App\Service\Notification\Notification();
                $notif->send('notification_new_message', $customer_ids);
            }

            // true if we are creating a new cgv
            if ($item->wasRecentlyCreated) {
                // gets the customers that are interested in this cgv
                $customers = CustomerModel::whereIn('company_id', $post_companies)
                    ->join((new UsersRolesModel)->getTable(), 'customers.id', '=', 'users_roles.customer_id')
                    ->join((new UserModel)->getTable(), 'users_roles.user_id', '=', 'users.id')
                    ->where('users.allow_email', 2)
                    ->isNotClosed()
                    ->isNotRestricted()
                    ->whereIn('customers.family_id', $post_families)
                    ->get(['customers.id', 'customers.email', 'customers.first_name', 'customers.last_name']);

                foreach ($customers as $key => $customer) {
                    if (!$customer->isClosed && !$customer->isRestricted) {
                        // sends an email to the customers to notify them of the new cgv
                        $email = new MailerContent();
                        $email->to($customer->email)
                            ->setContent(
                                'email_new_message',
                                [
                                    'user_first_name' => ucfirst(strtolower($customer->first_name)),
                                    'user_last_name' => ucfirst(strtolower($customer->last_name)),
                                    'user_email' => $customer->email,
                                    'front_url' => config_item('front_base_url') . '/message',
                                ]
                            );
                        $email->handle();
                    }
                }
            }

            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/modules/message/edit/' . $item->getRouteKey());
        }

        $this->render([
            'validator' => $validator,
            'item' => $item,
            'companies' => CompanyModel::query()->get(),
            'families' => FamilyModel::query()->get(),
            'page_title' => $page_title,
        ]);
    }

    public function view($id = null)
    {
        if (!$id || !($item = MessageModel::find($id))) {
            redirect_referrer('backoffice/modules/message');
        }

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('message_breadcrumb_view'), $item->title),
            'uri' => current_url(),
        ];
        // alter page title
        $page_title = sprintf(lang('message_title_view'), $item->title);
        // render
        $this->render([
            'item' => $item,
            'page_title' => $page_title,
        ]);
    }

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id || !($item = MessageModel::find($id))) {
            redirect_referrer('backoffice/modules/message');
        }

        $item->delete();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/message');
    }

    public function restore($id = null)
    {
        if ($this->input->method() !== 'post' || !$id || !($item = MessageModel::withTrashed()->find($id))) {
            redirect_referrer('backoffice/modules/message');
        }

        $item->deleted_at = null;
        $item->save();
        $this->flashMessage('lang:general_message_restore-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/modules/message');
    }

    protected function getValidator($item)
    {

        $validator = new FormValidation();
        $validator->set_rules(
            'title',
            'lang:message_label_title',
            [
                'trim',
                'max_length[255]',
                'required',
            ]
        );
        $validator->set_rules(
            'content',
            'lang:message_label_content',
            [
                'trim',
                'required',
            ]
        );
        $validator->set_rules(
            'companies[]',
            'lang:message_label_companies',
            [
                'trim',
                'required',
            ]
        );
        $validator->set_rules(
            'families[]',
            'lang:message_label_families',
            [
                'trim',
                'required',
            ]
        );
        $validator->set_rules(
            'order',
            'lang:message_label_order',
            [
                'trim',
                'required',
                'is_natural',
                'max_length[10]',
            ]
        );
        $validator->set_rules(
            'publication_date',
            'lang:message_label_publication_date',
            [
                'required',
                'get_input_date',
            ]
        );
        $validator->set_rules(
            'end_publication_date',
            'lang:message_label_end_publication_date',
            [
                [
                    'date_lt_than',
                    function ($value) use ($validator) {
                        if ($value = get_input_date($value)) {
                            $date = $validator->set_value('publication_date');
                            if ($date instanceof Carbon && $date->gt($value)) {
                                return false;
                            }
                            return $value;
                        }
                        return null;
                    },
                ],
            ],
            [
                'date_lt_than' => sprintf(
                    lang('form_validation_date_greater_than'),
                    lang('message_label_end_publication_date'),
                    lang('message_label_publication_date')
                ),
            ]
        );
        $validator->set_rules(
            'send_notification',
            'lang:message_label_order',
            [
                'trim',
            ]
        );

        return $validator;
    }
}
