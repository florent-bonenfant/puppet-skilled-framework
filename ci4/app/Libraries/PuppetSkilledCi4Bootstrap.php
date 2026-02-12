<?php

namespace App\Libraries;

use Globalis\PuppetSkilled\Core\Application;
use Illuminate\Database\Capsule\Manager as Capsule;

class PuppetSkilledCi4Bootstrap
{
    private static $booted = false;

    public static function boot()
    {
        if (self::$booted) {
            return;
        }
        self::$booted = true;

        $application = Application::getInstance();
        $container = $application->getContainer();

        $databaseConfig = new \Config\Database();
        $groupName = property_exists($databaseConfig, 'defaultGroup') ? $databaseConfig->defaultGroup : 'default';
        $dbConfig = $databaseConfig->{$groupName};

        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $dbConfig['hostname'] ?? '127.0.0.1',
            'port' => $dbConfig['port'] ?? 3306,
            'database' => $dbConfig['database'] ?? '',
            'username' => $dbConfig['username'] ?? '',
            'password' => $dbConfig['password'] ?? '',
            'charset' => $dbConfig['charset'] ?? 'utf8mb4',
            'collation' => $dbConfig['DBCollat'] ?? 'utf8mb4_general_ci',
            'prefix' => $dbConfig['DBPrefix'] ?? '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $container['capsule'] = $capsule;

        $container['settings'] = static function ($c) use ($capsule) {
            return new \Globalis\PuppetSkilled\Settings\Settings(
                new \Globalis\PuppetSkilled\Settings\SettingsDatabase($capsule->getConnection(), 'settings')
            );
        };

        $container['contentService'] = static function () {
            return new \App\Service\Content\Content();
        };

        $container['eventDispatcher'] = static function () {
            return new \Globalis\PuppetSkilled\Event\Dispatcher();
        };

        $container['authenticationService'] = static function () {
            $auth = new \App\Service\Secure\Authentication();
            $auth->addResource('\App\Service\Secure\Resource\Customer');
            return $auth;
        };

        $container['database.grammar'] = static function () {
            return new \Illuminate\Database\Query\Grammars\MySqlGrammar();
        };

        $container['db'] = static function ($c) use ($capsule) {
            return $capsule->getConnection();
        };

        $container['queryBuilder'] = $container->factory(static function ($c) use ($capsule) {
            return new \Illuminate\Database\Query\Builder($capsule->getConnection(), $c['database.grammar']);
        });

        $container['session'] = static function ($c) {
            return $c['CI']->session;
        };

        $container['queueConnection'] = static function ($c) use ($capsule) {
            return new \Globalis\PuppetSkilled\Queue\DatabaseQueue($capsule->getConnection(), 'jobs');
        };

        $container['queueService'] = static function ($c) {
            return new \Globalis\PuppetSkilled\Queue\Service($c['queueConnection']);
        };

        $container['notificationService'] = static function ($c) {
            return new \App\Service\Notification\Notification($c['queueService']);
        };

        $container['languageService'] = static function () {
            return new \App\Service\Language\Language();
        };

        $container['exportCustomer'] = static function () {
            return new \App\Service\Export\ExportCustomer();
        };

        $capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher());

        if (class_exists('\Globalis\\PuppetSkilled\\Database\\Magic\\Revisionable\\Revision')) {
            \Globalis\PuppetSkilled\Database\Magic\Revisionable\Revision::setUserModel('\App\Model\User');
        }
    }
}
