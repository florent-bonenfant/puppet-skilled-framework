<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;
use \App\Job\MailerContent;
use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Family as FamilyModel;
use \App\Model\Role as RoleModel;
use \App\Model\User as UserModel;
use \App\Model\UsersRoles as UsersRolesModel;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;

class Customer extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date',
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.customer.view',
        'edit' => 'backoffice.customer.edit',
        'unlink' => 'backoffice.customer.edit',
        'active_toggle' => 'backoffice.customer.edit',
        'delete' => 'backoffice.customer.delete',
        'sync' => 'backoffice',
    ];

    public function index()
    {
        $query = CustomerModel::query();

        $filters = new QueryFilter(
            [
                'filters' => [
                    'search' => function ($query, $value) {
                        return $query->where('id', 'like', $value . '%')
                            ->orWhere('last_name', 'like', $value . '%')
                            ->orWhere('first_name', 'like', $value . '%')
                            ->orWhere('city', 'like', $value . '%')
                            ->orWhere('email', 'like', $value . '%');
                    },
                    'families' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereIn('family_id', $value);
                        }
                    },
                    'companies' => function ($query, $value) {
                        if (count($value) > 0) {
                            return $query->whereIn('company_id', $value);
                        }
                    },

                    'active' => function ($query, $value) {
                        if ($value || $value === '0') {
                            return $query->where('active', $value);
                        }
                    },
                ],
                'default_filters' => [
                    'active' => [1],
                ],
                'save' => 'backoffice_customers_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'id' => 'id',
                    'name' => 'last_name',
                    'email' => 'email',
                    'city' => 'city',
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_customers_pager',
                'unique_order_key' => $query->getModel()->getKeyName(),
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'companies' => CompanyModel::all(),
            'families' => FamilyModel::all(),
        ]);
    }

    public function unlink($customerId, $userId)
    {
        $deleted = UsersRolesModel::where('customer_id', $customerId)
            ->where('user_id', $userId)
            ->delete();

        if ($deleted) {
            $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        } else {
            $this->flashMessage('lang:customer_message_cant_delete', 'lang:general_message_title-error', 'error');
        }

        redirect('backoffice/customer/edit/' . $customerId);
    }

    public function edit($id = null)
    {
        $item = $this->getEditItem($id);

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('customer_breadcrumb_edit'), $item->id),
            'uri' => current_url(),
        ];

        $validator = new FormValidation();
        $validator->set_rules(
            'email',
            'lang:customer_label_email',
            [
                'trim',
                'valid_email',
                'required',
            ]
        );

        $queryForPager = UserModel::query();
        $queryForPager->select('users.*')
            ->join((new UsersRolesModel)->getTable(), 'users.id', '=', 'users_roles.user_id')
            ->join((new CustomerModel)->getTable(), 'users_roles.customer_id', '=', 'customers.id')
            ->where('customers.id', $item->id);

        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 20,
                'sort' => [
                    'id' => 'id',
                    'name' => 'last_name',
                    'email' => 'email',
                    'city' => 'city',
                    'created_at' => 'created_at',
                ],
                'save' => 'backoffice_customers_users_pager',
                'unique_order_key' => $queryForPager->getModel()->getKeyName(),
            ]
        );

        $pager->run($queryForPager);

        if ($validator->run()) {
            // save user
            $user = UserModel::where('username', $item->email)->first();
            if ($user) {
                if ($user->email !== $validator->set_value('email')) {
                    // Edit all customers linked to this one
                    foreach ($user->customers as $c) {
                        $c->email = $validator->set_value('email');
                        $c->save();
                        $this->exportCustomer->export($c->id, [
                            'email' => $c->email,
                            'has_accepted_eula' => $user->has_accepted_eula,
                        ]);
                    }
                }

                $user->username = $validator->set_value('email');
                $user->email = $validator->set_value('email');
            } else {
                $user = new UserModel();
                $user->username = $validator->set_value('email');
                $user->email = $validator->set_value('email');
                $user->first_name = $item->name;
                $user->last_name = $item->sign;
                $user->timezone = date_default_timezone_get();
                $user->date_format = 'DD MMMM YYYY';
                $user->datetime_format = 'DD MMMM YYYY, HH:mm';
                $user->language = 'fr';
                $user->visible = 0;
            }
            $user->save();



            // link user
            $role = UsersRolesModel::where('user_id', $user->id)
                ->where('customer_id', $item->id)->count();
            if (!$role) {
                $role = new UsersRolesModel();
                $role->user_id = $user->id;
                $role->customer_id = $item->id;
                $role->role_id = RoleModel::ID_CUSTOMER;
                $role->save();
            }

            // save customer
            $item->email = $validator->set_value('email');
            $item->save();
            $item->releaseLock();

            // redirect
            $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
            redirect('backoffice/customer/edit/' . $item->id);
        }

        // render
        $this->render([
            'pager' => $pager,
            'item' => $item,
            'validator' => $validator,
        ]);
    }

    public function active_toggle($id = null)
    {
        if ($this->input->method() !== 'post') {
            redirect_referrer('backoffice/customer');
        }
        $item = $this->getEditItem($id);
        $item->active = ($item->active ? 0 : 1);
        $item->save();

        // notify user
        if (!$item->isClosed && !$item->isRestricted) {
            $user = UserModel::where('username', $item->email)->first();

            $email = new MailerContent();
            if ($user->password) {
                // If user already setup, just notify a new customer account has been linked and activated
                $email->to($user->username)
                    ->setContent(
                        'email_new_customer',
                        [
                            'user_first_name' => ucfirst(strtolower($user->first_name)),
                            'user_last_name' => ucfirst(strtolower($user->last_name)),
                            'user_email' => $user->email,
                            'customer_code' => $item->id,
                            'front_url' => config_item('front_base_url'),
                            'nb_notif' => '',
                        ]
                    );
            } else {
                // Notify user to setup her account
                $user->password_reset_token = bin2hex(random_bytes(20));
                $user->password_reset_datetime = Carbon::now();
                $user->save();

                $email->to($user->username)
                    ->setContent(
                        'email_new_user',
                        [
                            'user_first_name' => ucfirst(strtolower($user->first_name)),
                            'user_last_name' => ucfirst(strtolower($user->last_name)),
                            'user_email' => $user->email,
                            'customer_code' => $item->id,
                            'front_url' => config_item('front_base_url') . '/new_password/' . $user->password_reset_token,
                            'nb_notif' => '',
                        ]
                    );
            }

            $email->handle();
        }

        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/customer');
    }

    public function delete($id = null)
    {
        $item = $this->getEditItem($id);
        if ($this->input->method() !== 'post') {
            redirect_referrer('backoffice/customer');
        }

        $user = UserModel::where('username', $item->email)->first();
        if ($user && $user->password) {
            $this->flashMessage('lang:customer_message_cant_delete', 'lang:general_message_title-error', 'error');
        } else {
            $item->delete();
            $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        }
        redirect('backoffice/customer');
    }

    public function sync()
    {
        // schedule customers import
        $job = new \App\Job\ImportFamilies();
        $this->queueService->dispatch($job);

        // schedule customers import
        $job = new \App\Job\ImportCustomers();
        $job->delay(1);
        $this->queueService->dispatch($job);

        // schedule customers support import
        $job = new \App\Job\ImportSupport();
        $this->queueService->dispatch($job);

        // Configure notification mail
        $user = UserModel::find($this->session->userdata('authentication.user'));
        if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
            $email = new MailerContent();
            $email->to($user->username)
                ->setContent(
                    'email_customers_sync',
                    [
                        'user_first_name' => ucfirst(strtolower($user->first_name)),
                        'user_last_name' => ucfirst(strtolower($user->last_name)),
                        'user_email' => $user->email,
                        'customer_code' => '',
                        'front_url' => site_url('backoffice/customer'),
                        'nb_notif' => '',
                    ]
                );

            $email->handle();
        }

        // redirect
        $this->flashMessage('lang:customer_message_sync', 'lang:general_message_title-success', 'success');
        redirect('backoffice/customer');
    }

    protected function getEditItem($id)
    {
        if (!$id || !($item = CustomerModel::find($id))) {
            redirect_referrer('backoffice/customer');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/customer');
        }
        return $item;
    }
}
