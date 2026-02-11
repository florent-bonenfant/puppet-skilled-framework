<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \App\Job\MailerContent;

class TestJob extends \Globalis\PuppetSkilled\Controller\Cli
{
    public function index()
    {
        $email = new MailerContent();
        $email->to('un@mail.fr')
        ->setContent(
            'email_new_cgv',
            [
                'user_first_name' => 'first',
                'user_last_name'  => 'last',
                'user_email'      => 'first.last@mail.fr',
                'front_url'       => config_item('front_base_url') . '/cgv'
            ]
        );
        $email->handle();
    }
}
