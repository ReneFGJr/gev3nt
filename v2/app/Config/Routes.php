<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$pre = '';
$routes->get('/', 'Home::index');
$routes->get('/main', 'Home::main');
$routes->get($pre. '/subscribe/(:any)', 'Home::subscribe/$1');
$routes->get($pre . '/subscribe/(:any)/(:any)', 'Home::subscribe/$1/$2');
$routes->post($pre . '/subscribe/(:any)', 'Home::subscribe/$1');
$routes->get('subscribe_confirm/(:num)/(:any)', 'Home::subscribe_confirm/$1/$2');

$routes->get($pre . '/novasenha', 'Home::forgot_user/$1');
$routes->post($pre . '/novasenha', 'Home::forgot_user/$1');

$routes->get($pre . '/signin', 'Home::signin');
$routes->post($pre . '/signin', 'Home::signin');

$routes->get($pre . '/signup', 'Home::signup');
$routes->post($pre . '/signup', 'Home::signup');

$routes->get($pre . '/setpassword', 'Home::setpassword');
$routes->post($pre . '/setpassword', 'Home::setpassword');

$routes->get($pre . '/profile', 'Home::profile');

$routes->get($pre . '/meuseventos', 'Home::meuseventos');
