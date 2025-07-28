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

//SEGURANCA
$routes->match(['get', 'post'], '/sign-in', 'Seguranca\Login::autenticar');
$routes->match(['get', 'post'], '/painel', 'Seguranca\Painel::listar_usuarios');
$routes->match(['get', 'post'], '/painel/(:any)/(:any)', 'Seguranca\Painel::criar_usuarios/$1/$2');

//Bradesco
$routes->match(['get', 'post'], '/bradesco-receptivo/(:any)', 'Bradesco\Bradesco::index');

//BMG
$routes->match(['get', 'post'], '/bmg-receptivo/(:any)', 'Bmg\Bmg::bmg_receptivo/$1');
$routes->match(['get', 'post'], '/bmg-saque/(:any)', 'Bmg\Bmg::bmg_saque/$1');
$routes->match(['get', 'post'], '/bmg-script-vendas/(:any)/(:any)/(:any)/(:any)/(:any)', 'Bmg\Bmg::bmg_script_vendas/$1/$2/$3/$4/$5');
$routes->match(['get', 'post'], '/bmg-gravar-proposta', 'Bmg\Bmg::bmg_gravar_proposta');
$routes->match(['get', 'post'], '/panorama-gravar-proposta', 'Bmg\Bmg::panorama_gravar_proposta');
$routes->match(['get', 'post'], '/panorama-gravar-proposta-saque', 'Bmg\Bmg::panorama_gravar_proposta_saque');
$routes->match(['get', 'post'], '/mailing', 'Bmg\Mailing::index');


//AMBEC
$routes->match(['get', 'post'], '/ambec-script', 'Ambec\Ambec::ambec_script');

//META-IG
$routes->match(['get', 'post'], '/instagram-webhook', 'Meta\Instagram::instagram_webhook');

//META
$routes->match(['get', 'post'], '/whatsapp-webhook', 'Meta\WhatsApp::whatsapp_webhook');
$routes->match(['get', 'post'], '/whatsapp-listner/(:any)/(:any)/(:any)/(:any)', 'Meta\WhatsApp::whatsapp_listner/$1/$2/$3/$4');
$routes->match(['get', 'post'], '/whatsapp-direct', 'Meta\WhatsApp::whatsapp_direct');
$routes->match(['get', 'post'], '/whatsapp-send-template', 'Meta\WhatsApp::whatsapp_send_template');
$routes->match(['get', 'post'], '/whatsapp-send-template-cloud', 'Meta\WhatsApp::whatsapp_send_template_cloud');
$routes->match(['get', 'post'], '/whatsapp-list-templates', 'Meta\WhatsApp::whatsapp_list_templates');
$routes->match(['get', 'post'], '/whatsapp-send-text', 'Meta\WhatsApp::whatsapp_send_text');
$routes->match(['get', 'post'], '/whatsapp-chat', 'Meta\WhatsApp::whatsapp_chat');
$routes->match(['get', 'post'], '/whatsapp-auditoria', 'Meta\WhatsApp::whatsapp_auditoria');
$routes->match(['get', 'post'], '/whatsapp-auditoria/(:any)', 'Meta\WhatsApp::whatsapp_auditoria/$1');
$routes->match(['get', 'post'], '/whatsapp-listar-templates', 'Meta\WhatsApp::whatsapp_listar_templates');
$routes->match(['get', 'post'], '/whatsapp-criar-templates/(:any)/(:any)', 'Meta\WhatsApp::whatsapp_criar_templates/$1/$2');

//INSIGHT
$routes->match(['get', 'post'], '/insight-listar-notificacoes', 'Insight\Insight::insight_listar_notificacoes');
$routes->match(['get', 'post'], '/insight-listar-propostas/(:any)/(:any)', 'Insight\Insight::insight_listar_propostas/$1/$2');

//THEONE
$routes->match(['get','post'], '/extrairdados', 'Theone\ExtrairDados::extrair');

//AASPA
$routes->match(['get', 'post'], '/comecar/(:any)', 'Frontline\Frontline::comecar/$1');
$routes->match(['get', 'post'], '/aaspa-zapsms', 'Aaspa\Aaspa::zapsms');
$routes->match(['get', 'post'], '/aaspa-message-status/(:any)', 'Aaspa\Aaspa::message_status/$1');
$routes->match(['get', 'post'], '/aaspa-zapsms/(:any)', 'Aaspa\Aaspa::zapsms/$1');
$routes->match(['get', 'post'], '/aaspa-receptivo/(:any)/(:any)', 'Aaspa\Aaspa::receptivo/$1/$2');
$routes->match(['get', 'post'], '/aaspa-enviar-whatsapp/(:any)/(:any)', 'Aaspa\Aaspa::aaspa_enviar_whatsapp/$1/$2');
$routes->match(['get', 'post'], '/aaspa-receptivo/(:any)', 'Aaspa\Aaspa::receptivo/$1');
$routes->match(['get', 'post'], '/aaspa-receptivo/', 'Aaspa\Aaspa::receptivo');
$routes->match(['get', 'post'], '/aaspa-listar-propostas', 'Aaspa\Aaspa::listarPropostas');
$routes->match(['get', 'post'], '/argus-listar-chamadas', 'Argus\Argus::listarChamadas');
$routes->match(['get', 'post'], '/integraall-token', 'Aaspa\Integraall::integraall_token');
$routes->match(['get', 'post'], '/integraall-cep/(:any)', 'Aaspa\Integraall::cep/$1');
$routes->match(['get', 'post'], '/integraall-cpf', 'Aaspa\Integraall::cpf');
$routes->match(['get', 'post'], '/integraall-detalhes-proposta', 'Aaspa\Integraall::detalhes_proposta');
$routes->match(['get', 'post'], '/integraall-importar-propostas', 'Aaspa\Integraall::integraall_importar_propostas');
$routes->match(['get', 'post'], '/integraall-metricas-ativacoes', 'Aaspa\Integraall::integraall_metricas_ativacoes');
$routes->match(['get', 'post'], '/integraall-buscar-propostas/(:any)', 'Aaspa\Integraall::buscar_propostas/$1');
$routes->match(['get', 'post'], '/integraall-criar-proposta', 'Aaspa\Integraall::criar_proposta');
$routes->match(['get', 'post'], '/integraall-validar-cpf/(:any)', 'Aaspa\Integraall::validar_cpf/$1');
$routes->match(['get', 'post'], '/integraall-validar-tse/(:any)', 'Aaspa\Integraall::validar_tse/$1');
$routes->match(['get', 'post'], '/calculadora-login', 'Aaspa\Integraall::calculadora_login');
$routes->match(['get', 'post'], '/calculadora-qualificacao/(:any)', 'Aaspa\Integraall::calculadora_qualificacao/$1');

//ARGUS
$routes->match(['get', 'post'], '/argus-atendimento-webhook', 'Argus\Argus::argus_atendimento_webhook');
$routes->match(['get', 'post'], '/argus-tabulacao-webhook', 'Argus\Argus::argus_tabulacao_webhook');
$routes->match(['get', 'post'], '/argus-atendimento-webhook-vap', 'Argus\Argus::argus_atendimento_webhook_vap');
$routes->match(['get', 'post'], '/metricas-ligacao-operador', 'Argus\Argus::metricas_ligacao_operador');


//FRONTLINE
$routes->match(['get', 'post'], '/frontline-routing-webhook', 'Frontline\Frontline::frontline_routing_webhook');
$routes->match(['get', 'post'], '/twilio-error-webhook', 'Frontline\Frontline::twilio_error_webhook');
$routes->match(['get', 'post'], '/frontline-conversations-webhook', 'Frontline\Frontline::frontline_conversations_webhook');
$routes->match(['get', 'post'], '/frontline-pre-conversations-webhook', 'Frontline\Frontline::frontline_pre_conversations_webhook');
$routes->match(['get', 'post'], '/frontline-outgoing-conversation', 'Frontline\Frontline::frontline_outgoing_conversation');
$routes->match(['get', 'post'], '/frontline-crm-inbound', 'Frontline\Frontline::frontline_crm_inbound');
$routes->match(['get', 'post'], '/frontline-template-inbound', 'Frontline\Frontline::frontline_template_inbound');
$routes->match(['get', 'post'], '/frontline-cleanup', 'Frontline\Frontline::frontline_cleanup');

//FRONTLINE VAP
$routes->match(['get', 'post'], '/frontline-vap-routing-webhook', 'Frontline\FrontlineVap::frontline_routing_webhook');
$routes->match(['get', 'post'], '/frontline-vap-conversations-webhook', 'Frontline\FrontlineVap::frontline_conversations_webhook');
$routes->match(['get', 'post'], '/frontline-vap-pre-conversations-webhook', 'Frontline\FrontlineVap::frontline_pre_conversations_webhook');
$routes->match(['get', 'post'], '/frontline-vap-outgoing-conversation', 'Frontline\FrontlineVap::frontline_outgoing_conversation');
$routes->match(['get', 'post'], '/frontline-vap-crm-inbound', 'Frontline\FrontlineVap::frontline_crm_inbound');
$routes->match(['get', 'post'], '/frontline-vap-template-inbound', 'Frontline\FrontlineVap::frontline_template_inbound');
$routes->match(['get', 'post'], '/frontline-vap-cleanup', 'Frontline\FrontlineVap::frontline_cleanup');


//FGTS
$routes->match(['get', 'post'], '/fgts-adm-simulacao/(:any)/(:any)/(:any)', 'Fgts\Fgts::adm_simulacao/$1/$2/$3');
$routes->match(['get', 'post'], '/fgts-proposta-disponivel/(:any)/(:any)', 'Fgts\Fgts::atualizarStatusProposta/$1/$2');
$routes->match(['get', 'post'], '/fgts-operador-owner/(:any)', 'Fgts\Fgts::atualizarStatusPropostaOperador/$1');
$routes->match(['get', 'post'], '/fgts-listar-propostas', 'Fgts\Fgts::listarPropostas');
$routes->match(['get', 'post'], '/fgts-cliente-detalhes/(:any)', 'Fgts\Fgts::clienteDetalhes/$1');
$routes->match(['get', 'post'], '/indicadores-diarios', 'Fgts\Indicadores::indicadores_diarios');
$routes->match(['get', 'post'], '/indicadores-esteira', 'Fgts\Indicadores::indicadores_esteira');

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

//ADS
$routes->match(['get', 'post'], '/ad-miner', 'Ads\Ads::listarAds');
$routes->match(['get', 'post'], '/ad-miner/(:any)', 'Ads\Ads::listarAds/$1');
$routes->match(['get', 'post'], '/ads-like', 'Ads\Ads::adsLike');
$routes->match(['get', 'post'], '/ads-nicho', 'Ads\Ads::adsNicho');
$routes->match(['get', 'post'], '/ads-load', 'Ads\Ads::loadMiner');
//CHROME
$routes->match(['get', 'post'], '/ads-savead', 'Ads\Ads::savead');
$routes->match(['get', 'post'], '/ads-validatetoken', 'Ads\Ads::validatetoken');


//META
$routes->match(['get', 'post'], '/ad-manager', 'Meta\Meta::manager');
$routes->match(['get', 'post'], '/ad-action/(:any)/(:any)', 'Meta\Meta::action/$1/$2');
$routes->match(['get', 'post'], '/indicadores-vsl', 'Meta\Indicadores::indicadores_vsl');
$routes->match(['get', 'post'], '/import-data', 'Meta\Indicadores::importData');
$routes->match(['get', 'post'], '/autoStart', 'Meta\Indicadores::autoStart');
$routes->match(['get', 'post'], '/serverTime', 'Meta\Indicadores::serverTime');
$routes->match(['get', 'post'], '/ai-manager', 'Meta\Agent::aiManager');

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
