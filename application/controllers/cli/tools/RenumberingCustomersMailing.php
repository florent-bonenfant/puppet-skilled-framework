<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Job\MailerContent;

class RenumberingCustomersMailing extends \Globalis\PuppetSkilled\Controller\Cli
{
    protected $filename;

    public function index($filename = 'renumerotation_final_extranet.csv')
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

        if (ENVIRONMENT !== 'production') {
            $email = new MailerContent();
            $email->to('florent.bonenfant+guinot_extra@globalis-ms.com')
                ->setContent(
                    'email_change_password_after_renumbering',
                    [
                        'user_first_name' => ucfirst(strtolower('prenom')),
                        'user_last_name' => ucfirst(strtolower('nom')),
                        'user_email' => 'florent.bonenfant@globalis-ms.com',
                        'customer_code' => 'un id',
                        'front_url' => config_item('front_base_url') . '/new_password/link',
                        'nb_notif' => '',
                    ]
                );
            $email->handle();
        } else {
            while ($line = fgetcsv($handle, 0, ';')) {
                list($old, $new) = $line;

                if ($old === 'ANCIEN_CODE') {
                    continue;
                }
                $this->sendMail($new);
            }
        }

        log_message('info', 'Fin du script : ' . __CLASS__);
    }

    protected function sendMail($customerId)
    {
        $customer = \App\Model\Customer::find($customerId);
        foreach ($customer->users as $user) {
            // Set a password reset token
            $password_reset_token = bin2hex(random_bytes(20));
            $user->password_reset_token = $password_reset_token;
            $user->password_reset_datetime = new Carbon\Carbon();
            $user->save();

            // send mail new user
            $email = new MailerContent();

            $email->to($user->username)
                ->setContent(
                    'email_change_password_after_renumbering',
                    [
                        'user_first_name' => ucfirst(strtolower($user->first_name)),
                        'user_last_name' => ucfirst(strtolower($user->last_name)),
                        'user_email' => $user->email,
                        'customer_code' => $customerId,
                        'front_url' => config_item('front_base_url') . '/new_password/' . $password_reset_token,
                        'nb_notif' => '',
                    ]
                );
            $email->handle();
        }
    }
}
