<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;
use \App\Model\UsersDelegates;
use \App\Job\MailerContent;
use \Globalis\PuppetSkilled\Library\FormValidation;

class Authentication extends \App\Core\Controller\Webservice
{
    protected $isPublic = true;

    /**
     * @api {post} /authentication/login Login
     * @apiName authLogin
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       username            Email address
     * @apiParam {string}       password            Password
     *
     * @apiSuccess (201)    {string}      resultCode         OK result code
     * @apiSuccess (201)    {array}       resultContent      Session ID and data
     *
     * @apiError (Error 4xx) {422}  error   Wrong login/password.
     */
    public function login()
    {
        $users = new \App\Model\User();
        $customers = new \App\Model\Customer();

        // Either try to find a corresponding customer or a corresponding user
        if ($customer = $customers->where('id', $this->input->post('username'))->isNotClosed()->first()) {
            $customer['company_name'] = $customer->company->name;
            $customer['family_name'] = $customer->family->name->value;
            $customer['support_name'] = $customer->support->name;
            $customer['unread_notification_count'] = count($customer->notifications()->where('read', '0')->get());
            $user = $users->where('username', $customer->email)->where('active', 1)->first();
        } else {
            $user = $users->where('username', $this->input->post('username'))->where('active', 1)->first();
        }

        // loads the setting
        $allowed_login_tries = (int) app()->settings->get('authentication.allowed_login_tries');

        // if account is blocked
        if ($user && (int) $user->login_tries >= $allowed_login_tries) {
            $this->return(static::HTTP_UNPROCESSABLE_ENTITY, [
                'resultCode' => 'ACCOUNT_BLOCKED'
            ]);
        }

        if (!$user || !$user->verifyPassword($this->input->post('password'))) {

            if ($user) {
                // increments the login_tries counter
                $user->login_tries = (int) $user->login_tries + 1;
                $user->save();

                // if account is blocked
                if ((int) $user->login_tries >= $allowed_login_tries) {
                    $this->return(static::HTTP_UNPROCESSABLE_ENTITY, [
                        'resultCode' => 'ACCOUNT_BLOCKED'
                    ]);
                }
            }

            $this->return(static::HTTP_UNPROCESSABLE_ENTITY, [
                'resultCode' => 'LOGIN_ERROR'
            ]);
        }


        // Load roles
        $this->authenticationService->loadProfil($user);
        // Histoire d'avoir une trace qui n'est pas aléatoire
        $realUser = $user->id;

        // Check if user has administrator role
        $is_admin = route_is_accessible('backoffice.user.connect_as');

        // If the user is admin, simply add a special token allowing him to borrow customers' account
        if ($is_admin) {
            $user->admin_token = bin2hex(random_bytes(20));
            $user->admin_token_datetime = date('Y-m-d H:i:s', time());
            // resets the login_tries counter
            $user->login_tries = null;
            $user->save();

            $this->return(static::HTTP_OK, [
                'resultCode' => 'OK',
                'resultContent' => [
                    'admin_token' => $user->admin_token,
                ]
            ]);
        } else {
            // Check if there is at least one customer linked to this user
            $customer_list = $user->customers()->isNotClosed()->get();
            if (count($customer_list) === 0) {
                $this->return(static::HTTP_UNPROCESSABLE_ENTITY, [
                    'resultCode' => 'LOGIN_ERROR'
                ]);
            }

            // Add company and support names for each customers
            $customers = [];
            foreach ($customer_list as $c) {
                $c['company_name'] = $c->company->name;
                $c['family_name'] = $c->family->name->value;
                $c['support_name'] = ($c->support ? $c->support->name : '');
                $c['unread_notification_count'] = count($c->notifications()->where('read', '0')->get());
                $customers[] = $c;
            }

            // Automatically load customer
            if (count($user->customers) === 1) {
                $this->authenticationService->loadCustomer($user, $user->customers[0]->id);
                $customer = $customers[0];
            } elseif ($customer) {
                $this->authenticationService->loadCustomer($user, $customer->id);
            }

            $permissions = [];

            // load permissions
            if ($customer && $customer->id) {
                $role_model = new \App\Model\Role();
                $role = $user->roles()->where('customer_id', $customer->id)->first();
                $role_permissions = $role_model->where('id', $role['id'])->first();
                $permissions = $role_permissions->permissions()->pluck('permission_name');
            }

            // check if user is delegate
            $has_parents = UsersDelegates::where('user_id', $user->id)->get();

            $session_data = [
                'authentication.user' => $user->id,
                'username' => $user->username,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'allow_email' => $user->allow_email,
                'allow_notification' => $user->allow_notification,
                'has_accepted_eula' => !!$user->has_accepted_eula,
                'must_change_password' => !!$user->must_change_password,
                'customers' => $customers,
                'customer' => $customer,
                'permissions' => $permissions,
                'parent_user' => $has_parents ? 'parent_user_id' : null,
                'real_user' => $realUser
            ];

            $this->session->set_userdata($session_data);
            log_message('debug', "Session session_write_close " . __FILE__);
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_write_close();
            }
            $session_id = session_id();
            $user->session_id = $session_id;
            // resets the login_tries counter
            $user->login_tries = null;
            $user->save();

            $this->return(static::HTTP_OK, [
                'resultCode' => 'OK',
                'resultContent' => [
                    'sessionId' => $session_id,
                    'userData' => $session_data,
                ]
            ]);
        }
    }

    /**
     * @api {post} /authentication/use  Choose customer
     * @apiName authUse
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       customer_id         Customer ID
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     * @apiError (Error 4xx) {404}  error   Endpoint not found.
     */
    public function use()
    {
        $this->secureAccess(true);
        if (!$user = $this->authenticationService->user()) {
            $this->return(static::HTTP_FORBIDDEN, [
                'resultCode' => 'NOT_LOGGED'
            ]);
        }

        $customer_id = $this->input->post('customer_id');
        $this->authenticationService->loadCustomer($user, $customer_id);
        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'userData' => $this->session->all_userdata(),
            ],
        ]);
    }

    /**
     * @api {post} /authentication/borrow_customer  Borrow customer
     * @apiName authBorrowCustomer
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       customer_id         Customer ID
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {404}  error   Customer not found.
     * @apiError (Error 4xx) {404}  error   User not found.
     * @apiError (Error 4xx) {422}  error   Unknown admin token.
     * @apiError (Error 4xx) {422}  error   Expired admin token.
     */
    public function borrow_customer()
    {
        $user_model = new \App\Model\User();
        $customer_model = new \App\Model\Customer();

        // Find the user corresponding to the admin token
        if (!$admin = $user_model->where('admin_token', $this->input->post('admin_token'))->first()) {
            $this->return(static::HTTP_UNPROCESSABLE_ENTITY, [
                'resultCode' => 'UNKNOWN_ADMIN_TOKEN'
            ]);
        }

        // Check if admin token is still valid
        $max_time = strtotime($admin->admin_token_datetime) + 3600;
        if ($max_time < time()) {
            $this->return(static::HTTP_UNPROCESSABLE_ENTITY, [
                'resultCode' => 'EXPIRED_ADMIN_TOKEN'
            ]);
        }

        // Find a corresponding active customer
        if (!$customer = $customer_model->where('id', $this->input->post('customer_id'))->isNotClosed()->first()) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'CUSTOMER_NOT_FOUND'
            ]);
        }

        // Check if found customer is linked to an active user
        if (!$user = $user_model->where('email', $customer->email)->where('active', '1')->first()) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'USER_NOT_FOUND'
            ]);
        }
        $realUser = $admin->id;

        // Add company and support names for each customers
        $customers = [];
        foreach ($user->customers()->isNotClosed()->get() as $c) {
            $c['company_name'] = $c->company->name;
            $c['family_name'] = $c->family->name->value;
            $c['support_name'] = null;
            if (isset($c->support, $c->support->name)) {
                $c['support_name'] = $c->support->name;
            }
            $c['unread_notification_count'] = count($c->notifications()->where('read', '0')->get());
            $customers[] = $c;

            if ($c->id === $customer->id) {
                $customer = $c;
            }
        }

        // Automatically load customer
        $this->authenticationService->loadCustomer($user, $customer->id);

        // load permissions
        $permissions = [];
        if ($customer->id) {
            $role_model = new \App\Model\Role();
            $role = $user->roles()->where('customer_id', $customer->id)->first();
            $role_permissions = $role_model->where('id', $role['id'])->first();

            if ($role_permissions && $role_permissions->permissions()) {
                $permissions = $role_permissions->permissions()->pluck('permission_name');
            }
        }

        $session_data = [
            'authentication.user' => $user->id,
            'username' => $user->username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'allow_email' => $user->allow_email,
            'allow_notification' => $user->allow_notification,
            'has_accepted_eula' => true, // force EULA acceptance when an admin borrows a customer account
            'must_change_password' => !!$user->must_change_password,
            'customers' => $customers,
            'customer' => $customer,
            'permissions' => $permissions,
            'real_user' => $realUser
        ];

        $this->session->set_userdata($session_data);
        log_message('debug', "Session session_write_close " . __FILE__);
        // $session_id = null;
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        $session_id = session_id();

        $user->session_id = $session_id;
        $user->save();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK',
            'resultContent' => [
                'sessionId' => $session_id,
                'userData' => $session_data,
            ]
        ]);
    }

    /**
     * @api {post} /authentication/reset_password  Reset user password and send him an email
     * @apiName authUse
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       username            Email address
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {404}  error   Unknown email.
     */
    public function reset_password()
    {
        $user_model = new \App\Model\User();

        if (!$user = $user_model->where('username', $this->input->post('username'))->first()) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'UNKNOWN_USER'
            ]);
        }

        if (!empty($user->customers) && (is_object($user->customers) && $user->customers->count() > 0)) {
            $sendMail = false;
            foreach ($user->customers as $customer) {
                if (!$customer->isClosed) {
                    $sendMail = true;
                }
            }
        } else {
            $sendMail = true;
        }

        if (!$sendMail || $user->active == 0) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'ACCOUNT_CLOSED'
            ]);
        }

        // Set a password reset token
        $password_reset_token = bin2hex(random_bytes(20));
        $user->password_reset_token = $password_reset_token;
        $user->password_reset_datetime = new Carbon();
        $user->save();

        // send mail new user
        $email = new MailerContent();

        $email->to($user->username)
        ->setContent(
            'email_reset_password',
            [
                'user_first_name' => ucfirst(strtolower($user->first_name)),
                'user_last_name' => ucfirst(strtolower($user->last_name)),
                'user_email' =>  $user->email,
                'customer_code' => '',
                'front_url' => config_item('front_base_url').'/new_password/'.$password_reset_token,
                'nb_notif' => ''
            ]
        );
        $email->handle();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK'
        ]);
    }

    /**
     * @api {post} /authentication/email_information  Fetchs email information for a given code
     * @apiName authEmailInformation
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       code            Code facture
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {404}  error   Bad request because code was empty.
     * @apiError (Error 4xx) {404}  error   Unknown code.
     */
    public function email_information()
    {
        $customer_model = new \App\Model\Customer();
        $user_model = new \App\Model\User();

        $code = $this->input->post('code');
        if (empty($code)) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'EMPTY_CODE'
            ]);
        }

        $customer = $customer_model->where('id', $code)->first();

        if (is_null($customer)) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'UNKNOWN_CUSTOMER',
            ]);
        }

        $email = $customer->email;
        list($name, $domain) = explode('@', $email);
        $domain_parts = explode('.', $domain);
        $tld = array_pop($domain_parts);
        $domain = implode('.', $domain_parts);

        // Spoof the first part
        $name_len = mb_strlen($name);
        $nb = 1;
        if ($name_len >= 8) {
            $nb = 2;
        }
        $hidden_name = mb_substr($name, 0, $nb) . str_repeat('*', $name_len - $nb * 2) . mb_substr($name, -$nb);

        // Spoof the second
        $domain_len = mb_strlen($domain);
        $nb = 1;
        if ($domain_len >= 8) {
            $nb = 2;
        }
        $hidden_domain = mb_substr($domain, 0, $nb) . str_repeat('*', $domain_len - $nb * 2) . mb_substr($domain, -$nb);

        $this->return(static::HTTP_OK, [
            'resultCode' => 'EMAIL_INFORMATION_SUCCESS',
            'email' => $hidden_name . '@' . $hidden_domain . '.' . $tld,
        ]);
    }

    /**
     * @api {post} /authentication/check_reset_token  Check if a reset password token is (still) valid
     * @apiName authUse
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       password_reset_token            Password reset token
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {404}  error   Unknown password reset token.
     * @apiError (Error 4xx) {422}  error   Expired password reset token.
     */
    public function check_reset_token()
    {
        $user_model = new \App\Model\User();

        // Check if required parameters has been sent
        if (!$this->input->post('password_reset_token')) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'BAD_REQUEST'
            ]);
        }

        // Find the user corresponding to the password reset token
        if (!$user = $user_model->where('password_reset_token', $this->input->post('password_reset_token'))->first()) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'UNKNOWN_RESET_TOKEN'
            ]);
        }

        // Check if password reset token is still valid
        $max_time = strtotime($user->password_reset_datetime) +  app()->settings->get('authentication.expires_reset_password');
        if ($max_time < time()) {
            $this->return(static::HTTP_UNPROCESSABLE_ENTITY, [
                'resultCode' => 'EXPIRED_RESET_TOKEN'
            ]);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK'
        ]);
    }

    /**
     * @api {post} /authentication/set_new_password  Set new password to a user
     * @apiName authUse
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       username                Email address
     * @apiParam {string}       password_reset_token    Password reset token
     * @apiParam {string}       password                New password
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {404}  error   Unknown user/token association.
     */
    public function set_new_password()
    {
        $user_model = new \App\Model\User();

        if (!$this->input->post('username') || !$this->input->post('password_reset_token') || !$this->input->post('password')) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'BAD_REQUEST'
            ]);
        }
        // if the password is invalid
        if ($this->is_valid_password($this->input->post('password')) === false) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'BAD_PASSWORD'
            ]);
        }

        $user = $user_model->where([
            'username' => $this->input->post('username'),
            'password_reset_token' => $this->input->post('password_reset_token')
        ])->first();

        if (!$user) {
            $this->return(static::HTTP_NOT_FOUND, [
                'resultCode' => 'UNKNOWN_USER'
            ]);
        }

        $user->password = $this->input->post('password');
        $user->password_reset_token = null;
        $user->password_reset_datetime = null;
        $user->must_change_password = 0;
        $user->login_tries = null;
        $user->save();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK'
        ]);
    }

    /**
     * @api {post} /authentication/update_profile  Update user profile
     * @apiName authUse
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {string}       password                New password
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     */
    public function update_profile()
    {
        $required_fields = ['password'];

        foreach ($required_fields as $field) {
            if (!$this->input->post($field) || $this->input->post($field) === '') {
                $this->return(static::HTTP_BAD_REQUEST, [
                    'resultCode' => 'BAD_REQUEST'
                ]);
            }
            // if we're currently testing the password field
            if ($field === 'password') {
                // if the password is invalid
                if ($this->is_valid_password($this->input->post($field)) === false) {
                    $this->return(static::HTTP_BAD_REQUEST, [
                        'resultCode' => 'BAD_PASSWORD'
                    ]);
                }
            }
        }

        if (!$user = $this->authenticationService->user()) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'NOT_LOGGED'
            ]);
        }

        $user->password = $this->input->post('password');
        $user->must_change_password = 0;
        $user->save();

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK'
        ]);
    }

    /**
     * @api {post} /authentication/update_parameters  Update user profile
     * @apiName authUse
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {boolean}       allow_email                New password
     * @apiParam {boolean}       allow_notification                New password
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {400}  error   Bad request.
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     */
    public function update_parameters()
    {
        if (!$user = $this->authenticationService->user()) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'NOT_LOGGED'
            ]);
        }
        // set the validator
        $validator = $this->get_validator();

        // if validator validates the form
        if ($validator->run()) {
            $user->allow_notification = $validator->set_value('allow_notification');
            $user->allow_email = $validator->set_value('allow_email');

            if (!empty($this->input->post('password'))) {
                $user->password = $this->input->post('password');
                $user->must_change_password = 0;
            }

            $user->save();
            $this->return(static::HTTP_OK, [
                'resultCode' => 'OK',
                'resultContent' => [
                    'userData' => $user,
                ]
            ]);
        }

        $this->return(static::HTTP_BAD_REQUEST, [
            'resultCode' => 'BAD_REQUEST'
        ]);

    }


    public function get_validator() {
        $validator = new FormValidation();

        $validator->set_rules(
            'allow_email',
            'allow_email',
            [
                'trim',
                'required',
                'in_list[0,1]'
            ],
            [
                'required' => 'Le champ nom est requis.',
            ]
        );

        $validator->set_rules(
            'allow_notification',
            'allow_notification',
            [
                'trim',
                'required',
                'in_list[0,1]'
            ],
            [
                'required' => 'Le champ nom est requis.',
            ]
        );

        $validator->set_rules(
            'password',
            'password',
            [
                'trim',
                [
                    'authentication_error_password_bad_format',
                    function ($value) {
                        if (!empty($value)) {
                            return $this->is_valid_password($value);
                        }
                        return true;
                    }
                ],
            ]
        );

        $validator->set_rules(
            'passwordConfirm',
            'passwordConfirm',
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

    /**
     * @api {post} /authentication/change_eula_acceptance  Change end-user licence agreeement acceptance
     * @apiName authUse
     * @apiGroup Auth
     * @apiVersion 1
     *
     * @apiParam {boolean}       has_accepted            Has the user accepted EULA
     *
     * @apiSuccess (200)    {string}      resultCode         OK result code
     *
     * @apiError (Error 4xx) {403}  error   Please sign in first.
     */
    public function change_eula_acceptance()
    {
        if (is_null($this->input->post('has_accepted'))) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'BAD_REQUEST'
            ]);
        }

        if (!$user = $this->authenticationService->user()) {
            $this->return(static::HTTP_BAD_REQUEST, [
                'resultCode' => 'NOT_LOGGED'
            ]);
        }

        $user->has_accepted_eula = !!$this->input->post('has_accepted');
        $user->save();

        $export_customer_data = [
            'email' => $user->email,
            'has_accepted_eula' =>($user->has_accepted_eula ? 1 : 0)
        ];

        foreach ($user->customers as $customer) {
            $this->exportCustomer->export($customer->id, $export_customer_data);
        }

        $this->return(static::HTTP_OK, [
            'resultCode' => 'OK'
        ]);
    }

    /**
     * Validates the password format
     *
     * @param string $password
     * @return boolean
     */
    private function is_valid_password($password)
    {
        $rules = [
            '/^\S{8,}$/',
            '/[a-z]+/',
            '/[A-Z]+/',
            '/\d+/',
        ];

        foreach ($rules as $rule) {
            if ((boolean)preg_match($rule, $password) === false) {
                return false;
            }
        }

        return true;
    }
}
