<?php

namespace Config;

$routes = Services::routes();

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Home::index');

//SEGURANCA
$routes->match(['get', 'post'], '/sign-in', 'Seguranca\Login::autenticar');
$routes->match(['get', 'post'], '/painel/(:any)', 'Seguranca\Painel::listar_usuarios/$1');
$routes->match(['get', 'post'], '/painel-criacao/(:any)/(:any)', 'Seguranca\Painel::criar_usuarios/$1/$2');
//Bradesco
$routes->match(['get', 'post'], '/bradesco-receptivo/(:any)', 'Bradesco\Bradesco::index');

//BMG
$routes->match(['get', 'post'], '/bmg-receptivo/(:any)', 'Bmg\Bmg::bmg_receptivo/$1');
$routes->match(['get', 'post'], '/bmg-saque/(:any)', 'Bmg\Bmg::bmg_saque/$1', ['filter' => 'auth:ADMIN']);
$routes->match(['get', 'post'], '/bmg-cartao/(:any)', 'Bmg\Bmg::bmg_cartao/$1');
$routes->match(['get', 'post'], '/bmg-script-vendas/(:any)/(:any)/(:any)/(:any)/(:any)', 'Bmg\Bmg::bmg_script_vendas/$1/$2/$3/$4/$5');
$routes->match(['get', 'post'], '/bmg-gravar-proposta', 'Bmg\Bmg::bmg_gravar_proposta');
$routes->match(['get', 'post'], '/panorama-gravar-proposta', 'Bmg\Bmg::panorama_gravar_proposta');
$routes->match(['get', 'post'], '/panorama-gravar-proposta-saque', 'Bmg\Bmg::panorama_gravar_proposta_saque');
$routes->match(['get', 'post'], '/mailing', 'Bmg\Mailing::index');
$routes->match(['get', 'post'], '/extrair-relatorio', 'Bmg\Relatorio::index');
$routes->match(['get', 'post'], '/envio-relatorio', 'Bmg\Relatorio::envioRelatorio');

//INSIGHT
$routes->match(['get', 'post'], '/insight-listar-notificacoes', 'Insight\Insight::insight_listar_notificacoes');
$routes->match(['get', 'post'], '/listar-propostas/(:any)/(:any)', 'Insight\Insight::Listar_propostas/$1/$2');
$routes->match(['get', 'post'], '/proposta/(:any)', 'Insight\Insight::insight_proposta/$1');
$routes->match(['get', 'post'], '/insight-upload', 'Insight\Arquivos::uploadPropostas');
$routes->match(['get', 'post'], '/insight-upload/envio', 'Insight\Insight::insight_upload');
$routes->match(['get', 'post'], '/clientes', 'Insight\Clientes::index');
$routes->match(['get', 'post'], '/clientes/upload/(:any)', 'Insight\Clientes::upload/$1');
$routes->match(['get', 'post'], '/clientes/pesquisa', 'Insight\Clientes::pesquisa');
$routes->match(['get', 'post'], '/clientes/pesquisa/limite', 'Insight\Clientes::pesquisaLimite');
$routes->match(['get', 'post'], '/clientes/update', 'Insight\Clientes::update');
$routes->match(['get', 'post'], '/clientes/criar', 'Insight\Clientes::criar');
$routes->match(['get', 'post'], '/perfil', 'Insight\Perfil::index');
$routes->match(['get', 'post'], '/perfil/senha', 'Insight\Perfil::atualizarSenha');
$routes->match(['get', 'post'], '/atualizar-meta/(:any)/(:any)', 'Insight\Insight::atualizarMetas/$1/$2');
$routes->match(['get', 'post'], '/atualizar-meta-qtd/(:any)/(:any)', 'Insight\Insight::atualizarMetasQTD/$1/$2');
$routes->match(['get', 'post'], '/insight-anexar-arquivo/(:any)', 'Insight\Arquivos::anexarArquivos/$1');
$routes->match(['get', 'post'], '/insight/download/(:any)', 'Insight\Arquivos::download/$1/$2');
$routes->match(['get', 'post'], '/insight/excluir/(:any)', 'Insight\Arquivos::excluir/$1/$2');
$routes->match(['get', 'post'], '/export-propostas/(:any)', 'Insight\Arquivos::exportPropostas/$1');
$routes->match(['get', 'post'], '/listar-produtos', 'Insight\Produtos::index');
$routes->match(['get', 'post'], '/registrar-produtos/(:any)', 'Insight\Produtos::registrarProduto/$1');
$routes->match(['get', 'post'], '/registrar-pendencia/(:any)', 'Insight\Produtos::registrarPendencia/$1');
$routes->match(['get', 'post'], '/criar-proposta/(:any)/(:any)', 'Insight\Insight::criarProposta/$1/$2');
$routes->match(['get', 'post'], '/produtos-edit/(:any)', 'Insight\Produtos::produtosEdit/$1');
$routes->match(['get', 'post'], '/pendencias-edit/(:any)', 'Insight\Produtos::pendenciasEdit/$1');
$routes->match(['get', 'post'], '/excluir-pendencia/(:any)', 'Insight\Produtos::excluirPendencia/$1');
$routes->match(['get', 'post'], '/excluir-produto/(:any)', 'Insight\Produtos::excluirProduto/$1');
$routes->match(['get', 'post'], '/editar-produto/(:any)/(:any)', 'Insight\Produtos::editarProduto/$1/$2');
$routes->match(['get', 'post'], '/fila-auditoria', 'Insight\Auditoria::filaAuditoria');
$routes->match(['get', 'post'], '/switch-ativo/(:any)', 'Insight\Auditoria::mudarStatus/$1');
$routes->match(['get', 'post'], '/notificacoes/(:any)', 'Insight\Auditoria::notificacoes/$1');
$routes->match(['get', 'post'], '/buscarNotificacoes/(:any)', 'Insight\Auditoria::buscarNotificacoes/$1');

//THEONE
$routes->match(['get', 'post'], '/extrairdados', 'Theone\ExtrairDados::extrair');

//ARGUS
$routes->match(['get', 'post'], '/argus-atendimento-webhook', 'Argus\Argus::argus_atendimento_webhook');
$routes->match(['get', 'post'], '/argus-tabulacao-webhook', 'Argus\Argus::argus_tabulacao_webhook');
$routes->match(['get', 'post'], '/argus-atendimento-webhook-vap', 'Argus\Argus::argus_atendimento_webhook_vap');
$routes->match(['get', 'post'], '/metricas-ligacao-operador', 'Argus\Argus::metricas_ligacao_operador');


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
