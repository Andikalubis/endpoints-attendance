<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('api', function ($routes) {
    // Departement
    $routes->get('departement', 'Api\Departement::index');
    $routes->get('departement/(:num)', 'Api\Departement::show/$1');
    $routes->post('departement', 'Api\Departement::create');
    $routes->put('departement/(:num)', 'Api\Departement::update/$1');
    $routes->delete('departement/(:num)', 'Api\Departement::delete/$1');

    // Employee
    $routes->get('employee', 'Api\Employee::index');
    $routes->get('employee/(:num)', 'Api\Employee::show/$1');
    $routes->post('employee', 'Api\Employee::create');
    $routes->put('employee/(:num)', 'Api\Employee::update/$1');
    $routes->delete('employee/(:num)', 'Api\Employee::delete/$1');

    // Attendance
    $routes->post('attendance/checkin', 'Api\Attendance::checkin');
    $routes->put('attendance/checkout', 'Api\Attendance::checkout');

    // Attendance History
    $routes->get('attendance-history', 'Api\AttendanceHistory::index');
    $routes->get('attendance-history/(:any)', 'Api\AttendanceHistory::show/$1');    
});
