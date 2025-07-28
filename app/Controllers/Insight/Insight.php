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

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
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



    public function load_notifications()
    {
        $userId = $this->session->userId;


        echo "$userId - 13:32:22 - Breakpoint 9";
        exit;                    //<-------DEBUG


    }

    //http://localhost/InsightSuite/public/insight-listar-notificacoes
    public function insight_listar_notificacoes()
    {
        $dados['pageTitle'] = 'Listar Notificações';

        $htmlNotificacoes = $this->m_insight->gerarTimelineNotificacoes(200);
        $dados['htmlNotificacoes'] = $htmlNotificacoes;
        return $this->loadpage('insight/listar_notificacoes', $dados);
    }

    public function insight_listar_propostas()
    {
        $dados['pageTitle'] = 'Propostas';
        $buscarProp = $this->getpost('buscarProp');

        if (!empty($buscarProp)) {
            helper('cookie');
            $cpf = $this->getpost('txtCPF', false);
            $celular = $this->getpost('celular', false);
            $nome = $this->getpost('txtNome', false);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', false);
            $paginas = $this->getpost('paginas', false);

            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('statusPropostaFiltro', $statusPropostaFiltro);
            Services::response()->setCookie('paginas', $paginas);
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', true);
            $paginas = $this->getpost('paginas', true);
        }

        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];

        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        if (!empty($celular)) $likeCheck['telefone'] = $celular;
        if (!empty($nome)) $likeCheck['nome'] = $nome;

        $whereCheck["assessor"] = $this->session->nickname;

        $likeCheck = array("likeCheck" => $likeCheck);

        $paginas = (empty($paginas)  ? 10 : $paginas);
        $this->dbMasterDefault->setLimit($paginas);
        $this->dbMasterDefault->setOrderBy(array('idquid_propostas', 'DESC'));
        $propostas = $this->dbMasterDefault->select('quid_propostas', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

        $dados['indicadores'] = $this->indicadores();

        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['paginas'] = $paginas;
        $dados['celular'] = $celular;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        $dados['session'] = $this->session;

        return $this->loadpage('insight/insight_listar_propostas', $dados);
    }

    public function indicadores()
    {
        $indicadores = [];
        $nickname = $this->session->nickname;

        $indicadores['propostas_hoje'] = $this->dbMaster->runQuery(
            "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) = CURDATE() 
           AND assessor = '{$nickname}'"
        )['firstRow']->total;

        $indicadores['propostas_ontem'] = $this->dbMaster->runQuery(
            "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
           AND assessor = '{$nickname}'"
        )['firstRow']->total;

        $indicadores['propostas_7dias'] = $this->dbMaster->runQuery(
            "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() 
           AND assessor = '{$nickname}'"
        )['firstRow']->total;

        $indicadores['propostas_30dias'] = $this->dbMaster->runQuery(
            "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() 
           AND assessor = '{$nickname}'"
        )['firstRow']->total;

        return $indicadores;
    }
}
