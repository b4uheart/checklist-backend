<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/
$route['default_controller'] = 'auth/login';
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['dashboard'] = 'dashboard/index';
$route['dashboard/tasks'] = 'dashboard/tasks';
$route['dashboard/reports'] = 'dashboard/reports';
$route['dashboard/equipment'] = 'dashboard/equipment';

// API Routes
$route['api/login'] = 'auth/login';
$route['api/auth/me'] = 'api/auth_me';
$route['api/auth/logout'] = 'api/auth_logout';
$route['api/equipment/qr/(:any)'] = 'api/equipment_qr/$1';
$route['api/questions/(:any)'] = 'api/questions/$1';
$route['api/inspections/save'] = 'api/save_inspection';
$route['api/inspections/history'] = 'api/inspections_history';
$route['api/inspections/(:num)'] = 'api/inspection_detail/$1';
$route['api/dashboard/summary'] = 'api/dashboard_summary';
$route['api/dashboard/recent-scans'] = 'api/dashboard_recent_scans';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
