<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
if (!is_cli()) {
    $route['default_controller'] = 'authentication/login';
    $route['404_override'] = 'miscellaneous/not_found';
    $route['translate_uri_dashes'] = false;

    $route['cli/(.*)'] = 'miscellaneous/not_found';

    // Move these useless OPTIONS requests away
    $route['webservice/(.*)']['OPTIONS'] = 'webservice/misc/hello';

    $route['webservice/authentication/(:any)'] = 'webservice/authentication/$1';

    $route['webservice/commercial_condition/all_current'] = 'webservice/commercial_condition/all_current';
    $route['webservice/notification/mark_all_as_read'] = 'webservice/notification/mark_all_as_read';
    $route['webservice/statistic/last'] = 'webservice/statistic/last';
    $route['webservice/statistic/(\d{4})/(\d{2})'] = 'webservice/statistic/month/$1/$2';

    $route['webservice/institut/(:any)/file']['GET'] = 'webservice/institut/get_files/$1';
    $route['webservice/institut/(:any)/file/(:any)']['GET'] = 'webservice/institut/get_file/$1/$2';
    $route['webservice/institut/(:any)/file/(:any)']['DELETE'] = 'webservice/institut/delete_file/$1/$2';
    $route['webservice/institut/(:any)/file']['POST'] = 'webservice/institut/upload_file/$1';
    $route['webservice/expired_date/csv']['GET'] = 'webservice/expired_date/export_csv';
    $route['webservice/expired_date/pdf']['GET'] = 'webservice/expired_date/export_pdf';

    $route['webservice/([a-z_]+)']['GET'] = 'webservice/$1/all';
    $route['webservice/([a-z_]+)']['POST'] = 'webservice/$1/create_one';
    $route['webservice/([a-z_]+)/file']['GET'] = 'webservice/$1/download_auto';
    $route['webservice/([a-z_]+)/(:any)']['PUT'] = 'webservice/$1/update_one/$2';
    $route['webservice/([a-z_]+)/(:any)']['DELETE'] = 'webservice/$1/delete_one/$2';
    $route['webservice/([a-z_]+)/(:any)']['GET'] = 'webservice/$1/one/$2';
    $route['webservice/([a-z_]+)/(:any)/file']['GET'] = 'webservice/$1/download_one/$2';
    $route['webservice/([a-z_]+)/(:any)']['POST'] = 'webservice/$1/edit_one/$2';
    $route['webservice/([a-z_]+)/last/(:any)']['GET'] = 'webservice/$1/last/$2';

} else {
    $route['(.*)'] = 'cli/$1';
}
