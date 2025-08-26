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
use App\Models\M_bmg;
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
    protected $m_bmg;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
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
        $this->m_bmg = new M_bmg();
    }

    public function index()
    {
        $this->checkSession();
        $dados['pageTitle'] = "Insight Home";

        $dados['report_to'] = $this->session->report_to;
        $dados['role'] = $this->session->role;
        $dados['session'] = $this->session;

        $resultados = $this->m_bmg->countPropostasPorDia();
        $resultadosEquipe = $this->m_bmg->countPropostasPorDiaEquipe();

        $labels = [];
        $valores = [];

        foreach ($resultados as $row) {
            $labels[] = date('d/m', strtotime($row->data));
            $valores[] = (int)$row->total;
        }

        $labelsEquipe = [];
        $valoresEquipe = [];

        foreach ($resultadosEquipe as $row) {
            $labelsEquipe[] = date('d/m', strtotime($row->data));
            $valoresEquipe[] = (int)$row->total;
        }

        $dados['labels'] = $labels;
        $dados['dados'] = $valores;

        if ($this->session->role == "SUPERVISOR" || $this->session->role == "AUDITOR") {
            $usuarioSupervisor = $this->session->userId;
            $totalMensal = $this->m_bmg->totalMensal();

            if ($usuarioSupervisor == "165004") { //paula
                $meta = 230000;
            } else if ($usuarioSupervisor == "165006") { //jessica
                $meta = 200000;
            } else if ($usuarioSupervisor == "165005") { //ana karla
                $meta = 200000;
            } else {
                $meta = 50000;
            }

            $dados['meta'] = $meta;
            $dados['totalMensal'] = $totalMensal;

            $progresso = ($totalMensal / $meta) * 100;
            $progresso = round($progresso, 2);

            $dados['progressoSupervisor'] = $progresso;

            $dados['metaManualSupervisor'] = $this->m_insight->buscarMetaIndividual()['firstRow']->meta ?? "";
        }


        // USUARIO JESSICA
        if ($this->session->userId == "165058") {
            $metaJessica = 588000;
            $metaPaula = 462000;
            $metaAnaKarla = 630000;

            $dados['metaJessica'] = $metaJessica;
            $dados['metaPaula'] = $metaPaula;
            $dados['metaAnaKarla'] = $metaAnaKarla;

            $totalJessica = $this->m_bmg->totalMensal('165006');
            $totalPaula = $this->m_bmg->totalMensal('165004');
            $totalAnaKarla = $this->m_bmg->totalMensal('165005');

            $dados['totalJessica'] = $totalJessica;
            $dados['totalPaula'] = $totalPaula;
            $dados['totalAnaKarla'] = $totalAnaKarla;

            $dados['totalMensalGerente'] = $this->m_bmg->totalMensalGerente();

            $progressoPaula = ($totalPaula / $metaPaula) * 100;
            $progressoPaula = round($progressoPaula, 2);

            $dados['progressoPaula'] = $progressoPaula;

            $progressoJessica = ($totalJessica / $metaJessica) * 100;
            $progressoJessica = round($progressoJessica, 2);

            $dados['progressoJessica'] = $progressoJessica;

            $progressoAnaKarla = ($totalAnaKarla / $metaAnaKarla) * 100;
            $progressoAnaKarla = round($progressoAnaKarla, 2);

            $dados['progressoAnaKarla'] = $progressoAnaKarla;
        }

        $dados['labelsEquipe'] = $labelsEquipe;
        $dados['dadosEquipe'] = $valoresEquipe;

        $dados['ranking'] = $this->m_bmg->tabelaAssessores();

        if ($this->session->role == "OPERADOR") {
            if ($this->session->report_to !== "164979") {
                $dados['progresso'] = $this->m_bmg->barraProgressoAssessor();
            }
            $dados['metaEquipe'] = $this->m_insight->buscarMetaSuaEquipe()['firstRow']->meta ?? "";
        }

        $dados['nickname'] = $this->session->nickname;

        $tabulacoesSucesso = $this->m_argus->tabulacoesSucesso();
        $dados['tabulacoesSucesso'] = $tabulacoesSucesso;

        $ultimasPropostasBMG = $this->m_bmg->ultimasPropostasBMG(10);
        $dados['ultimasPropostasBMG'] = $ultimasPropostasBMG;

        $countPropostasBMG = $this->m_bmg->countPropostasBMG();
        $dados['countPropostasBMG'] = $countPropostasBMG;


        // atualização de propostas PANORAMA
        $tempoMinutos = 5;

        $conf = $this->dbMasterDefault->select('configuracoes', ['id' => 1]);

        $executar = true;
        if ($conf['existRecord']) {
            $ultimaExecucao = strtotime($conf['firstRow']->ultima_atualizacao_propostas);
            $agora = time();

            if (($agora - $ultimaExecucao) < ($tempoMinutos * 60)) {
                $executar = false;
            }
        }

        if ($executar) {
            $this->m_insight->atualizar_propostas();

            if ($conf['existRecord']) {
                $this->dbMasterDefault->update(
                    'configuracoes',
                    ['ultima_atualizacao_propostas' => date('Y-m-d H:i:s')],
                    ['id' => 1]
                );
            } else {
                $this->dbMasterDefault->insert(
                    'configuracoes',
                    ['id' => 1, 'ultima_atualizacao_propostas' => date('Y-m-d H:i:s')]
                );
            }
        }

        $ultimasPropostasAuditor = $this->m_bmg->ultimasPropostasAuditor(8);

        $dados['ultimasPropostasAuditor'] = $ultimasPropostasAuditor;

        // $this->m_insight->exportarDbCsv();

        return $this->loadpage('headers/home-default', $dados);
    }
}
