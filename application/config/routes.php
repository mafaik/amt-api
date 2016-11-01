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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/

$config['route']['GUEST'] = [
    'init' => 'welcome/index',
    'api/generate' => 'api/key/index',
    'staff/login' => 'staff/login/index',
    'outlet/login' => 'outlet/login/index',
];

$config['route']['OUTLET'] = [
    'outlet/update' => 'outlet/update/index',
    'outlet/update-password' => 'outlet/updatepassword/index',
    'outlet/detail' => 'outlet/detail/index',
    'building/detail' => 'building/detail/index',
    'building/update' => 'staff/update/index',
    'issue/outlet/insert' => 'issue/insert/index',
    'issue/outlet/update' => 'issue/update/index',
    'issue/outlet/detail' => 'issue/detail/index',
    'issue/outlet/all' => 'issue/outletreport/all',
    'issue/outlet/open' => 'issue/outletreport/open',
    'issue/outlet/pending' => 'issue/outletreport/pending',
    'issue/outlet/progress' => 'issue/outletreport/progress',
    'issue/outlet/history' => 'issue/outletreport/history',
    'notification/outlet/all' => 'notification/outlet/all',
    'notification/outlet/pending' => 'notification/outlet/pending',
    'notification/outlet/checkin' => 'notification/outlet/checkin',
    'notification/outlet/checkout' => 'notification/outlet/checkout',
    'notification/read/outlet' => 'notification/read/outlet_all',
];

$config['route']['ENGINEER'] = [
    'staff/detail' => 'staff/detail/index',
    'staff/update' => 'staff/update/index',
    'staff/update-password' => 'staff/UpdatePassword/index',
    'staff/update-gcm-token' => 'staff/UpdateGcmToken/index',
    'issue/engineer/open' => 'issue/StaffReport/open',
    'issue/engineer/pending' => 'issue/StaffReport/pending',
    'issue/engineer/history' => 'issue/StaffReport/history',
    'issue/engineer/progress' => 'issue/StaffReport/progress',
    'issue/engineer/checkin' => 'issue/progress/index',
    'issue/engineer/done' => 'issue/done/index',
    'notification/staff/pending' => 'notification/staff/pending',
    'notification/read/staff' => 'notification/read/staff',
];

$config['route']['ADMINISTRATOR'] = [
    'staff/register' => 'staff/register/index',
    'staff/delete' => 'staff/delete/index',
    'staff/list' => 'staff/lists/index',
    'staff/available' => 'staff/lists/available',
    'outlet/insert' => 'outlet/insert/index',
    'outlet/list' => 'outlet/lists/index',
    'outlet/delete' => 'outlet/delete/index',
    'building/insert' => 'building/insert/index',
    'building/list' => 'building/lists/index',
    'issue/administrator/all' => 'issue/administratorreport/all',
    'issue/administrator/open' => 'issue/administratorreport/queue',
    'issue/administrator/pending' => 'issue/administratorreport/pending',
    'issue/administrator/progress' => 'issue/administratorreport/progress',
    'issue/administrator/process' => 'issue/administratorreport/history',
    'issue/administrator/select-staff' => 'issue/update/staff',
    'notification/administrator/all' => 'notification/administrator/all',
    'notification/administrator/pending' => 'notification/administrator/pending',
    'notification/administrator/checkin' => 'notification/administrator/checkin',
    'notification/administrator/checkout' => 'notification/administrator/checkout',
    'notification/read/administrator' => 'notification/read/administrator_all',
    'issue/administrator/recurrence/weekly' => 'issue/insert/recurrenceWeekly',
    'issue/administrator/recurrence/monthly' => 'issue/insert/recurrenceMonthly'
];

$route = array_merge(
    $config['route']['GUEST'],
    $config['route']['OUTLET'],
    $config['route']['ENGINEER'],
    $config['route']['ADMINISTRATOR']
);