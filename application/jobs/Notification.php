<?php
namespace App\Job;

use \App\Job\MailerContent;
use \App\Service\Notification\Model as NotificationModel;

class Notification extends \Globalis\PuppetSkilled\Queue\Queueable
{
    protected $notifs = [];

    protected function loadNotifications()
    {
        $notifs = NotificationModel::query()->where('read', 0)
            ->whereHas('customer', function ($query) {
                $query->where('active', 1)
                    ->isNotClosed()
                    ->isNotRestricted()
                    ->whereHas('users', function ($query) {
                        $query->where('allow_email', 1);
                    });
            })->get();
        $this->buildData($notifs);
    }

    public function handle()
    {
        $this->loadNotifications();
        $this->sendMail();
    }

    protected function buildData($data)
    {
        foreach ($data as $not) {
            if (isset($this->notifs[$not->customer_id])) {
                $this->notifs[$not->customer_id]['nb_notif']++;
            } else {
                $this->notifs[$not->customer_id] = ['nb_notif' => 1];
                // On envoie un mail à chaque utilisateur les autorisants au sein de la société
                foreach ($not->customer->users as $user) {
                    // On ignore les comptes inactif ou qui ne veulent pas de mails
                    if ($user['active'] !== "1" || $user['allow_email'] !== 1 || empty($user['email'])) {
                        continue;
                    }

                    $this->notifs[$not->customer_id][$user['email']] = [
                        'email' => $user['email'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['first_name'],
                        'code' => $not->customer->id,
                    ];
                }
            }
        }
    }

    protected function sendMail()
    {
        foreach ($this->notifs as $not) {
            foreach ($not as $user) {
                $email = new MailerContent();
                $email->to($user['email'])
                    ->setContent(
                        'email_unread_notification',
                        [
                            'user_first_name' => ucfirst(strtolower($user['first_name'])),
                            'user_last_name' => ucfirst(strtolower($user['last_name'])),
                            'user_email' => $user['email'],
                            'customer_code' => $user['code'],
                            'nb_notif' => $not['nb_notif'],
                            'front_url' => config_item('front_base_url'),
                        ]
                    );
                $email->handle();
            }
        }
    }
}
