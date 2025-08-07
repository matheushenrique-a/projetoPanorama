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
use App\Models\M_bmg;

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
    protected $m_bmg;

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
        $this->m_bmg = new M_bmg();
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

    public function insight_listar_propostas($idProposta, $action)
    {
        $dados['pageTitle'] = 'Propostas';
        $buscarProp = $this->getpost('buscarProp');

        if ($action == "remove") {
            $this->dbMaster->delete('quid_propostas', ['idquid_propostas' => $idProposta]);
            return redirect()->to(urlInstitucional . 'insight-listar-propostas/0/0');
        }

        if ($action == "add") {
            $dados['pageTitle'] = 'Adicionar proposta';

            $nomes = [];

            $assessores = $this->m_bmg->listarAssessor();

            foreach ($assessores as $assessor) {
                $nomes[] = $assessor->nickname;
            }

            $dados['assessores'] = $assessores;

            return $this->loadpage('insight/insight_incluir_proposta', $dados);
        }

        if ($action == "alterar-status") {
            $id = $this->request->getPost('id');
            $novoStatus = $this->request->getPost('status');
            $nome = $this->request->getPost('nome');
            $cpf = $this->request->getPost('cpf');
            $telefone = $this->request->getPost('telefone');
            $produto = $this->request->getPost('produto');
            $valorSaque = $this->request->getPost('valorSaque');
            $valorParcela = $this->getpost('valorParcela');

            if ($id && $novoStatus) {

                $tabela = 'quid_propostas';
                $valores = [
                    'status' => $novoStatus,
                    'cpf' => $cpf,
                    'telefone' => $telefone,
                    'nome' => $nome,
                    'produto' => $produto,
                    'valor' => $valorSaque,
                    'valor_parcela' => $valorParcela
                ];
                $condicao = ['idquid_propostas' => $id];

                $retorno = $this->dbMasterDefault->update($tabela, $valores, $condicao);

                if ($retorno['updated']) {
                    return redirect()->to(urlInstitucional . 'insight-listar-propostas/0/0');
                } else {
                    return redirect()->to(urlInstitucional . 'insight-listar-propostas/0/0');
                }
            }

            return redirect()->to(urlInstitucional . 'insight-listar-propostas/0/0');
        }

        if ($action == "incluir") {
            $assessor = $this->getpost("assessor");
            $cpf = $this->getpost("cpf");
            $adesao = $this->getpost("adesao");
            $idPanorama = $this->getpost("idPanorama");
            $codigoEntidade = $this->getpost("codigoEntidade");
            $matricula = $this->getpost("matricula");
            $nomeCliente = $this->getpost("nomeCliente");
            $dataNascimento = $this->getpost("dataNascimento");
            $ddd = $this->getpost("ddd");
            $telefone = $this->getpost("telefone");
            $valorSaque = $this->getpost("valorSaque");
            $valorParcela = $this->getpost("valorParcela");
            $parcelas = $this->getpost("parcelas");
            $report_to = $this->session->userId;

            $data['adesao'] = $adesao;
            $data['cpf'] = $cpf;
            $data['assessor'] = $assessor;
            $data['valorSaque'] = $valorSaque;
            $data['panorama_id'] = $idPanorama;
            $data['codigo_entidade'] = $codigoEntidade;
            $data['matricula'] = $matricula;
            $data['valor_parcela'] = $valorParcela;
            $data['numero_parcela'] = $parcelas;
            $data['report_to'] = $report_to;
            $data['nomeCliente'] = $nomeCliente;
            $data['dataNascimento'] = $dataNascimento;
            $data['telefone'] = $ddd . $telefone;

            $salvar = $this->m_bmg->gravar_proposta_bmg_database($data);

            return redirect()->to(urlInstitucional . 'insight-listar-propostas/0/0');
        }

        if (!empty($buscarProp)) {
            helper('cookie');
            $cpf = $this->getpost('txtCPF', false);
            $celular = $this->getpost('celular', false);
            $nome = $this->getpost('txtNome', false);
            $nomeAssessor = $this->getpost('nomeAssessor', false);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', false);
            $paginas = $this->getpost('paginas', false);
            $date = $this->getpost('date', false);
            $adesao = $this->getpost('numeroAdesao', false);

            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('date', $date);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('nomeAssessor', $nomeAssessor);
            Services::response()->setCookie('statusPropostaFiltro', $statusPropostaFiltro);
            Services::response()->setCookie('paginas', $paginas);
            Services::response()->setCookie('numeroAdesao', $adesao);
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $nomeAssessor = $this->getpost('nomeAssessor', true);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', true);
            $paginas = $this->getpost('paginas', true);
            $date = $this->getpost('date', true);
            $adesao = $this->getpost('numeroAdesao', true);
        }

        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];

        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        if (!empty($celular)) $likeCheck['telefone'] = $celular;
        if (!empty($nome)) $likeCheck['nome'] = $nome;
        if (!empty($nomeAssessor)) $likeCheck['assessor'] = $nomeAssessor;
        if (!empty($date)) $likeCheck['DATE(data_criacao)'] = $date;
        if (!empty($adesao)) $likeCheck['adesao'] = $adesao;

        if ($this->session->role == "OPERADOR") {
            $whereCheck["assessor"] = $this->session->nickname;
        }

        if ($this->session->role == "SUPERVISOR" && !$this->my_security->checkPermission("ADMIN") && !$this->my_security->checkPermission("FORMALIZACAO")) {
            $whereCheck['report_to'] = $this->session->userId;
        }

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
        $userId = $this->session->userId;

        if ($this->my_security->checkPermission("ADMIN") || $this->my_security->checkPermission("FORMALIZACAO")) {
            $indicadores['propostas_hoje'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) = CURDATE()"
            )['firstRow']->total;

            $indicadores['propostas_ontem'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)"
            )['firstRow']->total;

            $indicadores['propostas_7dias'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()"
            )['firstRow']->total;

            $indicadores['propostas_30dias'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()"
            )['firstRow']->total;

            return $indicadores;
        }

        if ($this->session->role == "SUPERVISOR" && !$this->my_security->checkPermission("ADMIN")) {
            $indicadores['propostas_hoje'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) = CURDATE() 
           AND report_to = '{$userId}'"
            )['firstRow']->total;

            $indicadores['propostas_ontem'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
           AND report_to = '{$userId}'"
            )['firstRow']->total;

            $indicadores['propostas_7dias'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() 
           AND report_to = '{$userId}'"
            )['firstRow']->total;

            $indicadores['propostas_30dias'] = $this->dbMaster->runQuery(
                "SELECT COUNT(*) AS total 
         FROM quid_propostas 
         WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() 
           AND report_to = '{$userId}'"
            )['firstRow']->total;

            return $indicadores;
        } else {
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
}
