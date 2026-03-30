<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Layout::index');
$routes->get('/layout', 'Layout::index');
$routes->get('/contato', 'Layout::contato');
$routes->group('auth', function($routes) {
	$routes->get('login', 'Auth::login');
	$routes->post('login', 'Auth::doLogin');
	$routes->get('logout', 'Auth::logout');
	$routes->get('registrar', 'Auth::register');
	$routes->post('registrar', 'Auth::doRegister');
	$routes->get('recuperar-senha', 'Auth::forgot');
	$routes->post('recuperar-senha', 'Auth::doForgot');
	$routes->get('resetar-senha', 'Auth::resetPassword');
	$routes->post('resetar-senha', 'Auth::doResetPassword');
});
