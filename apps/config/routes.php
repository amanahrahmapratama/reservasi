<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

$route['about'] = 'base/about';
$route['contact'] = 'base/contact';
$route['work'] = 'base/work';
$route['faq'] = 'base/faq';
$route['portal'] = 'base/portal';
$route['search'] = 'base/search';
$route['get-csrf-token'] = 'base/get_csrf_token';
$route['auth/register'] = 'customer/auth/register';
$route['auth/login'] = 'customer/auth/login';
$route['auth/logout'] = 'customer/auth/logout';
$route['auth/forgot'] = 'customer/auth/forgot';
$route['auth/reset'] = 'customer/auth/rpw';

$route['(:any)/read/(:num)/(:num)/(:num)/(:num)/(:any).html'] = "$1/detail/$5/$6";
$route['user/cart/view'] = 'user/view_cart';
$route['user/(:any)/view/(:num)'] = "user/view_$1/$2";
$route['user/(:any)/edit/(:num)'] = "user/edit_$1/$2";
$route['(:any)/view/(:num)/(:any).html'] = "$1/detail/$2/$3";

$route['admin/auth/login'] = 'user/auth/login';
$route['admin/auth'] = 'user/auth/login';
$route['admin'] = "dashboard/dashboard_admin";

$route['admin/(:any)/edit/(:num)'] = "$1/$1_admin/add/$2";
$route['admin/(:any)/edit/([a-zA-Z_-]+)'] = "$1/$1_admin/add/$2";

$route['admin/(:any)/(:any)/edit/(:num)'] = "$1/$1_admin/add_$2/$3";
$route['admin/(:any)/(:any)/(:num)/(:num)'] = "$1/$1_admin/$2/$3/$4";
$route['admin/(:any)/(:any)/(:num)'] = "$1/$1_admin/$2/$3";
$route['admin/([a-zA-Z_-]+)/(:any)'] = '$1/$1_admin/$2';
$route['admin/media_album/(:any)'] = 'media_manager/media_album_admin/$1';
$route['admin/media_album'] = 'media_manager/media_album_admin';
$route['admin/([a-zA-Z_-]+)'] = '$1/$1_admin';

$route['default_controller'] = "base";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
