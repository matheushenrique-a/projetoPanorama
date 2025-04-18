<?php

namespace App\Controllers\Insight;
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
use App\Models\M_insight;
use App\Models\M_seguranca;

class Insight extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $m_integraall;
    protected $m_argus;
    protected $m_security;
    protected $m_insight;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
        $this->m_integraall =  new M_integraall();
        $this->m_argus =  new M_argus();
        $this->m_security = new M_seguranca();
        $this->m_insight = new M_insight();
    }



    public function load_notifications(){
        $userId = $this->session->userId;

        
        echo "$userId - 13:32:22 - Breakpoint 9"; exit;					//<-------DEBUG
        

    }

    //http://localhost/InsightSuite/public/insight-listar-notificacoes
    public function insight_listar_notificacoes(){
        $dados['pageTitle'] = 'Listar Notificações';
        
        $htmlNotificacoes = $this->m_insight->gerarTimelineNotificacoes(200);
        $dados['htmlNotificacoes'] = $htmlNotificacoes;
        return $this->loadpage('insight/listar_notificacoes', $dados);
    }


    
    
}
