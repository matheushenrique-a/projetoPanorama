<?php

namespace App\Models;

use SoapFault;
use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_http;
use App\Models\M_seguranca;
use App\Models\M_insight;
use DateTime;
use Symfony\Component\Panther\Client;

class M_bmg extends Model
{
    protected $dbMasterDefault;
    protected $session;
    protected $m_http;
    protected $m_security;
    protected $m_insight;

    public function __construct()
    {
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->m_http =  new M_http();
        $this->m_security = new M_seguranca();
        $this->m_insight = new M_insight();
        $this->db = \Config\Database::connect(); // inicializa $this->db
    }

    public function statusSeguro()
    {
        $adesao = "97446084"; //SEGURO MED - MARIA AUXILIADORA DO CARMO SILVA

        try {
            $client = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);

            // Parâmetros exigidos pela operação
            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'numeroAde'    => $adesao,           // número da adesão
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
            ];

            // Chamando o método
            $response = $client->__soapCall('obterStatusSeguro', [$params]);

            echo "<pre>";
            print_r($response);
            echo "</pre>";
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }

    //http://localhost/fintech/index.php/lab/validarElegibilidadeSeguros
    public function validarElegibilidadeSeguros()
    {
        $cpf = "05843943577";

        try {
            $client = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'                => BMG_SEGURO_LOGIN,
                'senha'                => BMG_SEGURO_SENHA,
                'codigoEntidade'       => 1581, // código da entidade fornecido pelo BMG
                'codigoSeguro'         => BMG_CODIGO_PRODUTO_MED,   // por exemplo: SeguroPrestamistaConsignado
                'cpfCliente'           => $cpf,
                // 'dataNascimento'       => '1990-01-01T00:00:00', // formato ISO-8601
                // 'prazoEmprestimo'      => 48,   // em meses
                'tipoPagamentoSeguro'  => 2,    // 1=à vista, 2=mensal etc.
                'numeroContaInterna'   => 987654,
                // 'tipoVinculo'          => 'TITULAR', // string representando o vínculo
                // 'indicativoCarencia'   => false
            ];

            $response = $client->__soapCall('validarElegibilidadeSeguros', [$params]);


            echo "<pre>";
            print_r($response);
            echo "</pre>";
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }



    public function listarPlanos()
    {
        $cpf = "65849949615";

        try {
            $client = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                'codigoOrgao'          => '1581',         // Código do Órgão fornecido pelo BMG
                'codigoProdutoSeguro'  => BMG_CODIGO_PRODUTO_MED,             // Ex: 35 = Seguro Prestamista Consignado
                'entidade'             => 1581, // Nome da entidade (ex: INSS, SIAPE, etc)
                //'matricula'            => '1655645452',   // Matrícula do cliente na entidade
                //'numeroInternoConta'   => 7543377,         // Número interno da conta (fornecido pelo BMG)
                'renda'                => 2500.00,        // Renda do cliente
                'sequencialOrgao'      => '001',          // Sequencial do órgão
                'tipoPagamentoSeguro'  => 2               // 1=à vista, 2=mensal, etc
            ];

            $response = $client->__soapCall('listaPlanos', [$params]);

            // echo "<pre>";
            // print_r($response);
            // echo "</pre>";

        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }

    public function listaPlanosRating($codigoProdutoSeguro, $numeroInternoConta, $limiteCartao)
    {
        // $cpf = "65849949615";
        // $cpf = "65849949615";
        // $cpf = "65849949615";
        $response = null;

        try {
            $client = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                // 'codigoOrgao'           => '12345',
                'codigoProdutoSeguro'   => $codigoProdutoSeguro,
                'entidade'              => BMG_ENTIDADE,
                // 'matricula'             => '12345678',
                'numeroInternoConta'    => $numeroInternoConta,
                'renda'                 => $limiteCartao,
                'sequencialOrgao'       => '001',
                'tipoPagamentoSeguro'   => 2 // 1 = à vista, 2 = mensal, etc.
            ];


            $response = $client->__soapCall('listaPlanosRating', [$params]);
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }

        return $response;
    }

    public function obterCartoesDisponiveis($cpf, $produto = BMG_CODIGO_PRODUTO_MED)
    {
        $returnData = [];
        $returnData["status"] = false;
        $returnData["mensagem"] = "";
        $returnData["cartoes"] = [];

        try {
            $client = new \SoapClient(BMG_SAQUE_WSDL, [
                'trace'      => 1,
                'exceptions' => true,
                'soap_version' => SOAP_1_1,
            ]);

            $params = [
                'param' => [
                    'login'        => BMG_SEGURO_LOGIN,
                    'senha'        => BMG_SEGURO_SENHA,
                    'codigoEntidade' => 4277,
                    'cpf'          => $cpf,
                ]
            ];

            // return $params;


            $response = $client->__soapCall('buscarCartoesDisponiveis', [$params]);

            // $teste = $params . $response;
            // return $response;

            // if (((isset($response->mensagemDeErro))) and ((!empty($response->mensagemDeErro)))) {
            //     $returnData["mensagem"] = "Cliente Inválido: <br>" . $response->mensagemDeErro;
            // } else {

            //     if (isset($response->cartaoClienteAtivoVendaSeguro) && is_array($response->cartaoClienteAtivoVendaSeguro)) {
            //         $returnData["status"] = true;
            //         foreach ($response->cartaoClienteAtivoVendaSeguro as $cartao) {
            //             $returnData["cartoes"][] = [
            //                 'nomeCliente'         => $cartao->nomeCliente,
            //                 'numeroCartao'        => $cartao->numeroCartao,
            //                 'limiteCartao'        => number_format($cartao->limiteCartao, 2, ',', '.'),
            //                 'cidade'              => $cartao->cidade,
            //                 'numeroInternoConta'  => $cartao->numeroInternoConta,
            //                 'cartaoSelecionado'   => $cartao->cartaoSelecionado,
            //                 'codigoCliente'       => $cartao->codigoCliente,
            //                 'codigoEntidade'      => $cartao->codigoEntidade,
            //                 'cpf'                 => $cartao->cpf,
            //                 'dataNascimento'      => $cartao->dataNascimento,
            //                 'ehElegivel'          => $cartao->ehElegivel,
            //                 'motivoElegibilidade' => $cartao->motivoElegibilidade,
            //                 'nomeEntidade'        => $cartao->nomeEntidade,
            //                 'orgaoFormatado'      => $cartao->orgaoFormatado,
            //                 'sequencialOrgao'     => $cartao->sequencialOrgao,
            //                 'planos' => [
            //                     'med' => $this->listaPlanosRating(BMG_CODIGO_PRODUTO_MED, $cartao->numeroInternoConta, $cartao->limiteCartao),
            //                 ]
            //             ];
            //         }
            //     } else {
            //         $returnData["mensagem"] = "Nenhum cartão disponível ou retorno inesperado.<br>";
            //     }
            // }
        } catch (SoapFault $fault) {
            $returnData["mensagem"] = "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }

        return $returnData;
    }

    public function geraScriptVenda($produto, $cpf, $conta, $plano, $codigoTipoPagamento)
    {
        $response = null;
        try {
            $client = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);

            $produto = strtoupper($produto);
            if ($produto == "MED") {
                $codigoSeguro = BMG_CODIGO_PRODUTO_MED;
            } elseif ($produto == "VIDA") {
                $codigoSeguro = BMG_CODIGO_PRODUTO_VIDA;
            } elseif ($produto == "PRESTAMISTA") {
                $codigoSeguro = BMG_CODIGO_PRODUTO_PRESTAMISTA;
            } else {
                $codigoSeguro = BMG_CODIGO_PRODUTO_PAP;
            }

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                'codLoja'                           => BMG_ENTIDADE,             // Código da loja fornecido pelo BMG
                'codigoPlano'                       => $plano,              // Código do plano de seguro desejado
                'codigoSeguro'                      => $codigoSeguro,               // Ex: Seguro Prestamista Consignado
                'codigoTipoFormaEnvio'             => 15,               // Ex: 15 = Digital
                'codigoTipoPagamento'              => $codigoTipoPagamento,                // Ex: 2 = Mensal  // 4= Parcelado
                'cpf'                               => $cpf,    // CPF do cliente
                'formaPagamentoProdutoSeguro' => 5,                // Ex: 5 = Folha de Pagamento
                //'matricula'                         => '1655645452',      // Matrícula do cliente
                'numeroInternoConta'               => $conta,           // Obtido de obterCartoesDisponiveis
                'renda'                             => 2500.00,          // Renda do cliente
                'upgrade'                           => false             // false para venda normal
            ];

            $response = $client->__soapCall('geraScriptVenda', [$params]);
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }

        return $response;
    }

    public function gravaPropostaSeguro($params)
    {
        $response = null;
        $returnData = [];
        $returnData["status"] = false;
        $returnData["mensagem"] = "";
        $returnData["cartoes"] = [];

        try {
            $client = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);

            $paramsLogin = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                'codLoja' => BMG_LOJA_UNITY,             // Código da loja fornecido pelo BMG
            ];

            $returnData["status"] = true;
            $returnData["adesao"] = '12345';
            $returnData["mensagem"] = "[EM CONSTRUÇÃO]<br>Proposta Gravada com Sucesso BMG!<br>Número da Adesão: 00000";
            return $returnData;
            exit;

            if (((isset($response->mensagemDeErro))) and ((!empty($response->mensagemDeErro)))) {
                $returnData["mensagem"] = "Erro ao Gravar: <br>" . $response->mensagemDeErro;
            } else {
                if (isset($response->numero)) {
                    $returnData["status"] = true;
                    $returnData["adesao"] = $response->numero;
                    $returnData["mensagem"] = "Proposta Gravada com Sucesso!<br>Número da Adesão: " . $response->numero;
                } else {
                    $returnData["mensagem"] = "Erro ao Recuperar Número da Adesão.";
                }
            }
        } catch (SoapFault $fault) {
            $returnData["mensagem"] = "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }

        return $returnData;
    }

    public function gravarPropostaSaque($params)
    {
        try {
            $client = new \SoapClient(BMG_SAQUE_WSDL, ['trace' => 1, 'exceptions' => true]);

            if ($params['finalidadeCredito'] == "3") {
                $formaCredito = 18;
            } else {
                $formaCredito = 2;
            }

            $fixParams = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'loginConsig'  => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig'  => BMG_SEGURO_SENHA_CONSIG,
                'codigoLoja' => (int) BMG_LOJA_UNITY,
                'finalidadeCredito' => $params['finalidadeCredito'], // CONTA CORRENTE
                'formaCredito' => $formaCredito, // TRANSFERÊNCIA BANCÁRIA // CONTA BMG
                'codigoFormaEnvioTermo' => "15", // DIGITAL
                'bancoOrdemPagamento' => 0,
                'cpfImpedidoComissionar' => false,
            ];

            $params = array_merge($fixParams, $params);

            $response = $client->__soapCall('gravarPropostaSaqueComplementar', [$params]);

            return $response;
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultstring}";

            return [
                'erro' => true,
                'mensagem' => "{$fault->faultstring}"
            ];
        }
    }

    public function obterValorParcela($data)
    {
        try {
            $client = new \SoapClient(BMG_SAQUE_WSDL, ['trace' => 1, 'exceptions' => true]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
            ];

            $params['valorSaque'] = $data['valorSaque'];
            $params['codigoEntidade'] = $data['codigoEntidade'];

            if ($data['codigoEntidade'] == '164') {
                $params['sequencialOrgao'] = '4';
            }

            $response = $client->__soapCall('buscarSimulacao', [$params]);

            return $response;
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";

            return [
                'erro' => true,
                'mensagem' => "{$fault->faultcode} - {$fault->faultstring}"
            ];
        }
    }

    public function obtemInfoSeguro($params)
    {
        try {
            $client = new \SoapClient('https://ws1.bmgconsig.com.br/webservices/ProdutoSeguroWebService?wsdl', ['trace' => 1, 'exceptions' => true]);

            $response = $client->__soapCall('listaPlanos', [$params]);

            return $response;
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";

            return [
                'erro' => true,
                'mensagem' => "{$fault->faultcode} - {$fault->faultstring}"
            ];
        }
    }

    public function obterLimiteSaque($params)
    {
        try {
            $client = new \SoapClient(BMG_SAQUE_WSDL, ['trace' => 1, 'exceptions' => true]);

            $fixParams = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
            ];

            $params = array_merge($fixParams, $params);

            $responseCards = $client->__soapCall('buscarCartoesDisponiveis', [$params]);

            if (isset($responseCards->cartoesRetorno) && is_array($responseCards->cartoesRetorno) && count($responseCards->cartoesRetorno) > 0) {
                $cartoesComLimites = [];

                foreach ($responseCards->cartoesRetorno as $cartao) {
                    $params['numeroContaInterna'] = $cartao->numeroContaInterna;
                    $params['matricula'] = $cartao->matricula;
                    $params['tipoSaque'] = 1;
                    $params['cpfImpedidoComissionar'] = false;

                    $limite = $client->__soapCall('buscarLimiteSaque', [$params]);

                    $cartoesComLimites[] = (object)[
                        'cartao' => $cartao,
                        'limite' => $limite
                    ];
                }

                return (object)[
                    'erro' => false,
                    'cartoes' => $cartoesComLimites
                ];
            } else {
                return [
                    'erro' => true,
                    'mensagem' => 'Nenhum cartão disponível ou retorno inesperado.'
                ];
            }
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";

            return [
                'erro' => true,
                'mensagem' => "{$fault->faultstring}"
            ];
        }
    }

    public function gravar_proposta_bmg_database($data)
    {
        $adesao = $data['adesao'];
        $cpf = $data['cpf'];
        $nome = $data['nomeCliente'];
        $produto = $data['produto'];

        $valor = (float) $data['valorSaque'];
        $status = "Adesão";
        $panorama_id = $data['panorama_id'] ?? "";
        $codigo_entidade = $data['codigo_entidade'];
        $valor_parcela = (float) $data['valor_parcela'];
        $numero_parcela = $data['numero_parcela'];
        $matricula = $data['matricula'];
        $dataNascimento = $data['dataNascimento'];
        $observacao = $data['observacaoInicial'];

        //Dados bancarios
        $banco = $data['banco'];
        $agencia = $data['agencia'];
        $conta = $data['conta'];

        //Endereço
        $cep = $data['cep'];
        $rua = $data['rua'];
        $numero = $data['numero'];
        $bairro = $data['bairro'];
        $cidade = $data['cidade'];
        $estado = $data['estado'];

        $produtoId = $data['produtoId'];

        $tipoDesconto = $data['tipoDesconto'] ?? "";

        $produtoBase = $data['produtoBase'];

        $userId = $data['userId'];

        $auditores = $this->m_insight->getAllThat('user_account', [
            'role'   => 'AUDITOR',
            'status' => 'ATIVO'
        ]);

        $totalAuditores = count($auditores);

        // Pegar o último id_owner usado
        $checkIdOwner = $this->m_insight->checkIdOwner();
        $currentIndex = (int)$checkIdOwner['firstRow']->id_owner;

        // Calcular o próximo índice (circular)
        $nextIndex = ($currentIndex % $totalAuditores);

        // Pegar auditor da lista
        $auditoriaId = $auditores[$nextIndex]->userId;

        $att = $data['att'];

        $this->m_insight->atualizarOwner($nextIndex + $att);

        if (isset($data['assessor'])) {
            if ($this->session->role == "SUPERVISOR") {
                $report_to = $this->session->userId;
            } else {
                $report_to = $data['report_to'];
            }

            $assessor = $data['assessor'];
            $telefone = $data['telefone'];
            $data_criacao = $data['data_criacao'];
        } else {
            $assessor = $this->session->nickname;
            $telefone = $data['celular1']['ddd'] . $data['celular1']['numero'];
            $report_to = $this->session->report_to;
            $data_criacao = date('Y-m-d H:i:s');
        }

        $insertID = $this->dbMasterDefault->insertAndGetId('quid_propostas', [
            "adesao" => $adesao,
            "cpf" => $cpf,
            "nome" => $nome,
            "assessor" => $assessor,
            "produto" => $produto,
            "valor" => $valor,
            "telefone" => $telefone,
            "status" => $status,
            "data_criacao" => $data_criacao,
            "panorama_id" => $panorama_id,
            "report_to" => $report_to,
            "codigo_entidade" => $codigo_entidade,
            "valor_parcela" => $valor_parcela,
            "numero_parcela" => $numero_parcela,
            "matricula" => $matricula,
            "dataNascimento" => $dataNascimento,
            "id_owner" => $auditoriaId,
            "userId" => $userId,
            "produtoBase" => $produtoBase,
            "observacaoInicial" => $observacao,
            "tipoDesconto" => $tipoDesconto ?? '',
            "banco" => $banco,
            "agencia" => $agencia,
            "conta" => $conta,
            "cep" => $cep,
            "rua" => $rua,
            "numeroEnd" => $numero,
            "bairro" => $bairro,
            "cidade" => $cidade,
            "estado" => $estado,
        ]);

        $client = \Config\Services::curlrequest();

        $url = 'https://grupoquid-dev.sydle.one/api/1/crm/com.grupoquid.crm/proposal/createAPI/';

        $sydle = [
            "adesao" => $adesao,
            "cpf" => $cpf,
            "nome" => $nome,
            "produto" => $produto,
            "produtoId" => $produtoId,
            "valor" => $valor,
            "telefone" => $telefone,
            "status" => $status,
            "data_criacao" => $data_criacao,
            "codigo_entidade" => $codigo_entidade,
            "valor_parcela" => $valor_parcela,
            "numero_parcela" => $numero_parcela,
            "matricula" => $matricula,
            "dataNascimento" => $dataNascimento,
            "id_owner" => $auditoriaId,
            "userId" => $userId,
            "observacaoInicial" => $observacao,
            "tipoDesconto" => $tipoDesconto ?? ''
        ];

        $username = 'victor.pomaroli';
        $password = '102030';

        $client->post($url, [
            'auth' => [$username, $password],
            'json' => $sydle
        ]);

        $movimentacao = [
            'id_proposta' => $insertID,
            'id_usuario' => $this->session->userId,
            'usuario' => $this->session->nickname,
            'status_anterior' => '',
            'status_atual' => $status,
            'horario' => (new DateTime())->format('Y-m-d H:i:s'),
            'observacao' => $observacao,
        ];

        $this->m_insight->registrarMovimentacao($movimentacao);
    }

    public function contarPropostasPorStatus($assessor)
    {
        $builder = $this->db->table('quid_propostas');
        $builder->select('status, COUNT(*) as total');
        $builder->where('assessor', $assessor);
        $builder->where('produtoBase', 1);
        $builder->where('MONTH(data_criacao)', date('m'));
        $builder->where('YEAR(data_criacao)', date('Y'));
        $builder->groupBy('status');

        $result = $builder->get()->getResult();

        $contadores = [
            "Análise"   => 0,
            "Pendente"  => 0,
            "Aprovada"  => 0,
            "Cancelada" => 0,
            "Auditoria" => 0,
            "Bloqueado" => 0,
        ];

        foreach ($result as $row) {
            $contadores[$row->status] = $row->total;
        }

        return $contadores;
    }

    public function ultimasPropostasBMG($assessor, $status = 'all', $limit = 10)
    {
        $builder = $this->db->table('quid_propostas');
        $builder->where('assessor', $assessor);
        $builder->where('produtoBase', 1);
        $builder->where('MONTH(data_criacao)', date('m'));
        $builder->where('YEAR(data_criacao)', date('Y'));

        if ($status !== 'all') {
            $builder->where('status', $status);
        }

        $builder->orderBy('data_criacao', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResult();
    }

    public function mensalPropostasBMG()
    {
        $sql = "
        SELECT *
        FROM quid_propostas
        WHERE assessor = '" . $this->session->nickname . "'
        AND MONTH(data_criacao) = MONTH(CURRENT_DATE())
          AND YEAR(data_criacao) = YEAR(CURRENT_DATE())
    ";

        return $this->dbMasterDefault->runQuery($sql);
    }

    public function countPropostasBMG()
    {
        $sql = "select * from quid_propostas where assessor = '" . $this->session->nickname . "' ";
        $sql .= "AND DATE(data_criacao) = CURDATE();";
        return $this->dbMasterDefault->runQuery($sql)['countAll'];
    }

    public function countPropostasPorDia()
    {
        $nickname = $this->session->nickname;

        $sql = "
        SELECT DATE(data_criacao) as data, COUNT(*) as total
        FROM quid_propostas
        WHERE assessor = '{$nickname}'
        AND DATE(data_criacao) >= CURDATE() - INTERVAL 15 DAY
        AND status IN ('Aprovada')
        GROUP BY DATE(data_criacao)
        ORDER BY data
        ";

        return $this->dbMasterDefault->runQuery($sql)['result']->getResult();
    }

    public function countPropostasPorDiaEquipe()
    {
        $equipe = $this->session->userId;

        if (($this->session->role !== "SUPERVISOR") || $this->m_security->checkPermission("FORMALIZACAO") || $this->m_security->checkPermission("ADMIN")) {
            $sql = "
            SELECT DATE(data_criacao) as data, status, COUNT(*) as total
            FROM quid_propostas
            WHERE userId = $equipe
            AND DATE(data_criacao) >= CURDATE() - INTERVAL 10 DAY
            AND status IN ('Aprovada', 'Análise', 'Pendente')
            GROUP BY DATE(data_criacao), status
            ORDER BY data, status
        ";
        } else {

            $sql = "
            SELECT DATE(data_criacao) as data, status, COUNT(*) as total
            FROM quid_propostas
            WHERE report_to = $equipe
            AND DATE(data_criacao) >= CURDATE() - INTERVAL 10 DAY
            AND status IN ('Aprovada', 'Análise', 'Pendente')
            GROUP BY DATE(data_criacao), status
            ORDER BY data, status
        ";
        }


        return $this->dbMasterDefault->runQuery($sql)['result']->getResult();
    }

    public function listarAssessor()
    {
        $equipe = $this->session->userId;

        $sql = "
        SELECT * 
        FROM user_account 
        WHERE report_to = {$equipe}";

        return $this->dbMasterDefault->runQuery($sql)['result']->getResult();
    }

    public function tabelaAssessores()
    {

        if ($this->session->report_to !== "164979") {
            if ($this->session->role == "OPERADOR") {
                $meta = $this->m_insight->buscarMetaSuaEquipe()['firstRow']->meta ?? "";
            } else if ($this->session->role == "SUPERVISOR") {
                $meta = $this->m_insight->buscarMetaIndividual()['firstRow']->meta ?? 22000;
            } else {
                $meta = 22000;
            }
        } else {
            $meta = 3200;
        }

        $supervisor = $this->session->userId;
        $report_to = $this->session->report_to;

        if ($this->session->role == "OPERADOR") {
            $sql = "
            SELECT 
            TRIM(assessor) AS nome,
            COUNT(*) AS total_propostas,
            SUM(valor) AS total_valor,
            ROUND((SUM(valor) / {$meta}) * 100, 1) AS percentual
            FROM quid_propostas
            WHERE MONTH(data_criacao) = MONTH(CURDATE())
            AND YEAR(data_criacao) = YEAR(CURDATE())
            AND report_to = {$report_to}
            AND status IN ('Aprovada')
            GROUP BY TRIM(assessor)
            ORDER BY total_valor DESC;
            ";
        } else if (($this->session->role !== "SUPERVISOR") || $this->m_security->checkPermission("FORMALIZACAO") || $this->m_security->checkPermission("ADMIN")) {
            $sql = "
            SELECT 
            TRIM(assessor) AS nome,
            COUNT(*) AS total_propostas,
            SUM(valor) AS total_valor,
            ROUND((SUM(valor) / {$meta}) * 100, 1) AS percentual
            FROM quid_propostas
            WHERE MONTH(data_criacao) = MONTH(CURDATE())
            AND YEAR(data_criacao) = YEAR(CURDATE())
            AND status IN ('Aprovada')
            GROUP BY TRIM(assessor)
            ORDER BY total_valor DESC;
            ";
        } else {
            $sql = "
            SELECT 
            TRIM(assessor) AS nome,
            COUNT(*) AS total_propostas,
            SUM(valor) AS total_valor,
            ROUND((SUM(valor) / {$meta}) * 100, 1) AS percentual
            FROM quid_propostas
            WHERE MONTH(data_criacao) = MONTH(CURDATE())
            AND YEAR(data_criacao) = YEAR(CURDATE())
            AND report_to = {$supervisor}
            AND status IN ('Aprovada')
            GROUP BY TRIM(assessor)
            ORDER BY total_valor DESC;
            ";
        }

        return $this->dbMasterDefault
            ->runQuery($sql)['result']
            ->getResult();
    }

    public function barraProgressoAssessor()
    {
        $assessor = $this->session->nickname;

        $meta = $this->m_insight->buscarMetaSuaEquipe()['firstRow']->meta ?? "";

        $sql = "
        SELECT 
            TRIM(assessor) AS nome,
            SUM(valor) AS total_valor,
            ROUND((SUM(valor) / {$meta}) * 100, 1) AS percentual
        FROM quid_propostas
        WHERE MONTH(data_criacao) = MONTH(CURDATE())
          AND YEAR(data_criacao) = YEAR(CURDATE())
          AND assessor = '$assessor'
          AND status IN ('Aprovada')
        GROUP BY TRIM(assessor)
        LIMIT 1;
        ";

        $result = $this->dbMasterDefault->runQuery($sql)['result']->getResult();

        return !empty($result) ? $result[0] : null;
    }

    public function totalMensal($equipe = null)
    {
        if (!$equipe) {
            $equipe = $this->session->userId;
        }

        $sql = "
        SELECT 
            COALESCE(SUM(valor), 0) AS total_mensal
        FROM quid_propostas
        WHERE report_to = {$equipe}
        AND status IN ('Aprovada')
          AND MONTH(data_criacao) = MONTH(CURRENT_DATE())
          AND YEAR(data_criacao) = YEAR(CURRENT_DATE())
        ";

        $result = $this->dbMasterDefault
            ->runQuery($sql, [$equipe])['result']
            ->getRow();

        return $result->total_mensal ?? 0;
    }

    public function totalMensalGerente()
    {
        $sql = "
        SELECT 
            report_to,
            COALESCE(SUM(valor), 0) AS total_mensal
        FROM quid_propostas
        WHERE report_to IN (164815,165005,165004,165006)
          AND status IN ('Aprovada')
          AND MONTH(data_criacao) = MONTH(CURRENT_DATE())
          AND YEAR(data_criacao) = YEAR(CURRENT_DATE())
        GROUP BY report_to
        ";

        $result = $this->dbMasterDefault
            ->runQuery($sql)['result']
            ->getResultArray();

        return $result;
    }

    public function envioRelatorioBmg($dados)
    {
        try {
            $url = 'https://ws1.bmgconsig.com.br/webservices/ConsultaStatusAde?wsdl';

            $client = new \SoapClient($url, ['trace' => 1, 'exceptions' => true]);

            $envioADE = $client->__soapCall('consultaStatusAde', [$dados]);

            return $envioADE;
        } catch (SoapFault $fault) {
            echo "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }
    }

    public function ultimasPropostasAuditor($limit)
    {
        $sql = "select * from quid_propostas where id_owner = '{$this->session->userId}' and status = 'Auditoria' and produtoBase = '1'";
        $sql .= " order by data_criacao DESC LIMIT $limit;";

        return $this->dbMasterDefault->runQuery($sql);
    }

    public function ultimasPropostasAuditorTotal($limit)
    {
        $sql = "select * from quid_propostas where status = 'Auditoria' and produtoBase = '1'";
        $sql .= " order by data_criacao DESC LIMIT $limit;";

        return $this->dbMasterDefault->runQuery($sql);
    }

    private function toUtf8($str)
    {
        if (!is_string($str)) return $str;
        $encoding = mb_detect_encoding($str, ['UTF-8', 'ISO-8859-1', 'WINDOWS-1252'], true);
        if ($encoding !== 'UTF-8') {
            return mb_convert_encoding($str, 'UTF-8', $encoding);
        }
        return $str;
    }

    public function gerarMailingSeguro(array $dados, ?string $jobId = null, ?callable $onProgress = null)
    {
        $fixParams = [
            'login'        => BMG_SEGURO_LOGIN,
            'senha'        => BMG_SEGURO_SENHA,
            'codigoSeguro' => 54,
        ];

        $operations = [];

        $total = count($dados['cpfs']);

        foreach ($dados['cpfs'] as $index => $dado) {
            $cpf = str_pad(preg_replace('/\D/', '', $dado), 11, '0', STR_PAD_LEFT);
            $params = array_merge($fixParams, ['cpf' => $cpf]);
            $mensagem = '';

            try {
                $client = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);
                $response = $client->__soapCall('obterCartoesDisponiveis', [$params]);

                if (isset($response->cartaoClienteAtivoVendaSeguro[0]->numeroInternoConta)) {
                    $newParams = [
                        'numeroInternoConta' => $response->cartaoClienteAtivoVendaSeguro[0]->numeroInternoConta,
                        'entidade' => $dados['entidade'],
                        'codigoProdutoSeguro' => 54,
                        'renda' => 2500.00
                    ];
                }

                $legivel = true;
                if (isset($response->cartaoClienteAtivoVendaSeguro) && is_array($response->cartaoClienteAtivoVendaSeguro)) {
                    foreach ($response->cartaoClienteAtivoVendaSeguro as $cartao) {
                        if ($cartao->ehElegivel === false) {
                            $legivel = false;
                            $mensagem = $cartao->motivoElegibilidade;
                        }
                    }
                }

                if (!empty($response->mensagemDeErro)) {
                    $mensagem = $response->mensagemDeErro;
                }

                if (!empty($mensagem) || $legivel === false) {
                    $operations[] = [
                        'cpf' => $this->toUtf8($dado),
                        'plano' => '',
                        'valorPremio' => '',
                        'tipoPagamento' => '',
                        'mensagem' => $this->toUtf8($mensagem)
                    ];
                } else {
                    $clientPlanos = new \SoapClient(BMG_WSDL, ['trace' => 1, 'exceptions' => true]);
                    $paramsPlanos = array_merge($fixParams, $newParams);
                    $responsePlanos = $clientPlanos->__soapCall('listaPlanosRating', [$paramsPlanos]);

                    $planos = $responsePlanos->planos ?? [];
                    $mensagem = empty($planos) ? ($responsePlanos->mensagemDeErro ?? '') : 'Possui planos disponíveis';

                    $parcelados = array_filter($planos, fn($p) => strtolower($p->tipoPagamento) === 'parcelado');
                    $base = !empty($parcelados) ? $parcelados : $planos;

                    $maiorPlano = array_reduce($base, function ($carry, $item) {
                        if ($carry === null) return $item;
                        return $item->valorPremio > $carry->valorPremio ? $item : $carry;
                    });

                    $operations[] = [
                        'cpf' => $this->toUtf8($dado),
                        'plano' => $this->toUtf8($maiorPlano->nomePlano ?? ''),
                        'valorPremio' => $maiorPlano->valorPremio ?? '',
                        'tipoPagamento' => $this->toUtf8($maiorPlano->tipoPagamento ?? ''),
                        'mensagem' => $this->toUtf8($mensagem)
                    ];
                }
            } catch (\SoapFault $fault) {
                $operations[] = [
                    'cpf' => $this->toUtf8($dado),
                    'plano' => '',
                    'valorPremio' => '',
                    'tipoPagamento' => '',
                    'mensagem' => "Erro SOAP: {$fault->faultstring}"
                ];
            }

            // Callback de progresso
            if ($onProgress) {
                $onProgress($index + 1, $total);
            }
        }

        $resultsDir = WRITEPATH . 'jobs/resultados/';
        if (!is_dir($resultsDir)) mkdir($resultsDir, 0777, true);

        $filename = ($jobId ? $jobId . '_' : '') . 'resultado_' . date('Ymd_His') . '.csv';
        $filePath = $resultsDir . $filename;

        $output = fopen($filePath, 'w');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, ['CPF', 'Plano', 'Valor Prêmio', 'Tipo Pagamento', 'Mensagem'], ';');

        foreach ($operations as $op) {
            fputcsv($output, [
                $op['cpf'] ?? '',
                $op['plano'] ?? '',
                $op['valorPremio'] ?? '',
                $op['tipoPagamento'] ?? '',
                $op['mensagem'] ?? ''
            ], ';');
        }

        fclose($output);

        return $filePath;
    }

    // public function gerarMailingSaque(array $dados, ?string $jobId = null, ?callable $onProgress = null)
    public function gerarMailingSaque($cpf)
    {
        // $operations = [];

        // $total = count($dados['cpfs']);

        // foreach ($dados['cpfs'] as $index => $dado) {
        // $cpf = str_pad(preg_replace('/\D/', '', $dado), 11, '0', STR_PAD_LEFT);

        $error = null;

        try {
            $client = new \SoapClient(BMG_SAQUE_WSDL, [
                'trace'      => 1,
                'exceptions' => true
            ]);

            $params = [
                'login'        => BMG_SEGURO_LOGIN,
                'senha'        => BMG_SEGURO_SENHA,
                'codigoEntidade' => 1581,
                'cpf'          => $cpf,
            ];

            $response = $client->__soapCall('buscarCartoesDisponiveis', [$params]);

            // return var_dump($response);

            $newParams = [
                'tipoSaque' => 1,
                'matricula' => $response->cartoesRetorno[0]->matricula,
                'numeroContaInterna' => $response->cartoesRetorno[0]->numeroContaInterna,
            ];

            $paramsPlanos = array_merge($params, $newParams);

            // $params2 = [
            //     'param' => $paramsPlanos
            // ];

            // return var_dump($params2);

            // $responsePlanos = $client->__soapCall('buscarLimiteSaque', [$paramsPlanos]);

            return $paramsPlanos;
        } catch (SoapFault $fault) {
            $error = "Erro: {$fault->faultcode} - {$fault->faultstring}";
        }

        return $error;

        // if ($onProgress) {
        //     $onProgress($index + 1, $total);
        // }
        // }

        // Processar dados e gerar CSV similar ao método gerarMailingSeguro

        // $resultsDir = WRITEPATH . 'jobs/resultados/';
        // if (!is_dir($resultsDir)) mkdir($resultsDir, 0777, true);

        // $filename = ($jobId ? $jobId . '_' : '') . 'resultado_' . date('Ymd_His') . '.csv';
        // $filePath = $resultsDir . $filename;

        // $output = fopen($filePath, 'w');
        // fwrite($output, "\xEF\xBB\xBF");
        // fputcsv($output, ['CPF', 'Plano', 'Valor Prêmio', 'Tipo Pagamento', 'Mensagem'], ';');

        // ////////////// estabelecer formato dos dados no CSV

        // // foreach ($operations as $op) {
        // //     fputcsv($output, [
        // //         $op['cpf'] ?? '',
        // //         $op['plano'] ?? '',
        // //         $op['valorPremio'] ?? '',
        // //         $op['tipoPagamento'] ?? '',
        // //         $op['mensagem'] ?? ''
        // //     ], ';');
        // // }

        // fclose($output);

        // return $filePath;
    }
}
