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
        $this->m_argus = new M_argus();
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

        $dados['produtos'] = $this->dbMasterDefault->selectAll('quid_produtos');

        if ($action == "remove") {
            $this->dbMaster->delete('quid_propostas', ['idquid_propostas' => $idProposta]);
            $this->dbMaster->delete('historico_propostas', ['id_proposta' => $idProposta]);
            return redirect()->to(urlInstitucional . 'listar-propostas/0/0');
        }

        if ($action == "alterar-status") {
            $idProposta = $this->request->getPost('id');

            if ($this->session->role == "OPERADOR" || $this->session->userId == "165006" || $this->session->userId == "165005" || $this->session->userId == "164979") {
                $novoStatus = $this->getpost('statusOperador');
                $dataLançamento = false;
            } else {
                $novoStatus = $this->request->getPost('status');
                $dataLançamento = true;
            }

            if ($novoStatus == "Cancelada") {
                $motivoCancelamento = $this->request->getpost('motivoCancelamento');
            }

            $nome = $this->request->getPost('nome');
            $cpf = $this->request->getPost('cpf');
            $telefone = $this->request->getPost('telefone');
            $produto = $this->request->getPost('produto');
            $valorSaque = $this->request->getPost('valorSaque');
            $valorParcela = $this->getpost('valorParcela');
            $observacaoInicial = $this->getPost('observacaoInicial');
            $panorama_id = $this->getpost('idPanorama');
            $parcelas = $this->getpost('parcelas');
            $codigoEntidade = $this->getpost('codigoEntidade');
            $adesao = $this->getpost('adesao');

            $nb = $this->getpost('numeroBeneficio') ?? '';

            //Dados bancarios
            $banco = $this->getpost('banco') ?? '';
            $agencia = $this->getpost('agencia') ?? '';
            $conta = $this->getpost('conta') ?? '';

            //Endereço
            $cep = $this->getpost('cep') ?? '';
            $rua = $this->getpost('rua') ?? '';
            $numero = $this->getpost('numero') ?? '';
            $bairro = $this->getpost('bairro') ?? '';
            $cidade = $this->getpost('cidade') ?? '';
            $estado = $this->getpost('estado') ?? '';

            //gboex 
            $tipoDesconto = $this->getpost('tipoDesconto') ?? '';

            $dataCriacaoStr = $this->getpost('dataCriacao');
            $dataCriacao = \DateTime::createFromFormat('d/m/Y', $dataCriacaoStr);

            $horaAtual = date('H:i:s');

            $dataCriacaoMySQL = $dataCriacao->format('Y-m-d') . ' ' . $horaAtual;

            $dataNascimento = $this->getpost('dataNascimento');
            $assessor = $this->getpost('assessor');

            $checkStatus = $this->m_insight->checkStatus($idProposta);

            $statusAnterior = $checkStatus['firstRow']->status;

            $btnAudit = $this->getpost('auditoria');
            $resumo = $this->getpost('resumo');

            if ($btnAudit == "statusAudit") {

                $statusAnterior = $statusAnterior;

                $novoStatus = "Auditoria";
            }

            if ($statusAnterior == "Pendente" || $statusAnterior == "Corrigir erro") {
                $this->dbMasterDefault->update('quid_notificacoes', ['is_read' => '1'], ['link' => $idProposta]);
            }
            $userId = $this->getpost('userId');

            if ($novoStatus == "Pendente" || $novoStatus == "Corrigir erro") {
                $dados = [
                    'userId' => $userId,
                    'resumo' => $resumo ?? "",
                    'obs' => $this->getpost('conteudo') ?? "",
                    'link' => $idProposta,
                    'status' => $novoStatus
                ];

                $this->m_insight->registrarNotificacao($dados);
            }

            $idsAtrelados = $_POST['ids'] ?? [];

            if (!empty($idsAtrelados)) {
                foreach ($idsAtrelados as $id) {
                    $this->dbMasterDefault->update(
                        'quid_propostas',
                        ['status' => $novoStatus],
                        ['idquid_propostas' => intval($id)]
                    );
                }
            }

            if ($statusAnterior !== $novoStatus) {
                $obs = $this->getpost('conteudo');
                $switchStatus = "";

                if ($novoStatus == "Cancelada") {
                    $switchStatus = $motivoCancelamento;
                } else if ($novoStatus == "Pendente") {
                    $switchStatus = $resumo;
                }

                $movimento = [
                    'id_proposta' => $idProposta,
                    'id_usuario' => $this->session->userId,
                    'usuario' => $this->session->nickname,
                    'status_anterior' => $statusAnterior,
                    'status_atual' => $novoStatus,
                    'horario' => (new DateTime())->format('Y-m-d H:i:s'),
                    'observacao' => $obs,
                    'resumo' => $switchStatus
                ];

                $this->m_insight->registrarMovimentacao($movimento);
            }

            if ($resumo !== null) {
                if ($novoStatus == "Pendente" || $novoStatus == "Cancelada") {
                    $this->m_insight->atualizarResumo($resumo, $idProposta);
                } else {
                    $resumo = '';
                    $this->m_insight->atualizarResumo($resumo, $idProposta);
                }
            }

            if ($idProposta) {
                $tabela = 'quid_propostas';

                if ($dataLançamento == true) {
                    $valores['data_criacao'] = $dataCriacaoMySQL;
                }

                $valores = [
                    'status' => $novoStatus,
                    'adesao' => $adesao,
                    'cpf' => $cpf,
                    'matricula' => $nb,
                    'telefone' => $telefone,
                    'nome' => $nome,
                    'produto' => $produto,
                    'valor' => $valorSaque,
                    'codigo_entidade' => $codigoEntidade,
                    'valor_parcela' => $valorParcela,
                    'panorama_id' => $panorama_id,
                    'numero_parcela' => $parcelas,
                    'dataNascimento' => $dataNascimento,
                    'assessor' => $assessor,
                    'banco' => $banco ?? null,
                    'agencia' => $agencia ?? null,
                    'conta' => $conta ?? null,
                    'motivoCancelamento' => $motivoCancelamento ?? "",
                    'observacaoInicial' => $observacaoInicial,
                    'tipoDesconto' => $tipoDesconto,
                    'cep' => $cep,
                    'rua' => $rua,
                    'numeroEnd' => $numero,
                    'bairro' => $bairro,
                    'cidade' => $cidade,
                    'estado' => $estado,
                ];
                $condicao = ['idquid_propostas' => $idProposta];

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
            $produto = $this->getpost('produto', false);

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
            Services::response()->setCookie('produto', $produto);
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
            $produto = $this->getpost('produto', true);
        }

        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];
        $betweenCheck = [];

        if (!empty($cpf))
            $likeCheck['cpf'] = $cpf;
        if (!empty($celular))
            $likeCheck['telefone'] = $celular;
        if (!empty($nome))
            $likeCheck['nome'] = $nome;
        if (!empty($nomeAssessor))
            $likeCheck['assessor'] = $nomeAssessor;
        if (!empty($adesao))
            $likeCheck['adesao'] = $adesao;
        if (!empty($equipe))
            $likeCheck['report_to'] = $equipe;
        if (!empty($status))
            $likeCheck['status'] = $status;
        if (!empty($auditorMove))
            $likeCheck['id_owner'] = $this->session->userId;
        if (!empty($produto))
            $likeCheck['produto'] = $produto;

        if (!empty($dateDe) && !empty($dateAte)) {
            $betweenCheck = ["betweenCheck" => ['data_criacao', $dateDe, $dateAte]];
        } elseif (!empty($dateDe)) {
            $betweenCheck = ["betweenCheck" => ['data_criacao', $dateDe, $dateDe]];
        } elseif (!empty($dateAte)) {
            $betweenCheck = ["betweenCheck" => ['data_criacao', $dateAte, $dateAte]];
        } else {
            $betweenCheck = [];
        }

        if (!$this->my_security->checkPermission("ADMIN")) {
            $whereCheck['produtoBase'] = 1;
        }

        if ($this->session->role == "OPERADOR") {
            $whereCheck["assessor"] = $this->session->nickname;
        }

        if ($this->session->role == "SUPERVISOR" && !$this->my_security->checkPermission("ADMIN") && !$this->my_security->checkPermission("FORMALIZACAO")) {
            $whereCheck['report_to'] = $this->session->userId;
        }

        $likeCheck = array("likeCheck" => $likeCheck);

        $paginas = (empty($paginas) ? 20 : $paginas);
        $this->dbMasterDefault->setLimit($paginas);
        $this->dbMasterDefault->setOrderBy(array('data_criacao', 'DESC'));
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
                    'adesao' => $row[0],
                    'cpf' => $row[1],
                    'nome' => $row[2],
                    'assessor' => $row[3],
                    'produto' => $row[4],
                    'valor' => $this->valorParaFloat($row[5]),
                    'telefone' => $row[6],
                    'data_criacao' => $dataCriacao,
                    'panorama_id' => $row[8],
                    'report_to' => $row[9],
                    'codigo_entidade' => $row[10],
                    'valor_parcela' => $this->valorParaFloat($row[11]),
                    'numero_parcela' => $row[12],
                    'matricula' => $row[13],
                    'dataNascimento' => $row[14],
                    'ultimo_status' => $row[15]
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
        if (empty($dataHora)) {
            return null;
        }

        $partes = explode(' ', $dataHora);
        $data = $partes[0];
        $hora = $partes[1] ?? '00:00';

        $partesData = explode('/', $data);
        if (count($partesData) === 3) {
            $dataConvertida = $partesData[2] . '-' . $partesData[1] . '-' . $partesData[0];
            return $dataConvertida . ' ' . $hora . ':00';
        }

        return null;
    }

    public function panorama_gravar_proposta_saque($params)
    {
        $returnData = [
            "status" => false,
            "proposta" => "",
            "mensagem" => ""
        ];

        switch (true) {
            case ($params['produto'] === "Seguro de Vida"):
                $planoName = 'GBOEX';
                break;

            case ($params['codigoEntidade'] === "1581" && $params['produto'] === "Cartão BMG"):
                $planoName = 'BMG CARD';
                break;

            case ($params['codigoEntidade'] === "4277" && $params['produto'] === "Cartão BMG"):
                $planoName = 'BMG BENEFICIO CARD';
                break;

            case ($params['produto'] === "Seguro Med Família"):
                $planoName = 'BMG MED FAMILIAR';
                break;

            case ($params['produto'] === "Seguro Med Plus"):
                $planoName = 'BMG MED PLUS';
                break;

            case ($params['produto'] === "Seguro Med Individual"):
                $planoName = 'BMG MED INDIVIDUAL';
                break;

            default:
                $planoName = 'SAQUE ELETRONICO';
                break;
        }

        if ($params['produto'] == "Cartão BMG") {
            $valorPlano = '1';
            $parcelas = '1';
            $prazo = '1';
            $valorSeguro = '1';
        } else if ($params['produto'] == "Seguro Med Família" || $params['produto'] == "Seguro Med Plus" || $params['produto'] == "Seguro Med Individual") {
            $valorSeguro = $params['valorSaque'] ?? '1';
            $valorPlano = '1';
            $parcelas = '1';
            $prazo = $params['quantidadeParcelas'] ?? '1';
        } else {
            $valorPlano = $params['valorSaque'] ?? '1';
            $parcelas = $params['valorParcela'] ?? '1';
            $prazo = $params['quantidadeParcelas'] ?? '1';
            $valorSeguro = '1';
        }

        $cpf = $params['cpf'] ?? '';
        $adesao = $params['adesao'] ?? '';
        $matricula = $params['matricula'] ?? '';
        $nomeCliente = $params['nomeCliente'];
        $dataNascimento = $params['dataNascimento'] ?? '';
        $codigoEntidade = $params['codigoEntidade'];
        $observacao = $params['observacao'] ?? '';

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
            'ESPECIE' => '',
            'TABELA' => $planoName,
            'DATA_CADASTRO' => date('d/m/Y H:i:s'),
            'BANCO' => 'BMG',
            'PRODUTO' => $produto,
            'PRAZO' => $prazo,
            'PARCELA' => $parcelas,
            'EMPRESTIMO' => $valorPlano,
            'SEGURO' => $valorSeguro,
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

        if ($params['produto'] == "Seguro Med Família" || $params['produto'] == "Seguro de Vida" || $params['produto'] == "Seguro Med Plus" || $params['produto'] == "Seguro Med Individual") {
            $url = 'https://grupoquid.panoramaemprestimos.com.br/html.do?action=adicionarOperacao'
                . '&token=44321'
                . '&idImportacao=1494'
                . '&dados=' . rawurlencode($dadosStringISO);
        } else {
            $url = 'https://grupoquid.panoramaemprestimos.com.br/html.do?action=adicionarOperacao'
                . '&token=44321'
                . '&idImportacao=1466'
                . '&dados=' . rawurlencode($dadosStringISO);
        }

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

        $propostasAgregadas = $this->dbMasterDefault->selectAll('quid_propostas', ['adesao' => $propostas['firstRow']->adesao]);

        $dados['arquivos'] = $this->dbMasterDefault->selectArquivos($id);

        $dadosProduto = $this->m_insight->getProdutoName($propostas['firstRow']->produto)['firstRow'];

        $dados['produto'] = $dadosProduto;
        $dados['propostasAgregadas'] = $propostasAgregadas;
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

            $produtoId = $this->getpost('produtoId');

            //Dados bancarios
            $banco = $this->getpost('banco');
            $agencia = $this->getpost('agencia');
            $conta = $this->getpost('conta');

            //Endereço
            $cep = $this->getpost('cep');
            $rua = $this->getpost('rua');
            $numero = $this->getpost('numeroEnd');
            $bairro = $this->getpost('bairro');
            $cidade = $this->getpost('cidade');
            $estado = $this->getpost('estado');

            //GBOEX
            $tipoDesconto = $this->getpost('tipoDesconto') ?? '';

            $totalAdicionados = $this->getpost('totalAdicionados');
            $produtosSelecionados = json_decode($this->request->getPost('produtosSelecionados'), true) ?? [];

            if ($totalAdicionados > 1) {
                $this->m_bmg->gravar_proposta_bmg_database([
                    'assessor' => $assessor,
                    'produto' => $produto,
                    'report_to' => $this->session->report_to,
                    'codigo_entidade' => $codigoEntidade,
                    'cpf' => $cpf,
                    'dataNascimento' => $dataNascimento,
                    'panorama_id' => "",
                    'matricula' => $matricula,
                    'nomeCliente' => $nomeCliente,
                    'telefone' => $ddd . $telefone,
                    'adesao' => $adesao,
                    'valorSaque' => $valorSaque,
                    'valor_parcela' => $valorParcela,
                    'numero_parcela' => $quantidadeParcelas,
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'userId' => $this->session->userId,
                    'produtoBase' => 1,
                    'observacaoInicial' => $observacao,
                    'att' => 0,
                    'produtoId' => $produtoId,
                    'banco' => $banco ?? '',
                    'agencia' => $agencia ?? '',
                    'conta' => $conta ?? '',
                    'cep' => $cep ?? '',
                    'rua' => $rua ?? '',
                    'numero' => $numero ?? '',
                    'bairro' => $bairro ?? '',
                    'cidade' => $cidade ?? '',
                    'estado' => $estado ?? '',
                ]);

                $last = end($produtosSelecionados);

                foreach ($produtosSelecionados as $product) {
                    $this->m_bmg->gravar_proposta_bmg_database([
                        'assessor' => $assessor,
                        'produto' => $product['produto'],
                        'report_to' => $this->session->report_to,
                        'codigo_entidade' => $codigoEntidade,
                        'cpf' => $cpf,
                        'dataNascimento' => $dataNascimento,
                        'panorama_id' => "",
                        'matricula' => $matricula,
                        'nomeCliente' => $nomeCliente,
                        'telefone' => $ddd . $telefone,
                        'adesao' => $adesao,
                        'valorSaque' => $this->getpost($product['valor']),
                        'valor_parcela' => $this->getpost($product['parcela']),
                        'numero_parcela' => $this->getpost($product['numeroParcela']),
                        'data_criacao' => date('Y-m-d H:i:s'),
                        'userId' => $this->session->userId,
                        'produtoBase' => 0,
                        'att' => ($product === $last ? 1 : 0),
                        'observacaoInicial' => $observacao,
                        'produtoId' => $produtoId,
                        'banco' => $banco ?? '',
                        'agencia' => $agencia ?? '',
                        'conta' => $conta ?? '',
                        'cep' => $cep ?? '',
                        'rua' => $rua ?? '',
                        'numero' => $numero ?? '',
                        'bairro' => $bairro ?? '',
                        'cidade' => $cidade ?? '',
                        'estado' => $estado ?? '',
                    ]);
                }
            } else {
                $this->m_bmg->gravar_proposta_bmg_database([
                    'assessor' => $assessor,
                    'produto' => $produto,
                    'report_to' => $this->session->report_to,
                    'codigo_entidade' => $codigoEntidade,
                    'cpf' => $cpf,
                    'dataNascimento' => $dataNascimento,
                    'panorama_id' => "",
                    'matricula' => $matricula,
                    'nomeCliente' => $nomeCliente,
                    'telefone' => $ddd . $telefone,
                    'adesao' => $adesao,
                    'valorSaque' => $valorSaque,
                    'valor_parcela' => $valorParcela,
                    'numero_parcela' => $quantidadeParcelas,
                    'data_criacao' => date('Y-m-d H:i:s'),
                    'userId' => $this->session->userId,
                    'produtoBase' => 1,
                    'att' => 1,
                    'observacaoInicial' => $observacao,
                    'tipoDesconto' => $tipoDesconto,
                    'produtoId' => $produtoId,
                    'banco' => $banco ?? '',
                    'agencia' => $agencia ?? '',
                    'conta' => $conta ?? '',
                    'cep' => $cep ?? '',
                    'rua' => $rua ?? '',
                    'numero' => $numero ?? '',
                    'bairro' => $bairro ?? '',
                    'cidade' => $cidade ?? '',
                    'estado' => $estado ?? '',
                ]);
            }

            return redirect()->to(urlInstitucional . 'listar-propostas/0/0');
        }

        $produto = $this->m_insight->getProduto($idproduto);

        $produtos = $this->m_insight->getAllThat('quid_produtos', ['ATIVO' => '1']);

        $dados['produto'] = $produto;
        $dados['produtos'] = $produtos;

        return $this->loadpage('insight/insight_registrar_proposta', $dados);
    }
}
