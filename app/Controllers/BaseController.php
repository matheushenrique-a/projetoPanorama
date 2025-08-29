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
use App\Models\M_seguranca;

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
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->dbMaster = new dbMaster($this->dbProfile); // create an instance of Library class
        $this->dbMaster->runQueryGeneric("SET time_zone='-3:00'");
        $this->my_session = session();
        $this->my_security = new M_seguranca();
    }

    public function setDB($dbProfile)
    {
        $this->dbProfile = $dbProfile;
    }

    public function loadpage($page, $dados)
    {
        $globals = ["my_security" => $this->my_security];

        return view('headers/home-header', $dados + $globals)
            . view($page, $dados)
            . view('headers/home-footer', $dados);
    }

    public function loadSinglePage($page, $dados)
    {

        return view($page, $dados);
    }

    function checkSession()
    {

        if (!$this->my_session->has('userId')) {
            helper('cookie');
            $email = get_cookie('insight');

            if (!empty($email)) {
                $this->my_security->auth($email);
            } else {
                redirectHelper('sign-in');
            }
        }
    }

    function getpost($valor, $cookie_persist = false)
    {

        $aux = "";

        if (array_key_exists($valor, $_POST)) {
            $aux = trim($_POST[$valor]);
        } else {
            $aux =   '';
        }

        if ($aux == "") {
            if (array_key_exists($valor, $_GET)) {
                $aux = trim($_GET[$valor]);
            } else {
                $aux =   '';
            }
        }

        //Depois tenta pegar via Cookie
        if ($cookie_persist) {
            helper('cookie');
            if ($aux == "") {
                $aux = Services::request()->getCookie($valor);
            } else {
                Services::response()->setCookie($valor, $aux);
            }
        }

        return htmlspecialchars((is_null($aux)  ? '' : $aux), ENT_QUOTES);
    }

    public function getPostArray($valor, $cookie_persist = false)
    {
        $aux = '';

        if (array_key_exists($valor, $_POST)) {
            $aux = $_POST[$valor];
            if (!is_array($aux)) {
                $aux = trim($aux);
            }
        }

        if ($aux === "") {
            if (array_key_exists($valor, $_GET)) {
                $aux = $_GET[$valor];
                if (!is_array($aux)) {
                    $aux = trim($aux);
                }
            } else {
                $aux = '';
            }
        }

        if ($cookie_persist) {
            helper('cookie');
            if ($aux == "") {
                $aux = Services::request()->getCookie($valor);
            } else {
                Services::response()->setCookie($valor, $aux);
            }
        }

        return $aux;
    }
}
