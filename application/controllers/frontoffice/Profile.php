<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Library\FormValidation;
use App\Model\User;
use App\Service\Language\Language;
use \App\Model\Module as ModuleModel;

class Profile extends \App\Core\Controller\FrontOffice
{
    protected $autoload = [
        'helper' => [
            'form',
            'date'
        ],
    ];

    public function index()
    {
        $item = $this->authenticationService->user();
        $role_slugs = config_item('site_settings')['role_slugs'];

        // Acquire Lock
        if (!$item->acquireLock()) {
            $this->flashMessage('lang:general_message_already-lock', 'lang:general_message_title-error', 'error');
            redirect_referrer('frontoffice/profile');
        }

        $validator = $this->getValidator($item);
        if (!$validator->run()) {
            $service = new Language();
            $languages = $service->getLanguagesList();
            $this->render([
                'validator' => $validator,
                'item' => $item,
                'languages' => $languages,
                'modules' => ModuleModel::with('content.translations')->get(),
                'role_slugs' => $role_slugs
            ]);
        } else {
            $item->email = $validator->set_value('email');
            $item->language = $validator->set_value('language');
            $item->timezone = $validator->set_value('timezone');
            $item->date_format = 'DD MMMM YYYY';
            $item->datetime_format = 'DD MMMM YYYY, HH:mm';
            if (!empty($validator->set_value('datetime_format'))) {
                $item->datetime_format = $validator->set_value('datetime_format');
            }
            if (!empty($validator->set_value('date_format'))) {
                $item->date_format = $validator->set_value('date_format');
            }
            if (!empty($validator->set_value('password'))) {
                $item->password = $validator->set_value('password');
            }
            $item->update();
            $item->releaseLock();
            // Update language
            $service = new Language();
            $service->change($item->language);
            $this->flashMessage('lang:general_message_edit-success', 'lang:general_message_title-success', 'success');
            redirect('frontoffice/profile');
        }
    }

    protected function getValidator(User $user)
    {
        $validator = new FormValidation();
        $validator->set_rules(
            'email',
            'lang:profile_label_email',
            [
                'trim',
                'valid_email',
                [
                    'profile_error_not_unique_email',
                    function ($value) use ($user) {
                        if (empty($value)) {
                            return true;
                        }
                        $user = User::where('username', $value)->where('id', '!=', $user->id)->count();
                        if ($user !== 0) {
                            return false;
                        }
                        return true;
                    }
                ],
                'required'
            ]
        );
        $validator->set_rules(
            'password',
            'lang:profile_label_password',
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
                ]
            ]
        );
        $validator->set_rules(
            'password_confirm',
            'lang:profile_label_password_confirm',
            [
                'trim',
                'matches[password]',
            ]
        );
        return $validator;
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
