<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LegacyDispatcher::handle');
$routes->add('backoffice', 'BackOffice\Dispatcher::handle');
$routes->add('backoffice/(.*)', 'BackOffice\Dispatcher::handle/$1');
$routes->add('webservice', 'Webservice\Dispatcher::handle');
$routes->add('webservice/(.*)', 'Webservice\Dispatcher::handle/$1');
$routes->add('(:any)', 'LegacyDispatcher::handle/$1');
