<?php
use \App\Model\User as UserModel;
use \App\Model\UsersDelegates;
use \App\Model\UsersRoles;
use \App\Model\Role;
use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Job\MailerContent;
use Carbon\Carbon;
use \Globalis\PuppetSkilled\Core\Application;

defined('BASEPATH') or exit('No direct script access allowed');

class Delegate_user extends \App\Core\Controller\Webservice
{
    protected $isPublic = false;

    /**
     * @api {get} /delegateUser
     * @apiName delegateUserAll
     * @apiGroup delegateUser
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         User list
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function all()
    {
        $this->lang->load('webservice/module_lang.php', 'french');
        $children = UsersDelegates::where('parent_user_id', $this->session->userdata['authentication.user'])
            ->where('customer_id', $this->customer->id)
            ->get();
        $result = [];

        foreach ($children as $key => $child) {
            $user = UserModel::where('id', $child->user_id)->first();
            $result[$key] = [
                'id'          => $user->id,
                'first_name'  => $user->first_name,
                'last_name'   => $user->last_name,
                'allow_email' => $user->allow_email,
                'allow_notification' => $user->allow_notification,
                'email'       => $user->email,
                'permissions' => $this->getChildUserPermissions($user->id, $this->customer->id),
            ];
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $result,
        ]);
    }

    /**
     * @api {get} /delegateUser/{id}
     * @apiName delegateUserOne
     * @apiGroup delegateUser
     * @apiVersion 1
     *
     * @apiSuccess (200)    {array}        result         User
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function one($id)
    {
        $this->lang->load('webservice/module_lang.php', 'french');

        $result = UserModel::where('id', $id)->get(['id', 'first_name', 'last_name', 'email']);

        foreach ($result as $key => $user) {
            if (empty($user->id)) {
                continue;
            }

            $result[$key]['permissions'] = $this->getChildUserPermissions($user->id, $this->customer->id);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => $result[0],
        ]);
    }

    /**
     * @api {put} /delegate_user/{id}  Updates a delegate user
     * @apiName delegateUserUpdate
     * @apiGroup delegateUser
     * @apiVersion 1
     *
     * @apiSuccess (201)    {result}
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function update_one($id = null)
    {
        if (!($user = UserModel::find($id))) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'UPDATE_DELEGATE_USER_ERROR',
            ]);
        }

        // loads the language file
        $this->lang->load('webservice/delegate_user_lang.php', 'french');

        // loads the parent user
        if (!$parent = $this->authenticationService->user()) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'NOT_LOGGED'
            ]);
        }

        if ($parent->id === $user->id) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'CREATE_DELEGATE_USER_ERROR',
                'resultContent' => lang('same_user_error')
            ]);
        }

        // sets the validator
        $validator = $this->get_validator(true);
        parse_str(urldecode($this->input->raw_input_stream), $data);
        $validator->set_data($data);

        // if validator validates the form
        if ($validator->run()) {
            app()->load->helper('date_helper');
            // Mea culpa, no capsule, no transaction in queryBuilder
            $db = Application::getInstance()->get('db');
            try {
                $db->query('START TRANSACTION;');
                $user->username = $validator->set_value('email');
                $user->email = $validator->set_value('email');
                $user->first_name = $validator->set_value('first_name');
                $user->last_name = $validator->set_value('last_name');
                $user->allow_email = $validator->set_value('allow_email');
                $user->allow_notification = $validator->set_value('allow_notification');
                $user->save();

                // delete previous role for current parent
                $user_role = UsersRoles::where('user_id', $user->id)
                                    ->where('customer_id', $this->customer->id)
                                    ->first();

                if ($user_role) {
                    Role::where('id', $user_role->role_id)
                        ->where('slug', Role::SLUG_DELEGATE)
                        ->delete();

                    // On s'assure du nettoyage
                    UsersRoles::where('user_id', $user->id)
                        ->where('customer_id', $this->customer->id)
                        ->delete();
                }

                // set permissions (and role) related to parent
                $permissions = $validator->set_value('permissions[]');
                $user->saveDelegateModules($permissions ?: [], $this->customer->id);

                // check delegate has current parent
                $has_current_parent = UsersDelegates::where('user_id', $user->id)
                                                    ->where('parent_user_id', $parent->id)
                                                    ->where('customer_id', $this->customer->id)
                                                    ->first();

                if (!$has_current_parent) {
                    $delegate = new UsersDelegates();
                    $delegate->user_id = $user->id;
                    $delegate->parent_user_id = $parent->id;
                    $delegate->customer_id = $this->customer->id;
                    $delegate->save();

                    // send email for new customer id
                    if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
                        $email = new MailerContent();
                        $email->to($user->username)->setContent(
                            'email_new_customer',
                            [
                                'user_first_name' => ucfirst(strtolower($user->first_name)),
                                'user_last_name' => ucfirst(strtolower($user->last_name)),
                                'user_email' =>  $user->email,
                                'customer_code' => $this->customer->id,
                                'front_url' => config_item('front_base_url'),
                                'nb_notif' => ''
                            ]
                        );
                        $email->handle();
                    }
                }

                $db->query('COMMIT;');
                $this->return(static::HTTP_CREATED, [
                    'resultCode' => 'UPDATE_DELEGATE_USER_SUCCESS',
                    'resultContent' => $user,
                ]);
            }  catch (\PDOException $e) {
                $db->query('ROLLBACK;');
                app()->load->language('db_lang');
                $this->return(static::HTTP_INTERNAL_SERVER_ERROR, [
                    'resultCode' => 'CREATE_DELEGATE_USER_ERROR',
                    'resultContent' => lang('db_transaction_failure')
                ]);
            }
        } else {
            //if the validator didn't validate the form
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'UPDATE_DELEGATE_USER_ERROR',
                'resultContent' => $validator->error_array(),
            ]);
        }
    }

    /**
     * @api {post} /delegate_user  Creates a delegate user
     * @apiName delegateUserCreate
     * @apiGroup delegateUser
     * @apiVersion 1
     *
     * @apiSuccess (201)    {result}
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function create_one()
    {
        // loads the language file
        $this->lang->load('webservice/delegate_user_lang.php', 'french');

        // loads the parent user
        if (!$this->authenticationService->user()) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'NOT_LOGGED'
            ]);
        }

        // check already exists for another customer/parent
        $pre_validator = $this->get_validator(true);
        $pre_validator->run();
        $user = UserModel::where('email', $pre_validator->set_value('email'))->first();

        if ($user) {
            return $this->update_one($user->id);
        }

        // set the validator
        $validator = $this->get_validator();

        // if validator validates the form
        if ($validator->run()) {
            app()->load->helper('date_helper');

            $db = Application::getInstance()->get('db');

            try {
                $db->query('START TRANSACTION;');

                // creates a new user, hydrates and saves it
                $user = new UserModel();
                $user->username = $validator->set_value('email');
                $user->email = $validator->set_value('email');
                $user->first_name = $validator->set_value('first_name');
                $user->last_name = $validator->set_value('last_name');
                $user->allow_notification = 1;
                $user->allow_email = 1;
                $user->timezone = date_default_timezone_get();
                $user->date_format = 'DD MMMM YYYY';
                $user->datetime_format = 'DD MMMM YYYY, HH:mm';
                $user->language = 'fr';
                $user->visible = 0;
                $user->password_reset_token = bin2hex(random_bytes(20));
                $user->password_reset_datetime = Carbon::now();

                $user->save();

                // set permissions (and role)
                $permissions = $validator->set_value('permissions[]');
                $user->saveDelegateModules($permissions ?: [], $this->customer->id);

                // set parent
                $delegate = new UsersDelegates();
                $delegate->user_id = $user->id;
                $delegate->parent_user_id = $this->session->userdata['authentication.user'];
                $delegate->customer_id = $this->customer->id;
                $delegate->save();

                $db->query('COMMIT;');

                // sends mail to the new user
                if ($user->allow_email && !$this->customer->isClosed && !$this->customer->isRestricted) {
                    $email = new MailerContent();
                    $email->to($user->username)->setContent(
                        'email_new_user',
                        [
                            'user_first_name' => ucfirst(strtolower($user->first_name)),
                            'user_last_name' => ucfirst(strtolower($user->last_name)),
                            'user_email' =>  $user->email,
                            'customer_code' => $user->id,
                            'front_url' => config_item('front_base_url').'/new_password/' . $user->password_reset_token,
                            'nb_notif' => ''
                        ]
                    );
                    $email->handle();
                }
                $this->return(static::HTTP_CREATED, [
                    'resultCode' => 'CREATE_DELEGATE_USER_SUCCESS',
                    'resultContent' => $user,
                ]);
            } catch (\PDOException $e) {
                app()->load->language('db_lang');
                $this->return(static::HTTP_INTERNAL_SERVER_ERROR, [
                    'resultCode' => 'CREATE_DELEGATE_USER_ERROR',
                    'resultContent' => lang('db_transaction_failure')
                ]);
            }
        } else {
            //if the validator doesn't validate the form
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'CREATE_DELEGATE_USER_ERROR',
                'resultContent' => $validator->error_array(),
            ]);
        }
    }

    /**
     * @api {delete} /delegate_user/{id}  Deletes a delegate user
     * @apiName delegateUserDElete
     * @apiGroup delegateUser
     * @apiVersion 1
     *
     * @apiSuccess (204)    The user has been deleted
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   User not found.
     */
    public function delete_one($id)
    {
        if (!$user = UserModel::find($id)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'DELETE_DELEGATE_USER_NOT_FOUND',
            ]);
        }

        // loads the parent user
        if (!$parent = $this->authenticationService->user()) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'NOT_LOGGED'
            ]);
        }

        // delete role for current parent
        $user_role = UsersRoles::where('user_id', $user->id)
                               ->where('customer_id', $this->customer->id)
                               ->first();
	    if ($user_role) {
            Role::where('id', $user_role->role_id)
                ->where('slug', Role::SLUG_DELEGATE)
                ->delete();

            UsersRoles::whereNotIn('role_id', [Role::ID_DEV, Role::ID_ADMIN, Role::ID_MANAGER, Role::ID_CUSTOMER])
                        ->where('id', $user_role->id)
                        ->delete();
        }


        // delete parent relationship
        $delegate = UsersDelegates::where('user_id', $user->id)
                                ->where('parent_user_id', $parent->id)
                                ->first();
        UsersDelegates::find($delegate->id)->delete();

        // check other relationships
        $has_parents = UsersRoles::where('user_id', $user->id)->first();

        // delete if no parents
        if (!$has_parents) {
            $user->roles()->delete();
            $user->delete();
        }

        $this->return(static::HTTP_NO_CONTENT, [
            'resultCode' => 'DELETE_DELEGATE_USER_SUCCESS',
        ]);
    }



    /**
     * Validates the email
     *
     * @param string $email
     * @return boolean
     */
    public function isValidEmail($email)
    {
        $email = trim($email);

        if (empty($email)) {
            return false;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        // tests the email to see if it's already used
        $user_model = new UserModel();
        $email_exists = $user_model->where('email', $email)->get(['email']);

        if (!empty($email_exists)) {
            return false;
        }

        return true;
    }

    public function isValidEmailForUpdate($email) {
        $email = trim($email);

        if (empty($email)) {
            return false;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        return true;
    }

    public function get_validator($is_update = false) {
        $validator = new FormValidation();

        $email_validation = 'isValidEmail';
        if ($is_update) {
            $email_validation = 'isValidEmailForUpdate';
        }

        $validator->set_rules(
            'email',
            'email',
            [
                [
                    $email_validation,
                    [$this, $email_validation],
                ]
            ],
            [
                $email_validation => "L'email est invalide ou est déjà utilisé.",
            ]
        );

        $validator->set_rules(
            'first_name',
            'first_name',
            [
                'trim',
                'required',
            ],
            [
                'required' => 'Le champ prénom est requis.',
            ]
        );

        $validator->set_rules(
            'last_name',
            'last_name',
            [
                'trim',
                'required',
            ],
            [
                'required' => 'Le champ nom est requis.',
            ]
        );

        $validator->set_rules(
            'permissions[]',
            'permissions[]',
            [
                'required',
            ],
            [
                'required' => 'Le champ permissions est requis.',
            ]
        );

        return $validator;
    }

    /**
     * Get child user permissions for parent user
     *
     * @param string $user_id     The child id
     * @param string $customer_id The parent customer id
     *
     * @return array $permissions
     */
    private function getChildUserPermissions($user_id, $customer_id)
    {
        $child_role = UsersRoles::where('user_id', $user_id)
                              ->where('customer_id', $customer_id)
                              ->first();

        if (!$child_role) {
            return [];
        }

        $role_permissions = Role::where('id', $child_role->role_id)->first();
        $permissions = $role_permissions->permissions()->get(['permission_name']);
        foreach ($permissions as $k => $permission) {
            $slug = explode('.', $permission['permission_name']);
            $slug = lang(end($slug));
            $permissions[$k]['key'] = uniqid();
            $permissions[$k]['slug'] = $slug;
        }

        if (!is_array($permissions)) {
            return [];
        }

        return $permissions;
    }
}
