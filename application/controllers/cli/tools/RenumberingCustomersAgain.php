<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Globalis\PuppetSkilled\Core\Application;
use \App\Model\Role;
use \App\Model\User;
use \App\Model\Customer;
use \App\Model\UsersRoles;
use \App\Model\Family;
use \App\Job\MailerContent;

class RenumberingCustomersAgain extends \Globalis\PuppetSkilled\Controller\Cli
{
    protected $customerNotFound = [];
    protected $oldIds = [];
    protected $customerWithoutUser = [];
    protected $state = [
        'rows' => 0,
        'rowsTreated' => 0,
        'customerWithoutUser' => 0,
        'customerNotFound' => 0,
        'newUser' => 0,
        'newCustomer' => 0,
        'newRole' => 0,
        'updatedCustomer' => 0,
    ];

    public function index($filename = '2021.12.16.extranet_renumerotation_client.csv')
    {
        log_message('info', 'Lancement du script : ' . __CLASS__);
        $this->filename = config_item('data_document_path') . '/renumbering_customers/' . $filename;
        if (!is_file($this->filename)) {
            log_message('error', 'Fichier non trouvé : ' . $this->filename);
            return false;
        }

        if (!$handle = fopen($this->filename, 'r')) {
            log_message('error', 'Erreur d\'ourverture : ' . $this->filename);
            return false;
        }

        app()->load->helper('date_helper');

        while ($line = fgetcsv($handle, 0, ';')) {
            list($ctl, $id, $titre, $famille, $creation, $fermeture,) = $line;

            $this->state['rows'] ++;
            // On ne reprends ni les non repris ni les numéros non préfixés
            if ($ctl === 'CTL' || $ctl === 'Non Repris' || substr($id, 0, 2) !== 'PY') {
                continue;
            }

            $this->state['rowsTreated'] ++;
            /* CTL
            Vide => écraser les valeurs en BDD
            New => création des données en BDD
            New ID correspond aux anciens et nouveaux numéros
            */


            if (empty($ctl)) {
                $this->oldIds[] = substr($id, 0, 2);
                $this->updateCustomer($line);
            }

            if ($ctl === 'New') {
                $this->createCustomer($line);
            }

        }
        // [rows] => 3227           -> ok
        // [rowsTreated] => 2454    -> ok
        // [customerWithoutUser] => 2
        // [customerNotFound] => 61
        // [newUser] => 2           -> ok
        // [newCustomer] => 12
        // [newRole] => 10
        // [updatedCustomer] => 2381

        // 2393 customers traité avec réussite
        // 773 non traité -> 328 non repris -> 445

        // INFO - 2022-01-11 13:47:14 --> Impossible de trouver ou de créer l'utilisateur avec les données : {"ctl":"New","id":"PY23585","title":"MME TRUPIN NOELLA","family_id":"ca016af5-6967-4310-b9a3-a520f950b5f8","created_at":null,"closed":{"date":"2019-09-23 13:47:14.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"civility":"Mme","last_name":null,"first_name":null,"email":null,"sign":"L INSTITUT DE BEAUTE NOELLA","address":"39 RUE ROGER SALENGRO","address2":null,"zip":"62720","city":"RINXENT","phone":"0","active":1,"old_renum":"23585"}
        // INFO - 2022-01-11 13:47:14 --> Impossible de trouver ou de créer l'utilisateur avec les données : {"ctl":"New","id":"PY22766","title":"MME ALBERTINI NICOLE","family_id":"ca016af5-6967-4310-b9a3-a520f950b5f8","created_at":null,"closed":{"date":"2019-02-01 13:47:14.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"civility":"Mme","last_name":null,"first_name":null,"email":null,"sign":"LA MAISON DE BEAUTE","address":"ROUTE DU BORD DE MER BATIMENT A","address2":"RESIDENCE SANTA MARIA DI LOTA","zip":"20200","city":"SANTA MARIA DI LOTA","phone":"0","active":1,"old_renum":"22766"}
        // INFO - 2022-01-11 13:47:14 --> Customers non trouvés, impossible de les mettre à jour : ["25227","22970","25341","25277","25360","25303","25369","25190","20842","25298","25301","20783","25368","25283","25366","25348","25233","25320","25244","25306","25263","25310","25236","21027","25296","25208","25357","25242","25322","25268","25295","25264","25367","25323","25252","25167","25343","25361","25315","25311","25192","25313","25337","25332","25334","25287","25317","25229","25185","25354","25350","25114","25299","25363","25364","25243","25170","22511","25262","25344","25316"]
        // INFO - 2022-01-11 13:47:14 --> Customers sans utilisateurs, impossible de trouver ou créer un utilisateur : [{"ctl":"New","id":"PY23585","title":"MME TRUPIN NOELLA","family_id":"ca016af5-6967-4310-b9a3-a520f950b5f8","created_at":null,"closed":{"date":"2019-09-23 13:47:14.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"civility":"Mme","last_name":null,"first_name":null,"email":null,"sign":"L INSTITUT DE BEAUTE NOELLA","address":"39 RUE ROGER SALENGRO","address2":null,"zip":"62720","city":"RINXENT","phone":"0","active":1,"old_renum":"23585"},{"ctl":"New","id":"PY22766","title":"MME ALBERTINI NICOLE","family_id":"ca016af5-6967-4310-b9a3-a520f950b5f8","created_at":null,"closed":{"date":"2019-02-01 13:47:14.000000","timezone_type":3,"timezone":"Europe\/Berlin"},"civility":"Mme","last_name":null,"first_name":null,"email":null,"sign":"LA MAISON DE BEAUTE","address":"ROUTE DU BORD DE MER BATIMENT A","address2":"RESIDENCE SANTA MARIA DI LOTA","zip":"20200","city":"SANTA MARIA DI LOTA","phone":"0","active":1,"old_renum":"22766"}]


        echo 'customer non trouvés :';
        print_r($this->customerNotFound);
        print_r($this->state);

        log_message('info', 'Customers non trouvés, impossible de les mettre à jour : ' . json_encode($this->customerNotFound));
        log_message('info', 'Customers sans utilisateurs, impossible de trouver ou créer un utilisateur : ' . json_encode($this->customerWithoutUser));
        log_message('info', 'Fin du script : ' . __CLASS__);
    }

    public function updateCustomer($line)
    {
        $data = $this->getData($line);

        if (!($customer = Customer::find($data['old_renum']))) {
            $this->customerNotFound[] = $data['old_renum'];
            $this->state['customerNotFound'] ++;
            return false;
        }
        $customer->id = $data['id'];
        $customer->family_id = $data['family_id'];
        $customer->title = $data['title'];
        $customer->closed = $data['closed'];
        if (!is_null($data['created_at'])) {
            $customer->created_at = $data['created_at'];
        }
        $customer->last_name = $data['last_name'];
        $customer->first_name = $data['first_name'];
        $customer->email = $data['email'];
        $customer->sign = $data['sign'];
        $customer->address = $data['address'];
        $customer->address2 = $data['address2'];
        $customer->zip = $data['zip'];
        $customer->city = $data['city'];
        $customer->phone = $data['phone'];
        $customer->active = $data['active'];
        $customer->save();

        $this->state['updatedCustomer'] ++;
        UsersRoles::where('customer_id', $data['old_renum'])->update(['customer_id' => $data['id']]);
    }

    /**
     * Nettoie et formate une ligne CSV en un tableau de données
     *
     * @param     array    $columns    [$columns description]
     *
     * @return    array                [return description]
     */
    protected function getData(array $columns): array
    {
        foreach ($columns as $i => $val) {
            if (empty($val) || $val === '-') {
                $columns[$i] = null;
                continue;
            }
            $columns[$i] = trim($val);
        }

        $family = Family::where('slug', $columns[3])->first();
        $familyId = null;
        if ($family) {
            $familyId = $family->id;
        }

        return [
            'ctl' => $columns[0],
            'id' => $columns[1],
            'title' => $columns[2],
            'family_id' => $familyId,
            'created_at' => (is_null($columns[4]) ? null : \Carbon\Carbon::createFromFormat('d/m/Y', $columns[4])),
            'closed' => (is_null($columns[5]) ? null : \Carbon\Carbon::createFromFormat('d/m/Y', $columns[5])),
            'civility' => $columns[6],
            'last_name' => $columns[7],
            'first_name' => $columns[8],
            'email' => $columns[9],
            'sign' => $columns[10],
            'address' => $columns[11],
            'address2' => $columns[12],
            'zip' => $columns[13],
            'city' => $columns[14],
            'phone' => (substr($columns[15], 0, 1) === '0' ? $columns[15] : '0' . $columns[15]),
            'active' => (int) $columns[16],
            'old_renum' => ltrim($columns[1], 'PY'),
        ];
    }


    public function createCustomer($line)
    {
        $data = $this->getData($line);

        $customer = new Customer();
        $customer->id = $data['id'];
        $customer->family_id = $data['family_id'];
        $customer->title = $data['title'];
        $customer->closed = $data['closed'];
        $customer->created_at = \Carbon\Carbon::now();
        $customer->last_name = $data['last_name'];
        $customer->first_name = $data['first_name'];
        $customer->email = $data['email'];
        $customer->sign = $data['sign'];
        $customer->address = $data['address'];
        $customer->address2 = $data['address2'];
        $customer->zip = $data['zip'];
        $customer->city = $data['city'];
        $customer->phone = $data['phone'];
        $customer->active = $data['active'];
        $customer->save();

        $this->state['newCustomer'] ++;
        $user = $this->getCustomerUser($data);

        if ($user) {
            $role = UsersRoles::where('user_id', $user->id)
                ->where('customer_id', $customer->id)->count();
            if (!$role) {
                $role = new UsersRoles();
                $role->user_id = $user->id;
                $role->customer_id = $customer->id;
                $role->role_id = Role::ID_CUSTOMER;
                $role->save();

                $this->state['newRole'] ++;
            }
        }
    }

    /**
     * recherche l'utilisateur associé à un customer pour une création avec une tentative de création si besoin
     *
     * @param     array     $data    [$data description]
     *
     * @return    User|null               [return description]
     */
    public function getCustomerUser(array $data)
    {
        if ($user = User::where('email', $data['email'])->first()) {
            return $user;
        }

        $user = User::whereHas('customers', function ($query) use ($data) {
             $query->where('customers.title', $data['title']);
            return $query->orWhere('customers.sign', $data['sign']);
        })->first();

        if ($user) {
            return $user;
        }

        if (!empty($data['email'])) {
            return $this->createUser($data);
        }

        $this->customerWithoutUser[] = $data;
        $this->state['customerWithoutUser'] ++;
        log_message('info', 'Impossible de trouver ou de créer l\'utilisateur avec les données : ' . json_encode($data));
        return null;
    }

    /**
     *  Création de l'utilisateur ayant une adresse mail
     *
     * @param     array    $data    [$data description]
     *
     * @return    User              [return description]
     */
    protected function createUser(array $data): User
    {
        $password_reset_token = bin2hex(random_bytes(20));

        $user = new User();
        $user->username = $data['email'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->allow_email = 1;
        $user->allow_notification = 1;
        $user->timezone = date_default_timezone_get();
        $user->date_format = 'DD MMMM YYYY';
        $user->datetime_format = 'DD MMMM YYYY, HH:mm';
        $user->language = 'fr';
        $user->active = $data['active'];
        $user->visible = 0;
        $user->password_reset_token = $password_reset_token;
        $user->password_reset_datetime = new Carbon\Carbon();
        $user->save();

        $email = new MailerContent();
        $email->to($user->username)
            ->setContent(
                'email_new_user',
                [
                    'user_first_name' => ucfirst(strtolower($user->first_name)),
                    'user_last_name' => ucfirst(strtolower($user->last_name)),
                    'user_email' =>  $user->email,
                    'customer_code' => $data['id'],
                    'front_url' => config_item('front_base_url').'/new_password/' . $user->password_reset_token,
                    'nb_notif' => ''
                ]
            );
        $email->handle();

        $this->state['newUser'] ++;
        return $user;
    }

    public function initQb()
    {
        return Application::getInstance()->get('queryBuilder');
    }
}
