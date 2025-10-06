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

        // Resultados do usuário individual
        $resultados = $this->m_bmg->countPropostasPorDia();

        $labels = [];
        $valores = [];
        foreach ($resultados as $row) {
            $labels[] = date('d/m', strtotime($row->data));
            $valores[] = (int)$row->total;
        }
        $dados['labels'] = $labels;
        $dados['dados'] = $valores;

        $resultadosEquipe = $this->m_bmg->countPropostasPorDiaEquipe();

        $dataEquipe = [
            'Aprovada' => [],
            'Análise'  => [],
            'Pendente' => []
        ];

        // Indexar os dados por Y-m-d para facilitar comparação
        foreach ($resultadosEquipe as $row) {
            $status = $row->status;
            $dataEquipe[$status][$row->data] = (int)$row->total;
        }

        // Criar labels para últimos 15 dias, formato d/m para exibição
        $labelsTeam = [];
        $datasetsTeam = [];
        $statuses = ['Aprovada', 'Análise', 'Pendente'];
        $colors = [
            'Aprovada' => 'rgba(49, 219, 114, 0.6)',
            'Análise'  => 'rgba(119, 56, 219, 0.6)',
            'Pendente' => 'rgba(235, 238, 61, 0.6)'
        ];

        for ($i = 10; $i >= 0; $i--) {
            $dateYmd = date('Y-m-d', strtotime("-$i days")); // chave do dataEquipe
            $labelsTeam[] = date('d/m', strtotime("-$i days")); // label exibido no gráfico
        }

        // Montar datasets
        foreach ($statuses as $status) {
            $dataStatus = [];
            for ($i = 10; $i >= 0; $i--) {
                $dateKey = date('Y-m-d', strtotime("-$i days"));
                $dataStatus[] = $dataEquipe[$status][$dateKey] ?? 0;
            }
            $datasetsTeam[] = [
                'label' => $status,
                'data' => $dataStatus,
                'backgroundColor' => $colors[$status],
                'borderColor' => str_replace('0.6', '1', $colors[$status]),
                'borderWidth' => 1,
                'borderRadius' => 4,
                'barThickness' => 30
            ];
        }

        $dados['labelsTeam'] = $labelsTeam;
        $dados['datasetsTeam'] = $datasetsTeam;


        // Supervisor / Gerente
        if ($this->session->role == "SUPERVISOR" || $this->my_security->checkPermission("GERENTE")) {
            $totalMensal = $this->m_bmg->totalMensal();

            $buscarMeta = $this->m_insight->buscarMetaIndividual()['firstRow'] ?? null;
            $meta = $buscarMeta->meta ?? 0;
            $metaMensal = $buscarMeta->meta_mensal ?? 0;

            $dados['meta'] = $meta;
            $dados['metaMensal'] = $metaMensal;
            $dados['totalMensal'] = $totalMensal;

            $dados['quantidadeAssessoresIndividual'] = $this->m_insight->quantidadeEquipe($this->session->userId)['countAll'];

            $dados['progressoSupervisor'] = ($metaMensal > 0) ? round(($totalMensal / $metaMensal) * 100, 2) : 0;

            $dados['metaQuantidadeMensal'] = $buscarMeta->meta_quantidade_mensal ?? 0;
            $dados['metaQuantidade'] = $buscarMeta->meta_quantidade ?? 0;
            $dados['feitoQuantidade'] = $this->m_insight->metaQuantidade();
            $dados['progressoQuantidade'] = ($dados['metaQuantidade'] > 0)
                ? round(($dados['feitoQuantidade'] / $dados['metaQuantidade']) * 100, 2)
                : 0;
        }

        // Gerente / Admin
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
                $progresso = ($metaMensal > 0) ? round(($totalMensal / $metaMensal) * 100, 2) : 0;

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

        $dados['ranking'] = $this->m_bmg->tabelaAssessores();
        $dados['nickname'] = $this->session->nickname;
        $dados['profile_image'] = $this->session->profile_image;

        $userId = $this->session->userId;
        $dados['notificacoes'] = $this->dbMasterDefault->listarNotificacoes($userId);

        if ($this->session->role == "OPERADOR") {
            if ($this->session->report_to == "164979") {
                $dados['previsãoComissaoGBOEX'] = $this->m_insight->previsãoComissaoGBOEX($this->session->userId);
            }

            $dados['progresso'] = $this->m_bmg->barraProgressoAssessor();
            $dados['metaEquipe'] = $this->m_insight->buscarMetaSuaEquipe()['firstRow']->meta ?? "";

            $assessor = $this->session->nickname;
            $statusSelecionado = $this->request->getGet('status') ?? 'all';
            $dados['ultimasPropostasBMG'] = $this->m_bmg->ultimasPropostasBMG($assessor, $statusSelecionado, 10);
            $dados['contadores'] = $this->m_bmg->contarPropostasPorStatus($assessor);
            $dados['statusSelecionado'] = $statusSelecionado;
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
            $ultimasPropostasAuditor = $this->m_bmg->ultimasPropostasAuditor(10);

            $ultimasPropostasAuditorTotal = $this->m_bmg->ultimasPropostasAuditorTotal(10);

            $dados['progressoAuditoria'] = $this->m_insight->quantidadePorAuditor();
        }

        return $this->loadpage('headers/home-default', $dados);
    }
}
