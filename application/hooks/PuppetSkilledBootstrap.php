<?php

use \Globalis\PuppetSkilled\Core\Application;
use \Illuminate\Database\Capsule\Manager as Capsule;
// use \Illuminate\Events\Dispatcher;

class PuppetSkilledBootstrap
{
    public function boot()
    {
        $application = Application::getInstance();

        $container = $application->getContainer();
        $db = $application->get('db');

        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $db->hostname,
            'database'  => $db->database,
            'username'  => $db->username,
            'password'  => $db->password,
            'charset'   => $db->char_set,
            'collation' => $db->dbcollat,
            'prefix'    => $db->dbprefix,
        ]);
        // $dispatcher = new Dispatcher(new $container['eventDispatcher']);
        // $capsule->setEventDispatcher($dispatcher);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        // Register Settings Service
        $container['settings'] = function ($c) use ($capsule) {
            return new \Globalis\PuppetSkilled\Settings\Settings(new \Globalis\PuppetSkilled\Settings\SettingsDatabase($capsule->getConnection(), 'settings'));
        };

        // Register Content Service
        $container['contentService'] = function () {
            return new \App\Service\Content\Content();
        };

        // Register Event Dispatcher
        $container['eventDispatcher'] = function () {
            return new \Globalis\PuppetSkilled\Event\Dispatcher();
        };

        // Register authentication Service
        $container['authenticationService'] = function () {
            $auth = new \App\Service\Secure\Authentication();
            // Ajout des resources
            $auth->addResource('\App\Service\Secure\Resource\Customer');
            return $auth;
        };

        // Datababse
        $container['database.grammar'] = function () {
            return new \Illuminate\Database\Query\Grammars\MySqlGrammar();
        };

        $container['db'] = function ($c) {
            if (!isset($c['CI']->db)) {
                $c['CI']->load->database();
            }
            // Insert Get grammar function for ORM
            $c['CI']->db->getQueryGrammar = $c['database.grammar'];
            return $c['CI']->db;
        };

        $container['queryBuilder'] = $container->factory(function ($c) use ($capsule) {
            return new \Illuminate\Database\Query\Builder($capsule->getConnection(), $c['database.grammar']);
        });

        $container['session'] = function ($c) {
            if (!isset($c['CI']->session)) {
                $c['CI']->load->library('session');
            }
            return $c['CI']->session;
        };

        // Queue
        $container['queueConnection'] = function ($c) use ($capsule) {
            return new \Globalis\PuppetSkilled\Queue\DatabaseQueue($capsule->getConnection(), 'jobs');
        };

        $container['queueService'] = function ($c) {
            return new \Globalis\PuppetSkilled\Queue\Service($c['queueConnection']);
        };

        // Notification Service
        $container['notificationService'] = function ($c) {
            return new App\Service\Notification\Notification($c['queueService']);
        };

        // Language
        $container['languageService'] = function ($c) {
            return new \App\Service\Language\Language();
        };

        $container['exportCustomer'] = function ($c) {
            return new \App\Service\Export\ExportCustomer();
        };

        // Init ORM
        $capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher());

        // \Globalis\PuppetSkilled\Database\Magic\Model::setConnectionResolver($capsule->getConnection());
        // \Illuminate\Database\Eloquent\Model::setConnectionResolver($container['db']);
        // \Illuminate\Database\Eloquent\Model::setConnectionResolver($capsule->getConnection());
        // \Illuminate\Database\Eloquent\Model::setEventDispatcher(new \Illuminate\Events\Dispatcher());
        \Globalis\PuppetSkilled\Database\Magic\Revisionable\Revision::setUserModel('\App\Model\User');
        // @todo inprogress

    }
}
