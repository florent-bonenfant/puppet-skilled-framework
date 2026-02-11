<?php
namespace App\Job;

use Carbon\Carbon;
use \App\Job\MailerContent;
use \App\Model\Company as CompanyModel;
use \App\Model\Customer as CustomerModel;
use \App\Model\Family as FamilyModel;
use \App\Model\Role as RoleModel;
use \App\Model\User as UserModel;
use \App\Model\UsersDelegates as UsersDelegatesModel;
use \App\Model\UsersRoles as UsersRolesModel;

class ImportCustomers extends \App\Job\Import
{
    protected $source_file_pattern = '/\/client_([0-9]{8})\.txt$/';
    protected $model = '\App\Model\Customer';

    protected $map = [
        'id' => 'code_client',
        'family_id' => 'famille',
        'company_id' => 'societe',
        'support_id' => 'representant',
        'email' => 'mail',
        'type' => 'typeclient',
        'title' => 'raison_sociale',
        'sign' => 'enseigne',
        'address' => 'adresse_1',
        'address2' => 'adresse_2',
        'zip' => 'cp',
        'city' => 'ville',
        'phone' => 'telephone',
        'first_name' => 'prenom',
        'last_name' => 'nom',
        'restrict_access_date' => 'date_fermeture_commerciale',
        'closing_date' => 'date_fermeture_totale',
    ];

    protected $families = [];
    protected $companies = [];
    protected $users = [];
    protected $keepUsers = [];

    public function __construct()
    {
        $companiesKeys = [
            'Guinot'    => 'RG',
            'Mary Cohr' => 'MC',
        ];
        foreach (CompanyModel::all() as $item) {
            $key = $companiesKeys[$item->name];
            $this->companies[$key] = $item->id;
        }

        $this->getDelegateUsers();
    }

    protected function getDelegateUsers()
    {
        if (!empty($this->keepUsers)) {
            return $this->keepUsers;
        }

        foreach (UsersDelegatesModel::all() as $item) {
            if (!in_array($item->user_id, $this->keepUsers)) {
                $this->keepUsers[] = $item->user_id;
            }
        }
        return $this->keepUsers;
    }

    protected function removeUser($username, $customerId)
    {
        $users = UsersRolesModel::where('role_id', RoleModel::ID_CUSTOMER)->where('customer_id', $customerId)->get();
        $user = UserModel::where('username', $username)->first();

        foreach ($users as $currentUser) {
            if (in_array($currentUser->user_id, $this->keepUsers) || ($user && $user->id === $currentUser->user_id)) {
                continue;
            }

            // Re création des délégations si nécessaire
            $queryDelegation = UsersDelegatesModel::where('parent_user_id', $currentUser->user_id)->where('customer_id', $customerId);
            $oldDelegations = $queryDelegation->get();
            $queryDelegation->delete();

            if ($user && !empty($oldDelegations)) {
                array_map(function($delegation) use ($user) {
                    $checkDelegation = UsersDelegatesModel::where('user_id', $delegation->user_id)
                        ->where('customer_id', $delegation->customer_id)
                        ->where('parent_user_id', $user->id)
                        ->first();
                    if ($checkDelegation) {
                        return true;
                    }

                    $createDelegation = new UsersDelegatesModel();
                    $createDelegation->user_id = $delegation->user_id;
                    $createDelegation->parent_user_id = $user->id;
                    $createDelegation->customer_id = $delegation->customer_id;
                    $createDelegation->save();

                }, $oldDelegations);
            }

            UserModel::where('id', $currentUser->id)->update([
                'active' => 0,
                'deleted_at' => \Carbon\Carbon::now(),
            ]);
            UsersRolesModel::where('user_id', $currentUser->id)->delete();
        }
    }

    protected function before_set_data()
    {
        // deactivate all users, and reactivate if present in import file
        foreach (CustomerModel::all() as $item) {
            $item->active = 0;
            $item->save();
        }
    }

    protected function buildRow($row)
    {
        $family = FamilyModel::where('slug', $row['famille'])->first();
        $row['famille'] = $family->id ?? null;
        $row['societe'] = $this->companies[$row['societe']];
        $row['date_fermeture_commerciale'] = ($row['date_fermeture_commerciale'] ? new Carbon($row['date_fermeture_commerciale']) : null);
        $row['date_fermeture_totale'] = ($row['date_fermeture_totale'] ? new Carbon($row['date_fermeture_totale']) : null);

        return $row;
    }

    protected function callback($item, $isUpdate = false, $row = [])
    {
        // look for existing user
        $user = false;
        if ($item->email) {
            $user = UserModel::where('username', $item->email)->first();
            if (empty($item->closing_date) || \Carbon\Carbon::now()->lt($item->closing_date)) {
                $item->active = 1;
                $item->save();
            }
        } else {
            return false;
        }

        if ($user) {
            // update user infos
            $user->first_name = $item->first_name;
            $user->last_name = $item->last_name;
            $user->deleted_at = null;
            $user->save();
        } else {
            // create new user
            app()->load->helper('date_helper');
            $user = new UserModel();
            $user->username = $item->email;
            $user->email = $item->email;
            $user->first_name = $item->first_name;
            $user->last_name = $item->last_name;
            $user->timezone = date_default_timezone_get();
            $user->date_format = 'DD MMMM YYYY';
            $user->datetime_format = 'DD MMMM YYYY, HH:mm';
            $user->language = 'fr';
            $user->visible = 0;
            $user->allow_email = 1;
            $user->allow_notification = 1;
            $user->password_reset_token = bin2hex(random_bytes(20));
            $user->password_reset_datetime = Carbon::now();
            $user->save();

            // send mail new user
            if (
                (empty($item->closing_date) || \Carbon\Carbon::now()->lt($item->closing_date)) &&
                (empty($item->restrict_access_date) || \Carbon\Carbon::now()->lt($item->restrict_access_date))
            ) {
                $email = new MailerContent();
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
                $email->handle();
            }
        }

        // Search and destroy old user
        $this->removeUser($item->email, $item->id);

        // save user role
        if ($user && !UsersRolesModel::where('user_id', $user->id)->where('customer_id', $item->id)->first()) {
            $role = new UsersRolesModel();
            $role->user_id = $user->id;
            $role->customer_id = $item->id;
            $role->role_id = RoleModel::ID_CUSTOMER;
            $role->save();
        }

        // output
        $element = $item->id;
        if ($isUpdate) {
            $this->message_log('INFO', $element . ' updated');
        } else {
            $this->message_log('INFO', $element . ' added');
        }
    }
}
