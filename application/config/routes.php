<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = 'custom404';

$route['logowanie'] = 'admin/auth/login';
$route['rejestracja'] = 'admin/auth/register';
$route['wyloguj'] = 'admin/auth/logout';
$route['dashboard'] = 'admin/dashboard/index';
$route['page-not-found'] = 'custom404';

$route['api/get'] = 'api/restapi/get';
$route['api/get/(:num)'] = 'api/restapi/getById/$1';
$route['api/put/(:num)'] = 'api/restapi/put/$1';
$route['api/patch/(:num)'] = 'api/restapi/patch/$1';
$route['api/post'] = 'api/restapi/post';
$route['api/delete/(:num)'] = 'api/restapi/delete/$1';

$route['solr'] = 'solr/index';

/* End of file routes.php */
/* Location: ./application/config/routes.php */