<?php

namespace App\Controllers\Bradesco;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_twilio;
use Config\Services;
use App\Models\M_integraall;
use App\Models\M_argus;
use App\Models\M_seguranca;
use App\Models\M_insight;
use App\Models\M_bradesco;

class Bradesco extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $m_argus;
    protected $m_security;
    protected $m_insight;
    protected $m_bradesco;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->checkSession();

        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
        $this->m_argus =  new M_argus();
        $this->m_security = new M_seguranca();
        $this->m_insight = new M_insight();
        $this->m_bradesco = new M_bradesco();
    }

    public function teste(){

        $m_bradesco->salvarDados(['nome' => 'Teste', 'idade' => 30]);
        echo "Bradesco Controller Teste Method";

        $data['item'] = "Produto";

        return $this->loadpage('bradesco/receptivo', $data);


    }
    
}
