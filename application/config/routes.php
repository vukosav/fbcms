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
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['posting/(:any)'] = 'post/index/$1';
$route['addusers'] = 'users/addusr';
$route['editusers'] = 'users/edit';
$route['showusers/(:any)'] = 'users/show/$1';
$route['login'] = 'login/login';
$route['logout'] = 'login/logout';
$route['users'] = 'users/index';
$route['deleteusr/(:any)'] = 'users/delete/$1';
$route['createuesrs'] = 'users/createusr';
$route['groups'] = 'groups/index';
$route['pages'] = 'pages/index';
$route['addgrp'] = 'groups/addgroup';
$route['creategrp'] = 'groups/creategroup';
$route['insertPG/(:any)/(:any)'] = 'groups/insertPagesGroups/1/1';
$route['deletePG/(:any)/(:any)'] = 'groups/deletePagesGroups/1/1';
$route['deletegrup/(:any)'] = 'groups/delete/$1';
$route['deletepage/(:any)'] = 'pages/delete/$1';
$route['editgrup/(:any)'] = 'groups/edit/$1';
$route['editpage/(:any)'] = 'pages/edit/$1';
$route['editprofile'] = 'users/editprofile';
$route['ressetpwd'] = 'users/ressetpassword';

// $route['news/(:any)'] = 'news/view/$1';
// $route['(:any)'] = 'pages/view/$1';
// $route['default_controller'] = 'pages/view';

//jelena start
$route['insert_pages'] = 'add_pages/insert_pages';
$route['insert_post'] = 'post/insert_post';
//jelena end
