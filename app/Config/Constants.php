<?php

/*
 | --------------------------------------------------------------------
 | PRA VOCE CONFIGURATION
 | --------------------------------------------------------------------
 */

define('IsProduction', false);
define('AppName', "Insight Suite");

define ('shortURL', 'https://pravc.io/');

define ('API_Integraall', 'https://api.integraall.com/api/');
define ('API_User', 'fernando.dantas');
define ('API_Password', 'P@drao123');
define ('API_Revendedor', 144); //quid
define ('API_Produto', 6); //quid

//SEGURO BMG
define('BMG_WSDL', 'https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl');
define('BMG_SEGURO_LOGIN', 'robo.55009');
define('BMG_SEGURO_SENHA', 'Quid@robo102030');
define('BMG_SEGURO_LOGIN_CONSIG', 'DANTAS.PRAVOCE');
define('BMG_SEGURO_SENHA_CONSIG', 'GtbP!8kgDuL@');
define('BMG_ENTIDADE', '1581');
define('BMG_LOJA_QUID', '54577'); //Unity
define('BMG_CODIGO_PRODUTO_PAP', 1007);
define('BMG_CODIGO_PRODUTO_MED', 54);
define('BMG_CODIGO_PRODUTO_PRESTAMISTA', 5);
define('BMG_CODIGO_PRODUTO_VIDA', 73);


//calculadora
define ('API_Calculadora', 'https://api2.calculadoraconsignado.com.br/api/');

//TSE API
define ('API_TSE', "http://localhost:3002/consultar-cpf");
define ('URL_TSE', "https://www.tse.jus.br/servicos-eleitorais/autoatendimento-eleitoral#/atendimento-eleitor/consultar-situacao-titulo-eleitor");
//define ('API_TSE', "https://0cd0-177-73-197-2.ngrok-free.app/consultar-cpf");

//WHATSAPP CLOUD API - TELEFONE TESTE META APP WPP CONTA UNITY
// define ('META_CLOUD_PHONE_ID', "631093443420913"); //phone number id do Sender WhatsApp = +1 555 642 0620 - Pegar em developers Whatsapp -> Configuração API - Id Numero Telefone
// define ('META_CLOUD_ASSET_ID', "1180147207074114"); //Asset_id pela URL do Gerenciador WhatsApp. Usado para listar templates apenas
// define ('META_CLOUD_API_RAW', "https://graph.facebook.com/v22.0/"); 
// define ('META_CLOUD_API', META_CLOUD_API_RAW . META_CLOUD_PHONE_ID . "/messages");
// define('META_TOKEN_WHATSAPP', "EAAaYwsrh9DcBO5aLs0Paf3roaPmChzJ4ZC0e5ZAk5OG25cfx02bZBxZBU5YP98TXSoqRVAfQGwAkZBZBZCcVKhVw63oTjIY3GmVWoSZB8tBK9P7ZAslpEVfCf3zbTB170ILZCZAkIowVbmeFqUomknHZBkyBk8cpFLZBd57sYWOEU0bJnKrxjOUeGhQZDZD"); //token convertido

//WHATSAPP CLOUD API
define ('META_CLOUD_PHONE_ID', "568724566335121"); //phone number id do Sender WhatsApp = +55 11 5028 0207
define ('META_CLOUD_ASSET_ID', "1417572616042066"); //Asset_id pela URL do Gerenciador WhatsApp. Conta Unity fora da Twilio
define ('META_CLOUD_API_RAW', "https://graph.facebook.com/v22.0/"); 
define ('META_CLOUD_API', META_CLOUD_API_RAW . META_CLOUD_PHONE_ID . "/messages");
define('META_TOKEN_WHATSAPP', "EAAaYwsrh9DcBOzIFlpKZB7qCqrqzymNsvfHqzF0SBsKVaRl2BEAUkuEHwtOEYKTB6sII60sa0UwSQW70LKDxJb4PnvOrYSibLZBqyx6xAiKtMJChbgsr70NVHYSZBSU7cAOaEydaAYZAjMHXZCb4K5Twu0N9U9tZAc7ZBhEzuB0IkAXKkmR9wZDZD"); //token convertido

define('PATH_SAVE_MEDIA', "/Applications/XAMPP/xamppfiles/htdocs/InsightSuite/public/assets/media/whatsapp/");

//FACEBOOK ADS
define('META_GRAPH_API', "https://graph.facebook.com/v20.0/");
//APP ADS TOKEN
define('META_TOKEN', "EAAMqjXZAxYiUBO2QG3wDFbHWvnTfYyj0zBVLbWrdEJ5DvwTw2RgypppuQKtZAZAMZARgOadqCREDI3rcJdafyrCyi9CZAykLz1mOE4dDZBEz00CSH1YxBFfNFeivucQ6RJLvTm01BZA0gdeC9gnsph7suaUHJGBxuNZBpMTD9yAFB1XlgqaXqGqlZC7O4");


//SMS Account - US SMS ONLY
define('TWILIO_ACCOUNT_SID_SMS','ACbec7bd36bb5c1d809c7fd76c0e06bb5c');
define('TWILIO_AUTH_TOKEN_SMS','f9b35782bcc14ea689826783314dab9e');
define('TWILIO_MESSAGE_SERVICES','MGe5bf2163a347b3c4f98c248e4459529f'); //Messaging Services // Servico Mensagem FRONT-LINE-QUID // CONTA QUID BRASIL

//WHATSAPP Account - BRASIL
define('TWILIO_ACCOUNT_SID','ACd07f72009069ead82dcf03497b6cb3b1');
define('TWILIO_AUTH_TOKEN','29e809986eeca0bc9d85716fb8e17596');
define('TWILIO_MEDIA_PATH','https://insightsuite.pravoce.io/assets/pravoce/media/whatsapp/');
define('fromWhatsApp','551150280701'); //OPCAO 02
define('fromWhatsAppSMS','12318290307'); //OPCAO 02
define('templateAberturaAASPA',"HXebcd9997da69e138eaef4d6825939012"); //OPCAO 02
define('fromWhatsAppVap','551150280701'); //OPCAO 02


//DEFINE NOTIFICAÇÕES ATIVAS
define('smsMsg', false);
define('emailMsg', false);
define('whatAppMsg', true);
define('telegramAlerts', true);


//CHAT_GPT
define('API_KEY_CHATGPT','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');
define('API_URL_CHATGPT', 'https://api.openai.com/v1/chat/completions');
define('API_URL_CHATGPT_TTS', 'https://api.openai.com/v1/audio/speech');
define('API_ORG_CHATGPT', 'org-LX3hOOlJya2XI2D3JVcgmS91');

//AMBEC
define('PATH_SAVE_AMBEC', "/Applications/XAMPP/xamppfiles/htdocs/InsightSuite/public/assets/media/ambec/");

//ELEVENLABS
define('ELEVENLABS_URL', "https://api.elevenlabs.io");
define('ELEVENLABS_KEY', "f667e9cb53d20abfbe878eb1d7bd0229");

define('facta_taxa', 2.04);
define('facta_tabela', 40797);
define('facta_tabela_light', 48291); //fgts plus rb
define('facta_taxa_ligjt', 1.80);

if (IsProduction){
    define ('assetfolder', '/');
    define ('rootURL', 'https://insightsuite.pravoce.io/');
    define ('FGTSUrl', '/');
    define ('ConsorcioUrl', '/');
} else {
    define ('assetfolder', '/InsightSuite/public/');
    define ('rootURL', 'http://localhost/InsightSuite/public/');
    //define ('rootURL', 'https://99fe-177-73-197-2.ngrok-free.app/InsightSuite/public/');
    define ('urlInstitucional', '/');
    define ('FGTSUrl', 'http://localhost/fintech/');
    define ('ConsorcioUrl', 'http://localhost/fintech/');
}

//TELEGRAM NOTIFICAÇÕES PRA VOCE (GRUPO INTERNO DE ALERTAS)
define ('telegramToken', '5947884925:AAG35Bq2edQTVd3Uxw5TIzPmjGGk71xr2tI'); //webhook https://www.beppig.com/index.php/telegram/webhook",
define ('telegramPraVoceGroup', '-481159474');
define ('telegramPraVoceDiretoria', '-992723690');
define ('telegramBurnApp', '-4518699236');
define ('telegramPraVoceDigital', '-4003072193');
define ('telegramPraVoceGroupLogErrors', '-587867421');
define ('telegramQuid', '-4679812610');


//Na tela de listar propostas carrega ou nao os valores (pesado)
define('exibir_valores_proposta', false);


/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);
