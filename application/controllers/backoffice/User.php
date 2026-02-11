<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\QueryFilter;
use \Globalis\PuppetSkilled\Library\QueryPager;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \Illuminate\Database\Query\Expression;
use \App\Model\User as UserModel;
use \App\Model\Role as RoleModel;
use \App\Model\Module as ModuleModel;
use \App\Job\MailerContent;
use Ramsey\Uuid\Uuid as Uuid;

class User extends \App\Core\Controller\BackOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date'
        ],
    ];

    protected $guards = [
        'index' => 'backoffice.user.view',
        'password' => 'backoffice.user.edit',
        'add' => 'backoffice.user.add',
        'edit' => 'backoffice.user.edit',
        'active_toggle' => 'backoffice.user.edit',
        'delete' => 'backoffice.user.delete',
    ];

    public function password()
    {
        $validator = $this->getValidatorPassword();
        $validator->set_data($this->input->post());
        if (!$validator->run()) {
            $this->returnJson(400, $validator->error_array());
        } else {
            $user = UserModel::find($validator->set_value('users'));
            $user->password = $validator->set_value('password');
            $user->password_reset_datetime = date('Y-m-d H:i:s');
            $user->login_tries = 0;
            $user->must_change_password = 1;

            if (!$user->save()) {
                $this->returnJson(400);
            }
        }
        $this->returnJson(200);
    }

    public function index()
    {
        $role_slugs = config_item('site_settings')['role_slugs'];

        $query =  UserModel::visible()
            ->with('rolesDefault.content.translations')
            ->with('rolesModule.content.translations')
            ->with('rolesModule.permissions')
            ->whereHas('rolesDefault', function ($query) use ($role_slugs) {
                $query->where('slug', '!=', $role_slugs['developer']);
            });

        $filters = new QueryFilter(
            [
                'filters' => [
                    'search' => function ($query, $value) {
                        return $query->where('last_name', 'like', $value . '%')
                            ->orWhere('first_name', 'like', $value . '%')
                            ->orWhere('email', 'like', $value . '%')
                            ->orWhere(new Expression('CONCAT(first_name, " ", last_name)'), 'like', $value . '%')
                            ->orWhere(new Expression('CONCAT(last_name, " ", first_name)'), 'like', $value . '%');
                    },
                    'role' => function ($query, $value) {
                        return $query->whereHas('roles', function ($query) use ($value) {
                            $query->where('slug', $value);
                        });
                    },
                    'active' => function ($query, $value) {
                        if ($value || $value === '0') {
                            return $query->where('active', $value);
                        }
                    },
                ],
                'default_filters' => [
                    'active' => [1]
                ],
                'save' => 'backoffice_users_filters',
            ]
        );
        $pager = new QueryPager(
            [
                'limit_choices' => [10, 20, 50],
                'limit' => 10,
                'sort' => [
                    'name' => 'last_name',
                    'email' => 'email',
                ],
                'save' => 'backoffice_users_pager',
                'unique_order_key' => $query->getModel()->getKeyName()
            ]
        );

        $pager->run($filters->run($query));
        $this->render([
            'filters' => $filters,
            'pager' => $pager,
            'roles' => RoleModel::default()->selectable()->get(),
            'role_slugs' => $role_slugs,
            'modules' => ModuleModel::with('content.translations')->where('permission', '!=', '')->get(),
        ]);
    }

    public function add()
    {
        $this->addOrEdit();
    }

    public function edit($id = null)
    {
        $item = $this->getEditItem($id);

        // alter breadcumb
        $this->breadcrumb['method'] = [
            'label' => sprintf(lang('user_breadcrumb_edit'), $item->first_name, $item->last_name),
            'uri' => current_url(),
        ];

        $this->addOrEdit($item);
    }

    public function active_toggle($id = null)
    {
        if ($this->input->method() !== 'post') {
            redirect_referrer('backoffice/user');
        }
        $item = $this->getEditItem($id);
        $item->active = ($item->active ? 0 : 1);
        $item->save();
        $item->releaseLock();
        $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/user');
    }

    public function delete($id = null)
    {
        if ($this->input->method() !== 'post' || !$id ||  !($item = UserModel::find($id))) {
            redirect_referrer('backoffice/user');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/user');
        }
        $item->delete();
        $this->flashMessage('lang:general_message_delete-success', 'lang:general_message_title-success', 'success');
        redirect('backoffice/user');
    }

    protected function addOrEdit(UserModel $user = null)
    {
        $validator = $this->getValidator($user);
        if (!$validator->run()) {
            $service = $this->languageService;
            $languages = $service->getLanguagesList();
            $this->render([
                'validator' => $validator,
                'roles' => RoleModel::default()->selectable()->get(),
                'languages' => $languages,
                'item' => $user,
                'modules' => ModuleModel::where('permission', '!=', '')->get(),
                'extra' => ['role_manager' => RoleModel::ID_MANAGER]
            ]);
        } else {
            // flash message
            $flashMessage = ($user ? 'lang:general_message_edit-success' : 'lang:general_message_add-success');
            $item = ($user ?: new UserModel());
            $item->first_name = $validator->set_value('first_name');
            $item->last_name = $validator->set_value('last_name');
            $item->email = $validator->set_value('email');
            $item->timezone = date_default_timezone_get();
            $item->date_format = 'DD MMMM YYYY';
            $item->datetime_format = 'DD MMMM YYYY, HH:mm';
            $item->language = 'fr';
            if (!empty($validator->set_value('password'))) {
                $item->password = $validator->set_value('password');
                $item->password_reset_datetime = date('Y-m-d H:i:s');
                $item->login_tries = 0;
                $item->must_change_password = 1;
            }
            $item->save();

            // Delete role type module
            $item->roles()->where('type', RoleModel::TYPE_MODULES)->delete();

            $roles = $item->roles()->syncWithPivotValues($validator->set_value('role'), ['id' => Uuid::uuid4()->toString()]);
            $item->saveModules($validator->set_value('modules[]') ?: []);
            $item->releaseLock();

            // notify the new user, we consider that no setting exists at this stage, we send the email
            if (!$item->password) {
                $token = $this->authenticationService->registerToken($item);
                $email = new MailerContent();
                $email->to($item->username)
                    ->setContent(
                        'email_new_user',
                        [
                            'user_first_name' => ucfirst(strtolower($item->first_name)),
                            'user_last_name' => ucfirst(strtolower($item->last_name)),
                            'user_email' =>  $item->email,
                            'front_url' => site_url('authentication/setup/' . $token),
                        ]
                    );
                $email->handle();
            }
            // redirect
            $this->flashMessage($flashMessage, 'lang:general_message_title-success', 'success');
            redirect('backoffice/user/edit/' . $item->getRouteKey());
        }
    }

    protected function getEditItem($id)
    {
        if (!$id ||  !($item = UserModel::find($id))) {
            redirect_referrer('backoffice/user');
        }
        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('backoffice/user');
        }
        return $item;
    }

    protected function getValidator($user = null)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'first_name',
            'lang:user_label_first-name',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'last_name',
            'lang:user_label_last-name',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'email',
            'lang:user_label_email',
            [
                'trim',
                'valid_email',
                [
                    'user_error_not_unique_email',
                    function ($value) use ($user) {
                        if (empty($value)) {
                            return true;
                        }
                        if ($user) {
                            $user = UserModel::where('username', $value)->where('id', '!=', $user->id)->count();
                        } else {
                            $user = UserModel::where('username', $value)->count();
                        }
                        if ($user !== 0) {
                            return false;
                        }
                        return true;
                    },
                ],
                'required'
            ]
        );
        $validator->set_rules(
            'role',
            'lang:user_label_roles',
            [
                'trim',
                'required'
            ]
        );
        $validator->set_rules(
            'modules[]',
            'lang:user_label_modules',
            [
                [
                    'required',
                    function ($value) use ($validator) {
                        if ($validator->set_value('role') === RoleModel::ID_MANAGER) {
                            // Required
                            return $validator->required($value);
                        }
                        // Empty modules
                        return '';
                    }
                ]
            ]
        );

        $validator->set_rules(
            'password',
            'lang:user_label_password',
            [
                'trim',
                'min_length[6]',
                'max_length[255]',
            ]
        );
        $validator->set_rules(
            'repeat_password',
            'lang:user_label_repeat_password',
            [
                'trim',
                'matches[password]',
            ],
            [
                'required' => 'Le champ Vérification du nouveau mot de passe doit correspondre au mot de passe.',
            ]
        );

        return $validator;
    }

    protected function getValidatorPassword()
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'users',
            'lang:contrat_label_user_id',
            [
                [
                    'valid_user_id',
                    function ($userId) {
                        if (UserModel::find($userId)) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                ],
            ],
            [
                'valid_user_id' => 'L\'utilisateur selectionné n\'a pas été trouvé.',
            ]
        );

        $validator->set_rules(
            'password',
            'lang:user_label_password',
            [
                'trim',
                'min_length[6]',
                'max_length[255]',
                'required'
            ]
        );
        $validator->set_rules(
            'repeat_password',
            'lang:user_label_repeat_password',
            [
                'trim',
                'matches[password]',
            ],
            [
                'required' => 'Le champ Vérification du nouveau mot de passe doit correspondre au mot de passe.',
            ]
        );

        return $validator;
    }
}
