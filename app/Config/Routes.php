<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
//FGTS
$routes->match(['get', 'post'], '/fgts-pendente-adesao/(:any)', 'Fgts\Fgts::atualizarStatusPropostaAdesao/$1');
$routes->match(['get', 'post'], '/fgts-proposta-disponível/(:any)', 'Fgts\Fgts::atualizarStatusPropostaDisponivel/$1');
$routes->match(['get', 'post'], '/fgts-operador-owner/(:any)', 'Fgts\Fgts::atualizarStatusPropostaOperador/$1');
$routes->match(['get', 'post'], '/fgts-listar-propostas', 'Fgts\Fgts::listarPropostas');

//DATALAKE
$routes->match(['get', 'post'], '/datalake-buscar', 'DataLake\DataLake::buscarCliente');
$routes->match(['get', 'post'], '/vanguard-decode', 'DataLake\DataLake::vanguardDecode');
$routes->match(['get', 'post'], '/datalake-carregar-inss', 'DataLake\DataLake::load_INSS_Batch');
$routes->match(['get', 'post'], '/sign-in', 'Seguranca\Login::autenticar');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
