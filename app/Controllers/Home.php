<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_twilio;
use Config\Services;
use App\Models\M_integraall;
use App\Models\M_argus;
use App\Models\M_seguranca;
use App\Models\M_insight;

class Home extends BaseController
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

        //nesse caso o dbMaster vai apontar para o banco FGTS

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

    public function index()
    {
        $this->checkSession();
        $dados['pageTitle'] = "Simplificando sua vida financeira";
        
        $htmlNotificacoes = $this->m_insight->gerarTimelineNotificacoes();
        $ultimasLigacoes = $this->m_argus->ultimasLigacoes(7);
        $ultimasPropostas = $this->m_integraall->ultimasPropostas(6);

        $dados['htmlNotificacoes'] = $htmlNotificacoes;
        $dados['ultimasLigacoes'] = $ultimasLigacoes;
        $dados['ultimasPropostas'] = $ultimasPropostas;
        return $this->loadpage('headers/home-default', $dados);
    }

}
