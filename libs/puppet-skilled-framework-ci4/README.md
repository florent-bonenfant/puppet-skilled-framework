Bascule de Puppet skilled pour utilisation avec PHP8.0
Cette version utilise CI 3.1.13 et remplace la version eloquent embarqué par une version gérer à travers composer de façon à retrouver tous les éléments de ce dernier sans restriction.

@todo
- Voir pour intégrer et utiliser directement codeigniter sans l'intégrer dans les projets
- continuer les tests, notamment les sessions qui ont un soucis aléatoire (normalement réglé en limitant le nombre d'écriture sur les webservices)


## Hooks
Voici le nouveau boot pour PuppetSkilledBootstrap, à adapter selon vos projets :
```
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
        // \Globalis\PuppetSkilled\Database\Magic\Model::setConnectionResolver($capsule->getConnection());
        // \Globalis\PuppetSkilled\Database\Magic\Model::setConnectionResolver($container['db']);
        // \Illuminate\Database\Eloquent\Model::setConnectionResolver($capsule->getConnection());
        // \Globalis\PuppetSkilled\Database\Magic\Model::setEventDispatcher($container['eventDispatcher']);
        \Globalis\PuppetSkilled\Database\Magic\Revisionable\Revision::setUserModel('\App\Model\User');
        // @todo inprogress
    }
}

```

## Sessions
Adaptation des sessions avec PHP8, veuillez étendre les classes :
- Remplacer CI_session par \Globalis\PuppetSkilled\Session\APP_CI_Session
- Remplacer CI_SessionWrapper par \Globalis\PuppetSkilled\Session\APP_CI_SessionWrapper

### Sans webservices
Vous pouvez surcharger le CI_Session à travers un fichier APP_Session qui lui reprendra les informations ci-dessus et permettra ainsi l'utilisation d'eloquent

### Avec webservices
Si vous utilisez des webservices, vous avez très certainement déjà surcharger le CI_Session de codeigniter, il vous suffit d'adapter un peu votre fichier

## Utilisation ORM
On bascule maintenant dans une version plus standard d'Eloquent
Par exemple au lieu d'utiliser
```
use Globalis\PuppetSkilled\Database\Magic\Model;
use \Globalis\PuppetSkilled\Database\Query\Expression;
use Globalis\PuppetSkilled\Database\Query\Builder as QueryBuilder;
use Globalis\PuppetSkilled\Database\Magic\Model;
use Globalis\PuppetSkilled\Database\Magic\Relations\Pivot;
```
nous utiliserons
```
use \Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Query\Expression;
use \Illuminate\Database\Query\Builder as QueryBuilder;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
```
