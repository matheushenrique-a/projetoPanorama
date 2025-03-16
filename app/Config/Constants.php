<?php

/*
 | --------------------------------------------------------------------
 | PRA VOCE CONFIGURATION
 | --------------------------------------------------------------------
 */

define('IsProduction', false);
define('AppName', "Grupo QUID");

define ('shortURL', 'https://pravc.io/');

//SMS Account - US SMS ONLY
define('TWILIO_ACCOUNT_SID_SMS','ACbec7bd36bb5c1d809c7fd76c0e06bb5c');
define('TWILIO_AUTH_TOKEN_SMS','f9b35782bcc14ea689826783314dab9e');

//WHATSAPP Account - BRASIL
define('TWILIO_ACCOUNT_SID','ACd07f72009069ead82dcf03497b6cb3b1');
define('TWILIO_AUTH_TOKEN','29e809986eeca0bc9d85716fb8e17596');
define('TWILIO_MEDIA_PATH','https://insightsuite.pravoce.io/assets/pravoce/media/whatsapp/');
define('fromWhatsApp','551140402158'); //OPCAO 02
define('fromWhatsAppVap','551140402155'); //OPCAO 02


//DEFINE NOTIFICAÇÕES ATIVAS
define('smsMsg', false);
define('emailMsg', false);
define('whatAppMsg', true);
define('telegramAlerts', true);


//FACEBOOK ADS
define('META_GRAPH_API', "https://graph.facebook.com/v20.0/");
define('META_TOKEN', "EAAMqjXZAxYiUBOxXAUzj9qYwNGRWDQKGdpMAneTRZBK65XDTAHc2hyzZC9mUMk2yWYM66yoDSQZCopNmXSzQmlxNSgy6YYf0yVt8Qkv9PYenDqZBFmjCUREXOU9E4Wxz2MGGbqhdqgye3AEcqnyKkwHFJsPVDK9NhKHRlg657SGvZAO25Y7DfTCA2ZA");

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
    define ('rootURL', 'https://a613-2804-1b3-6149-9c04-d1cc-cd1c-6041-2e1c.ngrok-free.app/InsightSuite/public/');
    define ('FGTSUrl', '/');
    define ('ConsorcioUrl', '/');
} else {
    define ('assetfolder', '/InsightSuite/public/');
    define ('rootURL', 'https://insightsuite.pravoce.io/');
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
