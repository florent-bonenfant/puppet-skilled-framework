<?php
namespace App\Job;

use App\Model\Customer;

class AlertClosingAccounts extends \Globalis\PuppetSkilled\Queue\Queueable
{
    protected $customers = [];

    public function handle()
    {
        $this->checkAccounts();
        $this->sendMail();
    }

    public function checkAccounts()
    {
        app()->load->helper('date_helper');
        $this->customers = Customer::where('active', 1)
            ->whereNotNull('closing_date')
            ->whereDate('closing_date', \Carbon\Carbon::now()->addDays(7)->toDateString())
            ->get();
    }

    protected function sendMail()
    {
        foreach ($this->customers as $customer) {
            foreach ($customer->users as $user) {
                if ($user['active'] !== "1" || $user['allow_email'] !== 1 || empty($user['email'])) {
                    continue;
                }

                $email = new MailerContent();
                $email->to($user['email'])
                    ->setContent(
                        'email_alert_closing_account',
                        [
                            'user_first_name' => ucfirst(strtolower($user['first_name'])),
                            'user_last_name' => ucfirst(strtolower($user['last_name'])),
                            'user_email' => $user['email'],
                            'customer_code' => $customer['code'],
                            'date_fermeture_extranet' => user_date_format_localized(\Carbon\Carbon::createFromFormat(get_input_date_format(), $customer['closing_date']), $user['date_format'], $user['timezone']),
                            'front_url' => config_item('front_base_url'),
                        ]
                    );
                $email->handle();
            }
        }
    }
}
