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

        $dados['labelsEquipe'] = $labelsEquipe;
        $dados['dadosEquipe'] = $valoresEquipe;

        $dados['ranking'] = $this->m_bmg->tabelaAssessores();

        $dados['rankingIndividual'] = $this->m_bmg->tabelaAssessoresIndividual();

        $dados['progresso'] = $this->m_bmg->barraProgressoAssessor();
        $dados['nickname'] = $this->session->nickname;

        $htmlNotificacoes = $this->m_insight->gerarTimelineNotificacoes();
        $ultimasLigacoes = $this->m_argus->ultimasLigacoes(6);
        $countLigacoes = $this->m_argus->countLigacoes();
        $countPropostas = $this->m_integraall->countPropostas();
        $ultimasPropostas = $this->m_integraall->ultimasPropostas(8);

        $graficoAvebacoes = $this->m_integraall->graficoAvebacoes();
        $ranking_ativacoes = $this->m_integraall->ranking_ativacoes();

        $tabulacoesSucesso = $this->m_argus->tabulacoesSucesso();
        $dados['tabulacoesSucesso'] = $tabulacoesSucesso;

        $ultimasPropostasBMG = $this->m_bmg->ultimasPropostasBMG(6);
        $dados['ultimasPropostasBMG'] = $ultimasPropostasBMG;

        $countPropostasBMG = $this->m_bmg->countPropostasBMG();

        // ATUALIZAÇÃO DE PROPOSTAS
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

        $dados['countPropostasBMG'] = $countPropostasBMG;

        $dados['ranking_ativacoes'] = $ranking_ativacoes;
        $dados['graficoAvebacoes'] = $graficoAvebacoes;
        $dados['htmlNotificacoes'] = $htmlNotificacoes;
        $dados['ultimasLigacoes'] = $ultimasLigacoes;
        $dados['session'] = $this->session;
        $dados['ultimasPropostas'] = $ultimasPropostas;
        $dados['countLigacoes'] = $countLigacoes;
        $dados['countPropostas'] = $countPropostas;
        return $this->loadpage('headers/home-default', $dados);
    }
}
