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

