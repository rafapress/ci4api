<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('api/users', [
  'namespace'  => 'App\Controllers',
  'controller' => 'Users',
  'filter'     => 'authfilter'
]);

// $routes->resource('api/users');

// 'filter'     => 'corsAuth'

// $routes->resource('api/users', ['filter' => 'authfilter']);

// $routes->get('api/users', 'Users::list');
// $routes->post('api/users/new', 'Users::create');
// $routes->delete('api/users/(:num)', 'Users::delete');

