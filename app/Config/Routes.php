
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Layout::index');
$routes->get('/layout', 'Layout::index');
$routes->get('/contato', 'Layout::contato');
$routes->get('/eventos', 'Eventos::index');
$routes->post('/eventos/inscrever/(:num)', 'Eventos::inscrever/$1');
$routes->post('/eventos/cancelar/(:num)', 'Eventos::cancelar/$1');
$routes->post('/eventos/enviar-confirmacao/(:num)', 'Eventos::enviarConfirmacao/$1');
$routes->get('certificados/imprimir/(:num)', 'Layout::imprimir/$1');
$routes->get('search-certificate', 'SearchCertificate::index');
$routes->post('search-certificate', 'SearchCertificate::search');


$routes->group('admin', ['filter' => 'auth'], function ($routes) {
	$routes->get('/', function() { return view('admin/index'); });
	$routes->get('events', 'Admin\\Events::index');
	$routes->get('events/create', 'Admin\\Events::create');
	$routes->post('events/store', 'Admin\\Events::store');
	$routes->get('events/view/(:num)', 'Admin\\Events::view/$1');
	$routes->get('events/edit/(:num)', 'Admin\\Events::edit/$1');
	$routes->post('events/update/(:num)', 'Admin\\Events::update/$1');
	$routes->get('event/import/(:num)', 'Admin\\Events::import/$1');
	$routes->post('event/import/(:num)', 'Admin\\Events::import/$1');
});


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
