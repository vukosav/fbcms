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
$route['default_controller'] = 'Dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['posting/(:any)'] = 'Post/index/$1';
$route['cancel_edit/(:any)'] = 'FB_post/cancel_edit_post/$1';
$route['halt/(:any)'] = 'FB_post/halt/$1';
$route['set_draft/(:any)'] = 'FB_post/set_as_draft_post/$1';
$route['resume/(:any)'] = 'FB_post/resume/$1';
$route['editusers'] = 'Users/edit';
$route['showusers/(:any)'] = 'Users/show/$1';
$route['login'] = 'Login/login';
$route['logout'] = 'Login/logout';
$route['users'] = 'Users/index';
$route['deleteusr/(:any)'] = 'Users/delete/$1';
$route['createuesrs'] = 'Users/createusr';
$route['groups'] = 'Groups/index';
$route['pages'] = 'Pages/index';
$route['addgrp'] = 'Groups/addgroup';
$route['creategrp'] = 'Groups/creategroup';
$route['insertPG/(:any)/(:any)'] = 'Groups/insertPagesGroups/1/1';
$route['deletePG/(:any)'] = 'Groups/deletePagesGroups/1';
$route['deletegrup/(:any)'] = 'Groups/delete/$1';
$route['deletepage/(:any)'] = 'Pages/delete/$1';
$route['editgrup/(:any)'] = 'Groups/edit/$1';
$route['editpage/(:any)'] = 'Pages/edit/$1';
$route['editprofile'] = 'Users/editprofile';
$route['ressetpwd'] = 'Users/ressetpassword';
$route['fbcheck'] = 'FBCheck';
// $route['news/(:any)'] = 'news/view/$1';
// $route['(:any)'] = 'Pages/view/$1';
// $route['default_controller'] = 'pages/view';

//jelena start
$route['insert_pages'] = 'Add_pages/insert_pages';
// $route['insert_post'] = 'Post/insert_post';
$route['send_post'] = 'Send_post';
$route['send_post/index/(:any)'] = 'Send_post/index/$1';
$route['create_post'] = 'FB_post/create_post';
$route['edit_post/(:any)'] = 'FB_post/edit_post/$1';
$route['copy_post/(:any)'] = 'FB_post/copy_post/$1';
$route['fb_post/insert_post/(:any)'] = 'FB_post/insert_post/$1';
$route['archive_post/(:any)'] = 'FB_post/archive_post/$1';
//jelena end



//job
$route['start'] = 'Cron_job/start';
$route['start/(:any)'] = 'Cron_job/start/$1';