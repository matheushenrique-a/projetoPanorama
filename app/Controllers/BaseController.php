<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use Config\Services;
use App\Models\m_telegram;
use App\Models\M_seguranca;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $dbMaster;
    protected $my_session;
    protected $my_security;

    protected $dbProfile = null; // usa conexão padrão no Config/Database.php
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ["hUtil", "hMetronic"];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // $DBConfig = new \Config\Database;
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->dbMaster = new dbMaster($this->dbProfile); // create an instance of Library class
        $this->dbMaster->runQueryGeneric("SET time_zone='-3:00'");
        $this->my_session = session();
        $this->my_security = new M_seguranca();
    }

    //permite escolher uma configuração de banco diferente no arquivo Confi/Database
    public function setDB($dbProfile){
        $this->dbProfile = $dbProfile;
        //echo "xx" . $this->dbProfile;exit;
	}

    public function loadpageads($page, $dados){
        $globals = ["my_security" => $this->my_security];
        
        return view('ads/home-header', $dados + $globals)
            . view($page, $dados)
            . view('ads/home-footer', $dados);
	}

	public function loadpage($page, $dados){
        $globals = ["my_security" => $this->my_security];
        
        return view('headers/home-header', $dados + $globals)
            . view($page, $dados)
            . view('headers/home-footer', $dados);
	}

	public function loadSinglePage($page, $dados){
        
        return view($page, $dados);
	}    

    function checkSession(){

        if (!$this->my_session->has('userId')){
           //echo "09:52:56 - <h3>Dump 49</h3> <br><br>" . var_dump(!$this->my_session->has('userId')); exit;					//<-------DEBUG
           redirectHelper('sign-in');
        }        
    }
    function getpost($valor, $cookie_persist = false) {
	   
		$aux = "";

		if (array_key_exists  ( $valor  , $_POST)) {
			$aux = trim($_POST[$valor]);
		} else {
			$aux =   '';
		}

		if ($aux=="") {
			if (array_key_exists  ( $valor  , $_GET)) {
                $aux = trim($_GET[$valor]);
			} else {
				$aux =   '';
			}
		}

		//Depois tenta pegar via Cookie
		if ($cookie_persist) {
            helper('cookie');
			if ($aux=="") {
                $aux = Services::request()->getCookie($valor);	
			} else {
                Services::response()->setCookie($valor, $aux);
			}
		}        
        		
		return htmlspecialchars($aux, ENT_QUOTES);
	}
}
