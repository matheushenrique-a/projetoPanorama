<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_argus;
use App\Models\M_bmg;
use App\Models\M_seguranca;
use App\Models\M_insight;

class Home extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $m_argus;
    protected $m_security;
    protected $m_insight;
    protected $m_bmg;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->checkSession();

        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->m_argus =  new M_argus();
        $this->m_security = new M_seguranca();
        $this->m_insight = new M_insight();
        $this->m_bmg = new M_bmg();
    }

    public function index()
    {
        $this->checkSession();
        $dados['pageTitle'] = "Home";

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

        if ($this->session->role == "SUPERVISOR" || $this->my_security->checkPermission("GERENTE")) {
            $totalMensal = $this->m_bmg->totalMensal();

            $buscarMeta = $this->m_insight->buscarMetaIndividual()['firstRow'] ?? "";
            $meta = $buscarMeta->meta ?? 0;
            $metaMensal = $buscarMeta->meta_mensal ?? 0;

            $dados['meta'] = $meta;
            $dados['metaMensal'] = $metaMensal;
            $dados['totalMensal'] = $totalMensal;

            $dados['quantidadeAssessoresIndividual'] = $this->m_insight->quantidadeEquipe($this->session->userId)['countAll'];

            if ($meta !== 0) {
                $progresso = ($totalMensal / $metaMensal) * 100;
                $progresso = round($progresso, 2);
                $dados['progressoSupervisor'] = $progresso;
            } else {
                $dados['progressoSupervisor'] = 0;
            }

            // quantidade só do cartão BMG

            $dados['metaQuantidadeMensal'] = $buscarMeta->meta_quantidade_mensal ?? 0;


            $dados['metaQuantidade'] = $buscarMeta->meta_quantidade ?? 0;
            $dados['feitoQuantidade'] = $this->m_insight->metaQuantidade();

            $dados['progressoQuantidade'] = $dados['metaQuantidade'] > 0
                ? round(($dados['feitoQuantidade'] / $dados['metaQuantidade']) * 100, 2)
                : 0;
        }


        if ($this->my_security->checkPermission("GERENTE") || $this->my_security->checkPermission("ADMIN")) {
            $buscarInfoMetas = $this->dbMasterDefault->buscarInfoMetas();

            $equipes = [];

            foreach ($buscarInfoMetas as $individual) {
                $obj = new \stdClass();

                $idSupervisor = $individual->supervisor;
                $meta = $individual->meta;
                $metaMensal = $individual->meta_mensal;
                $totalMensal = $this->m_bmg->totalMensal($idSupervisor);
                $quantidadeAssessor = $this->m_insight->quantidadeEquipe($idSupervisor)['countAll'];

                $progresso = ($totalMensal / $metaMensal) * 100;
                $progresso = round($progresso, 2);

                $obj->nome = $individual->nome;
                $obj->supervisor = $idSupervisor;
                $obj->meta = $meta;
                $obj->metaMensal = $metaMensal;
                $obj->totalMensal = $totalMensal;
                $obj->progresso = $progresso;
                $obj->quantidadeAssessor = $quantidadeAssessor;

                $equipes[] = $obj;
            }

            $dados['equipesGerente'] = $equipes;
        }

        $dados['labelsEquipe'] = $labelsEquipe;
        $dados['dadosEquipe'] = $valoresEquipe;

        $dados['ranking'] = $this->m_bmg->tabelaAssessores();

        if ($this->session->role == "OPERADOR") {
            // if ($this->session->report_to !== "164979") {
            // }
            $dados['progresso'] = $this->m_bmg->barraProgressoAssessor();
            $dados['metaEquipe'] = $this->m_insight->buscarMetaSuaEquipe()['firstRow']->meta ?? "";

            $assessor = $this->session->nickname;
            $statusSelecionado = $this->request->getGet('status') ?? 'all';

            $ultimasPropostasBMG = $this->m_bmg->ultimasPropostasBMG($assessor, $statusSelecionado, 10);

            $dados['contadores'] = $this->m_bmg->contarPropostasPorStatus($assessor);

            $dados += [
                'ultimasPropostasBMG' => $ultimasPropostasBMG,
                'statusSelecionado' => $statusSelecionado
            ];
        }

        $dados['nickname'] = $this->session->nickname;

        $tabulacoesSucesso = $this->m_argus->tabulacoesSucesso();
        $dados['tabulacoesSucesso'] = $tabulacoesSucesso;

        $mensalPropostasBMG = $this->m_bmg->mensalPropostasBMG();
        $dados['mensalPropostasBMG'] = $mensalPropostasBMG;

        $countPropostasBMG = $this->m_bmg->countPropostasBMG();
        $dados['countPropostasBMG'] = $countPropostasBMG;

        // atualização de propostas PANORAMA
        // $tempoMinutos = 5;

        // $conf = $this->dbMasterDefault->select('configuracoes', ['id' => 1]);

        // $executar = true;
        // if ($conf['existRecord']) {
        //     $ultimaExecucao = strtotime($conf['firstRow']->ultima_atualizacao_propostas);
        //     $agora = time();

        //     if (($agora - $ultimaExecucao) < ($tempoMinutos * 60)) {
        //         $executar = false;
        //     }
        // }

        // if ($executar) {
        //     $this->m_insight->atualizar_propostas();

        //     if ($conf['existRecord']) {
        //         $this->dbMasterDefault->update(
        //             'configuracoes',
        //             ['ultima_atualizacao_propostas' => date('Y-m-d H:i:s')],
        //             ['id' => 1]
        //         );
        //     } else {
        //         $this->dbMasterDefault->insert(
        //             'configuracoes',
        //             ['id' => 1, 'ultima_atualizacao_propostas' => date('Y-m-d H:i:s')]
        //         );
        //     }
        // }

        if ($this->session->role == "AUDITOR" || $this->session->userId == "165001" || $this->m_security->checkPermission("ADMIN")) {
            $ultimasPropostasAuditor = $this->m_bmg->ultimasPropostasAuditor(8);

            $ultimasPropostasAuditorTotal = $this->m_bmg->ultimasPropostasAuditorTotal(8);

            $dados['progressoAuditoria'] = $this->m_insight->quantidadePorAuditor();

            $dados['ultimasPropostasAuditor'] = $ultimasPropostasAuditor;
            $dados['ultimasPropostasAuditorTotal'] = $ultimasPropostasAuditorTotal;
        }


        $dados['profile_image'] = $this->session->profile_image;

        $userId = $this->session->userId;

        // $notificacoes = $this->dbMasterDefault->listarNotificacoes($userId);

        // // $notificacoes já é o array que você quer
        // $dados['notificacoes'] = $notificacoes;

        return $this->loadpage('headers/home-default', $dados);
    }
}
