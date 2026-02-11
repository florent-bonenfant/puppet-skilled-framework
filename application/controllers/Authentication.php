<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\FormValidation;
use \App\Model\User as UserModel;
use \App\Job\MailerContent;

class Authentication extends \App\Core\Controller\Base
{
    protected $layout = 'empty';

    protected $isPublic = true;

    public function login()
    {
        if ($this->authenticationService->isLoggedIn()) {
            redirect('frontoffice/home');
        }

        $validator = $this->authenticationService->login();
        if ($validator->isValid()) {
            redirect('frontoffice/home');
        }
        $this->render(['validator' => $validator]);
    }

    public function logout()
    {
        $this->authenticationService->logout();
        redirect('authentication/login');
    }

    public function forgot_password()
    {
        if ($this->authenticationService->isLoggedIn()) {
            redirect('frontoffice/home');
        }

        $validator = new FormValidation();
        $validator->set_rules(
            'username',
            'lang:authentication_label_username',
            [
                'trim',
                [
                    'authentication_error_invalid_reset_account',
                    function ($value) use ($validator) {
                        if ($value !== '') {
                            if ($user = UserModel::where('username', $value)->where('active', '1')->first()) {
                                $validator->validation_data['userEntity'] = $user;
                                foreach ($user->customers as $customer) {
                                    if (!$customer->isClosed) {
                                        return true;
                                    }
                                }
                                return false;
                            }
                            return false;
                        }
                    }
                ],
                'required',
            ]
        );

        if ($validator->run() === true) {
            $this->sendResetEmail($validator->validation_data['userEntity']);
            $this->flashMessage('lang:authentication_message_token_created', 'lang:general_message_title-success', 'success');
            redirect('authentication/login');
        }
        $this->render(['validator' => $validator]);
    }

    public function blocked_password()
    {
        if ($this->authenticationService->isLoggedIn()) {
            redirect('frontoffice/home');
        }

        $validator = new FormValidation();
        $validator->set_rules(
            'username',
            'lang:authentication_label_username',
            [
                'trim',
                [
                    'authentication_error_invalid_reset_account',
                    function ($value) use ($validator) {
                        if ($value !== '') {
                            if ($user = UserModel::where('username', $value)->where('active', '1')->first()) {
                                $validator->validation_data['userEntity'] = $user;
                                foreach ($user->customers as $customer) {
                                    if (!$customer->isClosed) {
                                        return true;
                                    }
                                }
                                return false;
                            }
                            return false;
                        }
                    }
                ],
                'required',
            ]
        );

        if ($validator->run() === true) {
            $this->sendResetEmail($validator->validation_data['userEntity']);
            $this->flashMessage('lang:authentication_message_token_created', 'lang:general_message_title-success', 'success');
            redirect('authentication/login');
        }
        $this->render(['validator' => $validator]);
    }

    public function reset($token = null)
    {
        $validator = $this->setPassword($token);
        if ($validator->isValid()) {
            $this->flashMessage('lang:authentication_message_password_reset', 'lang:general_message_title-success', 'success');
            redirect('authentication/login');
        }
        $this->render(['validator' => $validator]);
    }

    public function setup($token = null)
    {
        $validator = $this->setPassword($token);
        if ($validator->isValid()) {
            $this->flashMessage('lang:authentication_message_password_setup', 'lang:general_message_title-success', 'success');
            redirect('authentication/login');
        }
        $this->render(['validator' => $validator]);
    }

    private function setPassword($token)
    {
        if ($this->authenticationService->isLoggedIn()) {
            redirect('frontoffice/home');
        }

        if (!($token = $this->authenticationService->retrieveResetToken($token))) {
            redirect('authentication/login');
        }

        $user = UserModel::find($token->user_id);

        $validator = new FormValidation();
        $validator->set_rules(
            'username',
            'lang:authentication_label_username',
            [
                'trim',
                'required',
                [
                    'authentication_error_invalid_reset_account',
                    function ($value) use ($user) {
                        return $user->username === $value;
                    }
                ],
            ]
        );
        $validator->set_rules(
            'password',
            'lang:authentication_label_password',
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
                'required',
            ]
        );
        $validator->set_rules(
            'password_confirm',
            'lang:authentication_label_password',
            [
                'trim',
                'matches[password]',
            ]
        );
        if ($validator->run() === true) {
            // Change password
            $user->password = $validator->set_value('password');
            $user->login_tries = null;
            $user->save();
            // Delete Token
            $this->authenticationService->deleteToken($token->token);
        }
        return $validator;
    }

    protected function sendResetEmail($user)
    {
        // Configure mail
        $token  = $this->authenticationService->registerToken($user);
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
                'front_url' => site_url('authentication/reset/' . $token),
                'nb_notif' => ''
            ]
        );
        $email->handle();
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
