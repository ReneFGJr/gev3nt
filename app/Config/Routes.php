
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
	$routes->get('event', 'Admin\\EventCrud::index');
	$routes->get('event/create', 'Admin\\EventCrud::create');
	$routes->post('event/store', 'Admin\\EventCrud::store');
	$routes->get('event/view/(:num)', 'Admin\\EventCrud::view/$1');
	$routes->post('event/grant-access/(:num)', 'Admin\\EventCrud::grantAccess/$1');
	$routes->post('event/revoke-access/(:num)', 'Admin\\EventCrud::revokeAccess/$1');
	$routes->get('event/edit/(:num)', 'Admin\\EventCrud::edit/$1');
	$routes->post('event/update/(:num)', 'Admin\\EventCrud::update/$1');
	$routes->post('event/delete/(:num)', 'Admin\\EventCrud::delete/$1');
	$routes->get('events', 'Admin\\Events::index');
	$routes->get('events/create', 'Admin\\Events::create');
	$routes->post('events/store', 'Admin\\Events::store');
	$routes->get('events/view/(:num)', 'Admin\\Events::view/$1');
	$routes->get('events/sections/(:num)', 'Admin\\Events::sections/$1');
	$routes->get('events/make_certificates/(:num)', 'Admin\\Events::makeCertificates/$1');
	$routes->post('events/make_certificates/(:num)', 'Admin\\Events::makeCertificates/$1');
	$routes->get('events/sign-list/(:num)', 'Admin\\Events::signList/$1');
	$routes->get('events/attendance/(:num)', 'Admin\\Events::attendance/$1');
	$routes->post('events/mark-present/(:num)', 'Admin\\Events::markPresent/$1');
	$routes->post('events/mark-pending/(:num)', 'Admin\\Events::markPending/$1');
	$routes->get('events/edit/(:num)', 'Admin\\Events::edit/$1');
	$routes->post('events/update/(:num)', 'Admin\\Events::update/$1');
	$routes->get('events/import/(:num)', 'Admin\\Events::import/$1');
	$routes->post('events/import/(:num)', 'Admin\\Events::import/$1');
	$routes->get('event/import/(:num)', 'Admin\\Events::import/$1');
	$routes->post('event/import/(:num)', 'Admin\\Events::import/$1');
	$routes->get('label', 'Admin\\Label::index');
	$routes->get('label/inport', 'Admin\\Label::inport');
	$routes->post('label/inport', 'Admin\\Label::inport');
	$routes->get('label/edit/(:num)', 'Admin\\Label::edit/$1');
	$routes->post('label/update/(:num)', 'Admin\\Label::update/$1');
	$routes->get('label/print/(:num)', 'Admin\\Label::print/$1');
	$routes->post('label/print-all', 'Admin\\Label::printAll');
	$routes->post('label/mark-for-printing', 'Admin\\Label::markForPrinting');
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
