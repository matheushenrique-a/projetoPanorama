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

//AMBEC
$routes->match(['get', 'post'], '/ambec-script', 'Ambec\Ambec::ambec_script');

//FGTS
$routes->match(['get', 'post'], '/fgts-adm-simulacao/(:any)/(:any)/(:any)', 'Fgts\Fgts::adm_simulacao/$1/$2/$3');
$routes->match(['get', 'post'], '/fgts-proposta-disponivel/(:any)/(:any)', 'Fgts\Fgts::atualizarStatusProposta/$1/$2');
$routes->match(['get', 'post'], '/fgts-operador-owner/(:any)', 'Fgts\Fgts::atualizarStatusPropostaOperador/$1');
$routes->match(['get', 'post'], '/fgts-listar-propostas', 'Fgts\Fgts::listarPropostas');
$routes->match(['get', 'post'], '/fgts-cliente-detalhes/(:any)', 'Fgts\Fgts::clienteDetalhes/$1');
$routes->match(['get', 'post'], '/indicadores-diarios', 'Fgts\Indicadores::indicadores_diarios');
$routes->match(['get', 'post'], '/indicadores-esteira', 'Fgts\Indicadores::indicadores_esteira');

//FL
$routes->match(['get', 'post'], '/fgts-templates-frontlne', 'Fgts\Fgts::listarTemplates');
$routes->match(['get', 'post'], '/criar-template/(:any)/(:any)', 'Fgts\Fgts::criarTemplates/$1/$2');

$routes->match(['get', 'post'], '/metricas-semanais', 'Fgts\Indicadores::metricas_semanais');
$routes->match(['get', 'post'], '/metricas-semanais/(:any)/(:any)', 'Fgts\Indicadores::metricas_semanais/$1/$2');

//CONSORCIO
$routes->match(['get', 'post'], '/consorcio-listar-propostas', 'Consorcio\Consorcio::listarPropostas');
$routes->match(['get', 'post'], '/consorcio-cliente-detalhes/(:any)', 'Consorcio\Consorcio::clienteDetalhes/$1');
$routes->match(['get', 'post'], '/consorcio-adm-simulacao/(:any)/(:any)/(:any)', 'Consorcio\Consorcio::adm_simulacao/$1/$2/$3');
$routes->match(['get', 'post'], '/consorcio-atualizar-proposta/(:any)/(:any)', 'Consorcio\Consorcio::consorcio_atualizar_proposta/$1/$2');
$routes->match(['get', 'post'], '/carregar-proposta-bmg', 'Consorcio\Consorcio::carregar_proposta_bmg');

//DATALAKE
$routes->match(['get', 'post'], '/datalake-buscar', 'DataLake\DataLake::buscarCliente');
$routes->match(['get', 'post'], '/vanguard-decode', 'DataLake\DataLake::vanguardDecode');
$routes->match(['get', 'post'], '/datalake-carregar-inss', 'DataLake\DataLake::load_INSS_Batch');
$routes->match(['get', 'post'], '/sign-in', 'Seguranca\Login::autenticar');

//ADS
$routes->match(['get', 'post'], '/ad-miner', 'Ads\Ads::listarAds');
$routes->match(['get', 'post'], '/ad-miner/(:any)', 'Ads\Ads::listarAds/$1');
$routes->match(['get', 'post'], '/ads-like', 'Ads\Ads::adsLike');
$routes->match(['get', 'post'], '/ads-nicho', 'Ads\Ads::adsNicho');
$routes->match(['get', 'post'], '/ads-load', 'Ads\Ads::loadMiner');

//META
$routes->match(['get', 'post'], '/ad-manager', 'Meta\Meta::manager');
$routes->match(['get', 'post'], '/ad-action/(:any)/(:any)', 'Meta\Meta::action/$1/$2');
$routes->match(['get', 'post'], '/indicadores-vsl', 'Meta\Indicadores::indicadores_vsl');

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
