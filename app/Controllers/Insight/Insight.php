<?php

namespace App\Controllers\Insight;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use Config\Services;
use App\Models\M_argus;
use App\Models\M_insight;
use App\Models\M_seguranca;
use App\Models\M_bmg;
use DateTime;

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

    public function Listar_propostas($idProposta, $action)
    {
        $dados['pageTitle'] = 'Propostas';
        $buscarProp = $this->getpost('buscarProp');

        if ($action == "remove") {
            $this->dbMaster->delete('quid_propostas', ['idquid_propostas' => $idProposta]);
            $this->dbMaster->delete('historico_propostas', ['id_proposta' => $idProposta]);
            return redirect()->to(urlInstitucional . 'listar-propostas/0/0');
        }

        if ($action == "alterar-status") {
            $id = $this->request->getPost('id');
            $novoStatus = $this->request->getPost('status');

            if ($novoStatus == "Cancelada") {
                $motivoCancelamento = $this->request->getpost('motivoCancelamento');
            }

            $nome = $this->request->getPost('nome');
            $cpf = $this->request->getPost('cpf');
            $telefone = $this->request->getPost('telefone');
            $produto = $this->request->getPost('produto');
            $valorSaque = $this->request->getPost('valorSaque');
            $valorParcela = $this->getpost('valorParcela');
            $panorama_id = $this->getpost('idPanorama');
            $parcelas = $this->getpost('parcelas');
            $observacao = $this->getpost('observacao') ?? '';

            $dataCriacaoStr = $this->getpost('dataCriacao');
            $dataCriacao = \DateTime::createFromFormat('d/m/Y', $dataCriacaoStr);

            $horaAtual = date('H:i:s');

            $dataCriacaoMySQL = $dataCriacao->format('Y-m-d') . ' ' . $horaAtual;

            $dataNascimento = $this->getpost('dataNascimento');
            $assessor = $this->getpost('assessor');

            $checkStatus = $this->m_insight->checkStatus($id);

            $statusAnterior = $checkStatus['firstRow']->status;

            $btnAudit = $this->getpost('auditoria');
            $resumo = $this->getpost('resumo');

            if ($btnAudit == "statusAudit") {
                if ($statusAnterior == "TED Devolvida") {
                    $banco = $this->getpost('bancoFix');
                    $agencia = $this->getpost('agenciaFix');
                    $conta = $this->getpost('contaFix');
                    $statusAnterior = "TED Devolvida";
                } else {
                    $statusAnterior = "Adesão";
                }

                $novoStatus = "Auditoria";
            }

            $userId = $this->getpost('userId');

            // if ($novoStatus == "Pendente") {
            //     $dados = [
            //         'userId' => $userId,
            //         'message' => $resumo ?? "",
            //         'link' => $id,
            //     ];

            //     $this->m_insight->registrarNotificacao($dados);
            // }

            if ($statusAnterior !== $novoStatus) {
                $obs = $this->getpost('conteudo');

                $movimento = [
                    'id_proposta' => $id,
                    'id_usuario' => $this->session->userId,
                    'usuario' => $this->session->nickname,
                    'status_anterior' => $statusAnterior,
                    'status_atual' => $novoStatus,
                    'horario' => (new DateTime())->format('Y-m-d H:i:s'),
                    'observacao' => $obs,
                    'resumo' => $resumo
                ];

                $this->m_insight->registrarMovimentacao($movimento);
            }

            if ($resumo !== null) {
                $this->m_insight->atualizarResumo($resumo, $id);
            }

            if ($id) {
                $tabela = 'quid_propostas';
                $valores = [
                    'status' => $novoStatus,
                    'cpf' => $cpf,
                    'telefone' => $telefone,
                    'nome' => $nome,
                    'produto' => $produto,
                    'valor' => $valorSaque,
                    'valor_parcela' => $valorParcela,
                    'panorama_id' => $panorama_id,
                    'numero_parcela' => $parcelas,
                    'data_criacao' => $dataCriacaoMySQL,
                    'dataNascimento' => $dataNascimento,
                    'assessor' => $assessor,
                    'banco' => $banco ?? null,
                    'agencia' => $agencia ?? null,
                    'conta' => $conta ?? null,
                    'motivoCancelamento' => $motivoCancelamento ?? "",
                ];
                $condicao = ['idquid_propostas' => $id];

                $retorno = $this->dbMasterDefault->update($tabela, $valores, $condicao);

                if ($retorno['updated']) {
                    return redirect()->to(urlInstitucional . 'listar-propostas/0/0');
                } else {
                    return redirect()->to(urlInstitucional . 'listar-propostas/0/0');
                }
            }

            return redirect()->to(urlInstitucional . 'listar-propostas/0/0');
        }

        if (!empty($buscarProp)) {
            helper('cookie');
            $cpf = $this->getpost('txtCPF', false);
            $celular = $this->getpost('celular', false);
            $nome = $this->getpost('txtNome', false);
            $nomeAssessor = $this->getpost('nomeAssessor', false);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', false);
            $paginas = $this->getpost('paginas', false);
            $dateDe = $this->getpost('dateDe', false);
            $dateAte = $this->getpost('dateAte', false);
            $adesao = $this->getpost('numeroAdesao', false);
            $equipe = $this->getpost('equipe', false);
            $status = $this->getpost('status', false);
            $auditorMove = $this->getpost('auditorMove', false);

            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('dateDe', $dateDe);
            Services::response()->setCookie('dateAte', $dateAte);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('nomeAssessor', $nomeAssessor);
            Services::response()->setCookie('statusPropostaFiltro', $statusPropostaFiltro);
            Services::response()->setCookie('paginas', $paginas);
            Services::response()->setCookie('numeroAdesao', $adesao);
            Services::response()->setCookie('equipe', $equipe);
            Services::response()->setCookie('status', $status);
            Services::response()->setCookie('auditorMove', $auditorMove);
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $nomeAssessor = $this->getpost('nomeAssessor', true);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', true);
            $paginas = $this->getpost('paginas', true);
            $dateDe = $this->getpost('dateDe', true);
            $dateAte = $this->getpost('dateAte', true);
            $adesao = $this->getpost('numeroAdesao', true);
            $equipe = $this->getpost('equipe', true);
            $status = $this->getpost('status', true);
            $auditorMove = $this->getpost('auditorMove', true);
        }

        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];
        $betweenCheck = [];

        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        if (!empty($celular)) $likeCheck['telefone'] = $celular;
        if (!empty($nome)) $likeCheck['nome'] = $nome;
        if (!empty($nomeAssessor)) $likeCheck['assessor'] = $nomeAssessor;
        if (!empty($adesao)) $likeCheck['adesao'] = $adesao;
        if (!empty($equipe)) $likeCheck['report_to'] = $equipe;
        if (!empty($status)) $likeCheck['status'] = $status;
        if (!empty($auditorMove)) $likeCheck['id_owner'] = $this->session->userId;

        if (!empty($dateDe) && !empty($dateAte)) {
            $betweenCheck = ["betweenCheck" => ['data_criacao', $dateDe, $dateAte]];
        } elseif (!empty($dateDe)) {
            $betweenCheck = ["betweenCheck" => ['data_criacao', $dateDe, $dateDe]];
        } elseif (!empty($dateAte)) {
            $betweenCheck = ["betweenCheck" => ['data_criacao', $dateAte, $dateAte]];
        } else {
            $betweenCheck = [];
        }

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
        $propostas = $this->dbMasterDefault->select('quid_propostas', $whereCheck, $whereNotIn + $likeCheck + $whereIn + $betweenCheck);

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

    public function insight_upload()
    {
        $arquivo = $this->request->getFile('arquivo');

        if ($arquivo->getError() != 0) {
            return "Nenhum arquivo foi enviado.";
        }

        if (!$arquivo->isValid()) {
            return "Erro no upload: " . $arquivo->getErrorString();
        }

        $caminho = WRITEPATH . 'uploads/' . $arquivo->getRandomName();
        $arquivo->move(WRITEPATH . 'uploads', basename($caminho));

        $dados = $this->lerCSV($caminho);

        if (empty($dados)) {
            return "Nenhum dado encontrado no arquivo.";
        }

        return $this->m_insight->importarEmMassa($dados);
    }

    private function lerCSV($caminho)
    {
        $dados = [];
        if (($handle = fopen($caminho, 'r')) !== false) {
            $linha = 0;
            while (($row = fgetcsv($handle, 1000, ";")) !== false) {
                if ($linha == 0) {
                    $linha++;
                    continue;
                }

                foreach ($row as &$campo) {
                    $campo = mb_convert_encoding($campo, 'UTF-8', 'ISO-8859-1, Windows-1252, UTF-8');
                    $campo = trim($campo);
                }
                unset($campo);

                $dataCriacao = $this->converterDataHora($row[7]);

                $dados[] = [
                    'adesao'           => $row[0],
                    'cpf'              => $row[1],
                    'nome'             => $row[2],
                    'assessor'         => $row[3],
                    'produto'          => $row[4],
                    'valor'            => $this->valorParaFloat($row[5]),
                    'telefone'         => $row[6],
                    'data_criacao'     => $dataCriacao,
                    'panorama_id'      => $row[8],
                    'report_to'        => $row[9],
                    'codigo_entidade'  => $row[10],
                    'valor_parcela'    => $this->valorParaFloat($row[11]),
                    'numero_parcela'   => $row[12],
                    'matricula'        => $row[13],
                    'dataNascimento'   => $row[14],
                    'ultimo_status'    => $row[15]
                ];

                $linha++;
            }
            fclose($handle);
        }
        return $dados;
    }


    private function valorParaFloat($valor)
    {
        $valor = trim($valor);

        if (strpos($valor, ',') !== false) {
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        }

        return (float) $valor;
    }

    private function converterDataHora($dataHora)
    {
        if (empty($dataHora)) return null;

        // Quebra data e hora
        [$data, $hora] = explode(' ', $dataHora);

        // Quebra a parte da data
        $partes = explode('/', $data);
        if (count($partes) === 3) {
            $dataConvertida = $partes[2] . '-' . $partes[1] . '-' . $partes[0];
            return $dataConvertida . ' ' . $hora . ':00'; // adiciona segundos
        }

        return null; // formato inválido
    }

    public function panorama_gravar_proposta_saque($params)
    {
        $returnData = [
            "status" => false,
            "proposta" => "",
            "mensagem" => ""
        ];

        if ($params['codigoEntidade'] == "1581" && $params['produto'] == "Cartão BMG") {
            $planoName = 'BMG CARD';
        } else if ($params['codigoEntidade'] == "4277" && $params['produto'] == "Cartão BMG") {
            $planoName = 'BMG BENEFICIO CARD';
        } else {
            $planoName = 'SAQUE ELETRONICO';
        }

        if ($params['produto'] == "Cartão BMG") {
            $valorPlano = '1';
            $parcelas = '1';
            $prazo = '1';
        } else {
            $valorPlano = $params['valorSaque'] ?? '1';
            $parcelas = $params['valorParcela'] ?? '1';
            $prazo = $params['quantidadeParcelas'] ?? '1';
        }

        $cpf = $params['cpf'] ?? '';
        $adesao = $params['adesao'] ?? '';
        $matricula = $params['matricula'] ?? '';
        $especie = $params['especie'] ?? '';
        $nomeCliente = $params['nomeCliente'];
        $dataNascimento = $params['dataNascimento'] ?? '';
        $codigoEntidade = $params['codigoEntidade'];
        $observacao = $params['observacao'];

        if ($codigoEntidade !== "164") {
            $produto = "INSS";
        } else {
            $produto = "SIAPE";
        }

        $ddd = $params['celular1']['ddd'];
        $numero = $params['celular1']['numero'];

        $numeroFormat = $ddd . $numero;

        $data = [
            'CONTRATO' => $adesao,
            'STATUS' => 'ADESÃO',
            'NOME_CLIENTE' => $nomeCliente,
            'ASSESSOR' => $this->session->nickname,
            'CPF' => $cpf,
            'TELEFONE' => formatarTelefone($numeroFormat),
            'DATANASCIMENTO' => $dataNascimento,
            'MATRICULA' => $matricula,
            'ESPECIE' => $especie,
            'TABELA' => $planoName,
            'DATA_CADASTRO' => date('d/m/Y H:i:s'),
            'BANCO' => 'BMG',
            'PRODUTO' => $produto,
            'PRAZO' => $prazo,
            'PARCELA' => $parcelas,
            'EMPRESTIMO' => $valorPlano,
            'SEGURO' => '1',
            'OBSERVACAO' => $observacao
        ];

        $ordem = [
            'CONTRATO',
            'STATUS',
            'NOME_CLIENTE',
            'ASSESSOR',
            'CPF',
            'TELEFONE',
            'DATANASCIMENTO',
            'MATRICULA',
            'ESPECIE',
            'TABELA',
            'DATA_CADASTRO',
            'BANCO',
            'PRODUTO',
            'PRAZO',
            'PARCELA',
            'EMPRESTIMO',
            'SEGURO',
            'OBSERVACAO'
        ];

        $valores = [];

        foreach ($ordem as $campo) {
            $valores[] = isset($data[$campo]) ? $data[$campo] : '';
        }

        $dadosString = implode(';', $valores);
        $dadosStringISO = $dadosString;
        $url = 'https://grupoquid.panoramaemprestimos.com.br/html.do?action=adicionarOperacao'
            . '&token=44321'
            . '&idImportacao=1466'
            . '&dados=' . rawurlencode($dadosStringISO);

        $output = "";

        try {
            $output = file_get_contents($url);
        } catch (\Exception $e) {
            $returnData["mensagem"] = "Erro ao gravar proposta no Panorama:<br>" . $output . "<br>URL:<br>" . $url . "<br>DadosString:<br>" . $dadosString;
        }

        if (isset($output) && (is_numeric($output) && $output > 0)) {
            $returnData["status"] = true;
            $returnData["mensagem"] = "Proposta gravada com sucesso no BMG e Panorama:";
            $returnData["proposta"] = $output;
        } else {
            $returnData["mensagem"] = "Erro ao gravar proposta no Panorama:<br>" . $output . "<br>URL:<br>" . $url . "<br>DadosString:<br>" . $dadosString;
        }

        return $returnData;
    }

    public function indicadores()
    {
        $indicadores = [];
        $nickname = $this->session->nickname;
        $userId = $this->session->userId;

        if ($this->my_security->checkPermission("ADMIN") || $this->my_security->checkPermission("FORMALIZACAO") || $this->my_security->checkPermission("GERENTE")) {
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

    public function insight_proposta($id)
    {
        $dados['pageTitle'] = $id;

        $propostas = $this->dbMasterDefault->select('quid_propostas', ['idquid_propostas' => $id]);
        $movimento = $this->dbMasterDefault->select('historico_propostas', ['id_proposta' => $id]);

        $dados['arquivos'] = $this->dbMasterDefault->selectArquivos($id);

        $dadosProduto = $this->m_insight->getProdutoName($propostas['firstRow']->produto)['firstRow'];
        
        $dados['produto'] = $dadosProduto;
        $dados['propostas'] = $propostas;
        $dados['movimento'] = $movimento;
        $dados['session'] = $this->session;

        return $this->loadPage('insight/insight_proposta', $dados);
    }

    public function atualizarMetas($idSupervisor, $valor = 1)
    {

        $quantidadeEquipe = $this->m_insight->quantidadeEquipe($idSupervisor)['countAll'];

        if ($quantidadeEquipe < 0) {
            $metaMensal = 1;
        } else {
            $metaMensal = (float) $valor * $quantidadeEquipe;
        }

        $fieldUpdate = [
            "meta" => $valor,
            "meta_mensal" => $metaMensal
        ];

        $whereArrayUpdt = [
            "supervisor" => $idSupervisor
        ];

        $this->dbMasterDefault->update("equipes", $fieldUpdate, $whereArrayUpdt);

        return redirect()->to(urlInstitucional);
    }

    public function atualizarMetasQTD($idSupervisor, $valor = 1)
    {

        $quantidadeEquipe = $this->m_insight->quantidadeEquipe($idSupervisor)['countAll'];

        if ($quantidadeEquipe < 0) {
            $metaMensal = 1;
        } else {
            $metaMensal = (float) $valor * $quantidadeEquipe;
        }

        $fieldUpdate = [
            "meta_quantidade" => $valor,
            "meta_quantidade_mensal" => $metaMensal
        ];

        $whereArrayUpdt = [
            "supervisor" => $idSupervisor
        ];

        $this->dbMasterDefault->update("equipes", $fieldUpdate, $whereArrayUpdt);

        return redirect()->to(urlInstitucional);
    }

    public function criarProposta($idproduto, $action)
    {
        $dados['pageTitle'] = 'Adicionar proposta';
        $dados['nomeAssessor'] = $this->session->nickname;

        if ($action == "salvar") {
            $assessor = $this->getpost('assessor');
            $codigoEntidade = $this->getpost('codigoEntidade') ?? '';
            $cpf = $this->getpost('cpf');
            $dataNascimento = $this->getpost('dataNascimento');
            $matricula = $this->getpost('matricula') ?? '';
            $nomeCliente = $this->getpost('nomeCliente');
            $ddd = $this->getpost('ddd');
            $telefone = $this->getpost('telefone');
            $adesao = $this->getpost('adesao');
            $valorSaque = $this->getpost('valorSaque') ?? '0';
            $valorParcela = $this->getpost('valorParcela') ?? '0';
            $quantidadeParcelas = $this->getpost('parcelas') ?? '0';
            $observacao = $this->getpost('observacao') ?? "";
            $produto = $this->getpost('produto');
            $valorSeguro = $this->getpost('valorSeguro') ?? '0';
            $parcelasSeguro = $this->getpost('parcelasSeguro') ?? '0';

            $respostaInsight = $this->getpost('resposta_insight');
            $respostaPanorama = $this->getpost('resposta_panorama');

            $returnData = [];

            if ($respostaPanorama == "sim") {
                $returnData = $this->panorama_gravar_proposta_saque([
                    'assessor' => $assessor,
                    'produto' => $produto,
                    'codigoEntidade' => $codigoEntidade,
                    'cpf' => $cpf,
                    'dataNascimento' => $dataNascimento,
                    'matricula' => $matricula,
                    'nomeCliente' => $nomeCliente,
                    'celular1' => ['ddd' => $ddd, 'numero' => $telefone],
                    'adesao' => $adesao,
                    'valorSaque' => $valorSaque ?? '1',
                    'valorParcela' => $valorParcela ?? '1',
                    'quantidadeParcelas' => $quantidadeParcelas ?? '1',
                    'observacao' => $observacao
                ]);
            }

            if ($respostaInsight == "sim") {
                $this->m_bmg->gravar_proposta_bmg_database([
                    'assessor' => $assessor,
                    'produto' => $produto,
                    'report_to' => $this->session->report_to,
                    'codigo_entidade' => $codigoEntidade,
                    'cpf' => $cpf,
                    'dataNascimento' => $dataNascimento,
                    'panorama_id' => $returnData["proposta"] ?? "",
                    'matricula' => $matricula,
                    'nomeCliente' => $nomeCliente,
                    'telefone' => $ddd . $telefone,
                    'adesao' => $adesao,
                    'valorSaque' => $valorSaque,
                    'valor_parcela' => $valorParcela,
                    'numero_parcela' => $quantidadeParcelas,
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'userId' => $this->session->userId,
                    'valorSeguro' => $valorSeguro,
                    'parcelasSeguro' => $parcelasSeguro
                ]);
            }

            return redirect()->to(urlInstitucional . 'listar-propostas/0/0');
        }

        $produto = $this->m_insight->getProduto($idproduto);

        $dados['produto'] = $produto;

        return $this->loadpage('insight/insight_registrar_proposta', $dados);
    }
}
