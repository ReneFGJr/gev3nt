<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$pre = '';
$routes->get('/', 'Home::index');
$routes->get($pre. '/inscrever/(:any)', 'Home::inscrever/$1');
$routes->post($pre . '/inscrever/(:any)', 'Home::inscrever/$1');

$routes->get($pre . '/novasenha', 'Home::forgot_user/$1');
$routes->post($pre . '/novasenha', 'Home::forgot_user/$1');

$routes->get($pre . '/signin', 'Home::signin');
$routes->post($pre . '/signin', 'Home::signin');

$routes->get($pre . '/signup', 'Home::signup');
$routes->post($pre . '/signup', 'Home::signup');
