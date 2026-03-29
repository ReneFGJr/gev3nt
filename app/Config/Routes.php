<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Layout::index');
$routes->get('/layout', 'Layout::index');
$routes->group('auth', function($routes) {
	$routes->get('login', 'Auth::login');
	$routes->post('login', 'Auth::doLogin');
	$routes->get('logout', 'Auth::logout');
	$routes->get('registrar', 'Auth::register');
	$routes->post('registrar', 'Auth::doRegister');
	$routes->get('recuperar-senha', 'Auth::forgot');
	$routes->post('recuperar-senha', 'Auth::doForgot');
});
