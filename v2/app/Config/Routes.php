<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * 
 * 
 */
$pre = '';


/********************* Certificados */

$routes->get('/certificado', 'Certificate::index');
$routes->get('/certificado/(:any)', 'Certificate::index/$1');
$routes->post('/certificado/(:any)', 'Certificate::index/$1');

$routes->get('/', 'Home::index');
$routes->get('/main', 'Home::main');
$routes->get('/download', 'Home::download');
$routes->get('/downloadDoc', 'Home::downloadDoc');

$routes->get('/upload_presentation/(:num)', 'Home::upload_presentation/$1');
$routes->post('/upload_presentation/(:num)', 'Home::upload_presentation/$1');

/******************** Votacao */
$routes->post('votacao', 'Votacao::email');
$routes->get('votacao', 'Votacao::email');
$routes->get('votacao/login', 'Votacao::index');
$routes->get('votacao/list', 'Votacao::list');
$routes->post('votacao/autenticar', 'Votacao::autenticar');
$routes->get('votacao/autenticar', 'Votacao::autenticar');
$routes->post('votacao/votar', 'Votacao::votar');

//http://g3vent/inscricoes/download?file=doc_00000044.pdf&check470de110dbbeb21638ec2f89a4539eda

$routes->get('boleto/form', 'BoletoController::form');
$routes->post('boleto/registrar', 'BoletoController::registrar');
$routes->get('boleto/consultar/(:num)', 'BoletoController::consultar/$1');

$routes->get('/admin', 'Admin::index');
$routes->get('/admin/(:any)', 'Admin::index/$1');
$routes->post('/admin/(:any)', 'Admin::index/$1');

$routes->get('/admin/(:any)/(:any)', 'Admin::index/$1/$2');
$routes->post('/admin/(:any)/(:any)', 'Admin::index/$1/$2');

$routes->get('/admin/(:any)/(:any)/(:any)', 'Admin::index/$1/$2/$3');
$routes->post('/admin/(:any)/(:any)/(:any)', 'Admin::index/$1/$2/$3');

$routes->get('/media', 'Home::media');
$routes->get('/media/(:any)', 'Home::media/$1');
$routes->get('/media/(:any)/(:any)', 'Home::media/$1/$2');
$routes->post('/media', 'Home::media');


$routes->get($pre. '/subscribe/(:any)', 'Home::subscribe/$1');
$routes->get($pre . '/subscribe/(:any)/(:any)', 'Home::subscribe/$1/$2');
$routes->post($pre . '/subscribe/(:any)', 'Home::subscribe/$1');
$routes->get('subscribe_confirm/(:num)/(:any)', 'Home::subscribe_confirm/$1/$2');

$routes->get($pre . '/payment/(:any)', 'Home::payment/$1');
$routes->post($pre . '/payment/(:any)', 'Home::payment/$1');

$routes->get($pre . '/novasenha', 'Home::forgot_user/$1');
$routes->post($pre . '/novasenha', 'Home::forgot_user/$1');

$routes->get($pre . '/signin', 'Home::signin');
$routes->post($pre . '/signin', 'Home::signin');

$routes->get($pre . '/signup', 'Home::signup');
$routes->post($pre . '/signup', 'Home::signup');

$routes->get($pre . '/presentations', 'Home::presentations');
$routes->get($pre . '/presentations/(:any)/(:any)', 'Home::presentations/$1/$2');


$routes->get($pre . '/logoff', 'Home::logoff');

$routes->get($pre . '/setpassword', 'Home::setpassword');
$routes->post($pre . '/setpassword', 'Home::setpassword');

$routes->get($pre . '/profile', 'Home::profile');

$routes->get($pre . '/certificate', 'Home::certificate');
$routes->get($pre . '/certificate/(:any)', 'Home::made_certificate/$1');
$routes->get($pre . '/certificateO/(:any)', 'Home::made_certificate_other/$1');

$routes->get($pre . '/meuseventos', 'Home::meuseventos');
$routes->get($pre . '/meuseventos/(:any)', 'Home::meuseventos');


$routes->get($pre . '/email/test', 'Home::emailtest');
$routes->get($pre . '/sample', 'Home::sample');
