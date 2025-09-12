<?php

namespace App\Controllers\Bmg;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use Config\Services;
use App\Models\M_argus;
use App\Models\M_seguranca;
use App\Models\M_insight;
use App\Models\M_bmg;

class Bmg extends BaseController
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
        $this->m_argus =  new M_argus();
        $this->m_security = new M_seguranca();
        $this->m_insight = new M_insight();
        $this->m_bmg = new M_bmg();
    }

    public function bmg_gravar_proposta()
    {
        $request = file_get_contents('php://input');

        //DEBUG ONLY
        $request = '{"produto":"MED","cpf":"27265170300","conta":"21345340","plano":"110","codigoTipoPagamento":"2","nome":"NEIDE ROCHA DUARTE ","estadoCivil":"S","sexo":"1","mae":"SEBATIANA ROCHA DUARTE","pai":"","nacionalidade":"","tipoDocumento":"","rg":"","cidadeNascimento":"","dataNascimento":"27/06/1957","ufNascimento":"","dataEmissaoRg":"","orgaoEmissor":"","ufRg":"","email":"","logradouro":"","bairro":"","cep":"","cidade":"","uf":"","numero":"","complemento":"","docIdentidade":"","telefone":"(31)99578-1355"}';
        $response = json_decode($request, true);

        $returnData = [];

        $params = [
            'codigoPlano'  => $response['plano'],
            'codigoSeguro' => BMG_CODIGO_PRODUTO_MED,
            //'codigoTipoBeneficio' => 1, // Apenas se exigido por entidade
            //'matricula'   => '987654321',
            'codigoformaPagamentoProdutoSeguro' => $response['codigoTipoPagamento'], // Ex: 5 = Folha de Pagamento
            'cpfOperadorVendas' => '04035306606',
            'renda'       => 2500.00,
            'numeroInternoConta' => $response['conta'],
            'codigoTipoFormaEnvio' => 0, // 15 = Digital // 0 - Balcao
            'codigoTipoBeneficio' => 41, // Aposentadoria por Idade
            'codigoformaPagamentoProdutoSeguro' => 4, // Cartao de Credito

            'cliente' => [
                'cidadeNascimento' => $response['cidadeNascimento'],
                'cpf' => $response['cpf'],
                'dataNascimento' => dataPtUsT($response['dataNascimento']),
                'nome' => $response['nome'],
                'nomeMae' => $response['mae'],
                'sexo' => $response['sexo'],
                'ufNascimento' => $response['ufNascimento'],
                'estadocivil' => $response['estadoCivil'], // V = Viúvo
                'nacionalidade' => $response['nacionalidade'],

                'pessoaPoliticamenteExposta' => false,
                'celular1' => [
                    'ddd' => substr($response['telefone'], 0, 2),
                    'numero' => substr($response['telefone'], 2, 10),
                    'ramal' => ''
                ],

                'endereco' => [
                    'bairro' => $response['bairro'],
                    'cep' => $response['cep'],
                    'cidade' => $response['cidade'],
                    'logradouro' => $response['logradouro'],
                    'uf' => $response['uf']
                ],

                'identidade' => [
                    'numero' => $response['docIdentidade'],
                    'emissor' => $response['orgaoEmissor'],
                    'uf' => $response['ufRg'],
                    'dataEmissao' => dataPtUsT($response['dataEmissaoRg'])
                ]
            ]
        ];

        //echo json_encode($params);exit;
        $propostaGravada = $this->m_bmg->gravaPropostaSeguro($params);

        if ($propostaGravada['status']) {
            $returnData["status"] = true;
        } else {
            $returnData["status"] = false;
        }

        $returnData["mensagem"] = $propostaGravada['mensagem'];

        $response = $this->m_bmg->gravaPropostaSeguro($response['produto'], $response['cpf'], $response['conta'], $response['plano'], $response['codigoTipoPagamento']);

        echo json_encode($returnData);
    }

    public function panorama_gravar_proposta()
    {

        $returnData["status"] = false;
        $returnData["proposta"] = "";
        $returnData["mensagem"] = "";

        $request = file_get_contents('php://input');

        $response = json_decode($request, true);

        $planoName = '';
        $valorPlano = '';
        $parcelas = "1";

        if ($response['plano'] == 216) {
            $planoName = 'SEGURO BMG VIDA';
            $valorPlano = "29,90";
        } else if ($response['plano'] == 110) {
            $planoName = "SEGURO BMG MED";
            $valorPlano = "21,90";
        } else if ($response['plano'] == 111) {
            $planoName = "SEGURO BMG MED";
            $valorPlano = "21,90";
            $parcelas = "12";
        } else if ($response['plano'] == 112) {
            $planoName = "SEGURO BMG MED";
            $valorPlano = "29,90";
        } else if ($response['plano'] == 212) {
            $planoName = "SEGURO BMG MED";
            $valorPlano = "29,90";
            $parcelas = "12";
        }

        $data = [
            'CONTRATO' => '0001',
            'STATUS' => 'ADESÃO',
            'NOME_CLIENTE' => $response['nome'],
            'ASSESSOR' => $this->session->nickname,
            'CPF' => "90216296072", //$response['cpf'],
            'ESTADO_CIVIL' => $response['estadoCivil'],
            'SEXO' => $response['sexo'],
            'NOMEMAE' => $response['mae'],
            'EMAIL' => $response['email'],
            'TELEFONE' => $response['telefone'],
            'LOGRADOURO' => $response['logradouro'],
            'BAIRRO' => $response['bairro'],
            'CEP' => $response['cep'],
            'CIDADE' => $response['cidade'],
            'UF' => $response['ufNascimento'],
            'COMPLEMENTO' => $response['complemento'],
            'ENDNUMERO' => $response['numero'],
            'DATANASCIMENTO' => $response['dataNascimento'],
            'MATRICULA' => $response['conta'],
            'RG' => $response['rg'],
            'TABELA' => $planoName,
            'DATA_CADASTRO' => date('d/m/Y H:i:s'),
            'BANCO' => 'BMG',
            'PRODUTO' => 'INSS',
            'PRAZO' => '1',
            'PARCELA' => $parcelas,
            'EMPRESTIMO' => '1',
            'SEGURO' => $valorPlano
        ];


        // $this->telegram->notifyTelegramGroup("DADOS: " . json_encode($data), telegramQuid);
        // // exit;

        $ordem = [
            'CONTRATO',
            'STATUS',
            'NOME_CLIENTE',
            'ASSESSOR',
            'CPF',
            'ESTADO_CIVIL',
            'SEXO',
            'NOMEMAE',
            'EMAIL',
            'TELEFONE',
            'LOGRADOURO',
            'BAIRRO',
            'CEP',
            'CIDADE',
            'UF',
            'COMPLEMENTO',
            'ENDNUMERO',
            'DATANASCIMENTO',
            'MATRICULA',
            'RG',
            'TABELA',
            'DATA_CADASTRO',
            'BANCO',
            'PRODUTO',
            'PRAZO',
            'PARCELA',
            'EMPRESTIMO',
            'SEGURO'
        ];

        $valores = [];

        foreach ($ordem as $campo) {
            $valores[] = isset($data[$campo]) ? $data[$campo] : '';
        }

        $dadosString = implode(';', $valores);

        // Monta a URL
        $url = 'https://grupoquid.panoramaemprestimos.com.br/html.do?action=adicionarOperacao'
            . '&token=44321'
            . '&idImportacao=1331'
            . '&dados=' . urlencode($dadosString);


        //echo $url . "<br><br>";exit;


        $output = "";
        try {
            $output = file_get_contents($url);
        } catch (\Exception $e) {
            $returnData["mensagem"] = "Erro ao gravar Panorama:<br>" . $e->getMessage();
        }


        if (isset($output) && (is_numeric($output) && $output > 0)) {
            $returnData["status"] = true;
            $returnData["mensagem"] = "Proposta gravada com sucesso no Panorama.<br>Número proposta:<br><a href='https://grupoquid.panoramaemprestimos.com.br/emprestimoInterno.do?action=exibir&codigo="  . $output . "' target='_blank'>" . $output . "</a>";
            $returnData["proposta"] = $output;

            $dadosGravacao = [
                'cpf' =>  $response['cpf'],
                'assessor' =>  $this->session->nickname,
                'dados' => $url,
                'sistema' => "PANORAMA",
                'produto' => $planoName . " | " . $valorPlano .  " | " . $parcelas,
                'codigoProposta' => $output,
                'retornoGravacao' => "Sucesso",
            ];
            $added = $this->dbMasterDefault->insert('proposta_bmg', $dadosGravacao);
        } else {
            $returnData["mensagem"] = "Erro ao gravar proposta no Panorama:<br>" . $output;
            $dadosGravacao = [
                'cpf' =>  $response['cpf'],
                'assessor' =>  $this->session->nickname,
                'dados' => $url,
                'sistema' => "PANORAMA",
                'produto' => $planoName . " | " . $valorPlano .  " | " . $parcelas,
                'retornoGravacao' => $returnData["mensagem"],
            ];
            $added = $this->dbMasterDefault->insert('proposta_bmg', $dadosGravacao);
        }

        return json_encode($returnData);
    }

    //http://localhost/InsightSuite/public/bmg-script-vendas/MED/62057677753/842216/110/2 //Nao Elegivel Outra Apolice
    public function bmg_script_vendas($produto, $cpf, $conta, $plano, $codigoTipoPagamento)
    {
        $response = $this->m_bmg->geraScriptVenda($produto, $cpf, $conta, $plano, $codigoTipoPagamento);

        if ($response->mensagemDeErro != "") {
            $returnData["status"] = false;
            $returnData["mensagem"] = "SCRIPT INDISPONÍVEL: <br>" . $response->mensagemDeErro;
        } else {
            $returnData["status"] = true;
            $returnData["mensagem"] = "Script gerado com sucesso.";
            $returnData["script"] = $response->script;
        }

        //echo '10:16:26 - <h3>Dump 57 </h3> <br><br>' . var_dump($returnData); exit;					//<-------DEBUG

        echo json_encode($returnData);
    }

    //http://localhost/InsightSuite/public/bmg_receptivo
    public function bmg_receptivo($cpf = null)
    {
        $data['pageTitle'] = "BMG - Receptivo Seguros";

        $btnSalvar = $this->getpost('btnSalvar');
        $btmMEDBMG = $this->getpost('btmMEDBMG');
        $btmMEDPAN = $this->getpost('btmMEDPAN');

        $btnConsultar = $this->getpost('btnConsultar');
        $nomeCliente = strtoupper($this->getpost('nomeCliente'));
        $estadoCivil = strtoupper($this->getpost('estadoCivil'));
        $sexo = strtoupper($this->getpost('sexo'));
        $nomeMae = strtoupper($this->getpost('nomeMae'));
        $nomePai = strtoupper($this->getpost('nomePai'));
        $email = strtoupper($this->getpost('email'));
        $telefone = numberOnly(strtoupper($this->getpost('telefone')));
        $telefoneWaId = celularToWaId($telefone);
        $logradouro = strtoupper($this->getpost('logradouro'));
        $bairro = strtoupper($this->getpost('bairro'));
        $cep = strtoupper($this->getpost('cep'));
        $cidade = strtoupper($this->getpost('cidade'));
        $uf = strtoupper($this->getpost('uf'));
        $paisNascimento = strtoupper($this->getpost('paisNascimento'));
        $complemento = strtoupper($this->getpost('complemento'));
        $endNumero = strtoupper($this->getpost('endNumero'));
        $cidadeNascimento = strtoupper($this->getpost('cidadeNascimento'));
        $dataNascimento = strtoupper($this->getpost('dataNascimento'));
        $ufNascimento = strtoupper($this->getpost('ufNascimento'));
        $matricula = strtoupper($this->getpost('matricula'));
        $instituidorMatricula = strtoupper($this->getpost('instituidorMatricula'));
        $orgao = strtoupper($this->getpost('orgao'));
        $codigoOrgao = strtoupper($this->getpost('codigoOrgao'));
        $docIdentidade = strtoupper($this->getpost('docIdentidade'));
        $docIdentidadeUf = strtoupper($this->getpost('docIdentidadeUf'));
        $docIdentidadeOrgEmissor = strtoupper($this->getpost('docIdentidadeOrgEmissor'));
        $bloqueio = strtoupper($this->getpost('bloqueio'));
        $cpfINSS = strtoupper($this->getpost('cpfINSS'));
        $dataEmissao = strtoupper($this->getpost('dataEmissao'));
        $ufEmissor = strtoupper($this->getpost('ufEmissor'));
        $cidadeNascimento = strtoupper($this->getpost('cidadeNascimento'));
        $orgaoEmissor = strtoupper($this->getpost('orgaoEmissor'));
        $tipoDocumento = strtoupper($this->getpost('tipoDocumento'));
        $numeroDocumento = strtoupper($this->getpost('numeroDocumento'));

        $returnData["status"] = false;
        $returnData["mensagem"] = "";
        $nomeCompletoUltima = "";
        $celularUltima = "";
        $nomeStatus = "";
        $statusId = "";
        $statusAdicional = "";
        $statusAdicionalId = "";
        $linkKompletoCliente = "";
        $assessor = "";
        $assessorId = "";
        $aaspaCheck = "";
        $inssCheck = "";
        $tseCheck = "";
        $last_update = "";
        $cpfINSS = "";
        $cliente = null;
        $bmgLiberadoMED = null;
        $bmgLiberadoVIDA = null;
        $nomeCompleto = "";
        $celular = "";
        $celularWaId = "";
        $celularWaId = "";

        $cpf = numberOnly($cpf);
        if ((empty($cpf)) or ($cpf == "0")) {
            $cpf = numberOnly($this->getpost('cpf'));
        }

        if (!empty($btnSalvar)) {
            $dataProposta = [
                "nomeCliente" => $nomeCliente,
                "cpf" => $cpf,
                "estadoCivil" => (int)$estadoCivil,
                "sexo" => (int)$sexo,
                "nomeMae" => $nomeMae,
                "emailPessoal" => $email,
                "telefonePessoal" => $telefone,
                "logradouro" => $logradouro,
                "bairro" => $bairro,
                "cep" => $cep,
                "cidade" => $cidade,
                "uf" => $uf,
                "complemento" => $complemento,
                "endNumero" => $endNumero,
                "dataNascimento" => str_replace(' ', 'T', dataPtUs($dataNascimento)),
                "matricula" => $matricula,
                "docIdentidade" => $docIdentidade,
                "produtoId" => API_Produto,
                "revendedorId" => API_Revendedor,
                "vendedorUsuarioId" => $this->session->parameters["integraallId"], //dantas
            ];

            $dataPropostaInsight = [
                "assessor" => $this->session->nickname,
                "assessorId" => $this->session->user_id,
            ];

            $returnData = $this->m_integraall->criar_proposta_integraall($dataProposta);

            //Grava proposta no Insight se gravada com sucesso no Integrall
            if ($returnData['status']) {
                $propostaInsight = $dataProposta + $dataPropostaInsight + $returnData['integraall'];

                //Integraall está retornando o código do Kompleto e não do Integraall. Como alternativa busca todas as propostas do CPF e pega a última ate a API ser melhorada.
                $lastIntegraallId = $this->m_integraall->buscaUltimaProposta(['TermoDaBusca' => $cpf]);
                if ($lastIntegraallId != 0) {
                    $returnData['integraall']['integraallId'] = $lastIntegraallId;
                }

                $propostaAdded = $this->m_integraall->criar_proposta_insight($dataProposta + $dataPropostaInsight + $returnData['integraall']);

                $integraallId = $returnData['integraall']['integraallId'];
                $nomeStatus = $returnData['integraall']['nomeStatus'];
                $statusId = $returnData['integraall']['statusId'];

                return redirect()->to('aaspa-receptivo/0/' . $lastIntegraallId);
                exit;
            }
            //GRAVAÇÃO PROOPSTA MED
        } else if (!empty($btmMEDBMG)) {
            $proposta = explode('-', $btmMEDBMG);
            $conta = $proposta[1];
            $plano = $proposta[2];
            $codigoTipoPagamento = $proposta[3];

            $params = [
                'codigoPlano'  => $plano,
                'codigoSeguro' => BMG_CODIGO_PRODUTO_MED,
                //'codigoTipoBeneficio' => 1, // Apenas se exigido por entidade
                'codigoformaPagamentoProdutoSeguro' => $codigoTipoPagamento, // Ex: 5 = Folha de Pagamento
                'cpfOperadorVendas' => '04035306606',
                //'matricula'   => '987654321',
                'renda'       => 2500.00,
                'numeroInternoConta' => $conta,
                'codigoTipoFormaEnvio' => 15, // 15 = Digital
                'codigoTipoBeneficio' => 41, // Aposentadoria por Idade
                'codigoformaPagamentoProdutoSeguro' => 4, // Cartao de Credito

                'cliente' => [
                    'cidadeNascimento' => $cidadeNascimento,
                    'cpf' => $cpf,
                    'dataNascimento' => dataPtUsT($dataNascimento),
                    'nome' => $nomeCliente,
                    'nomeMae' => $nomeMae,
                    'sexo' => $sexo,
                    'ufNascimento' => $ufNascimento,
                    'estadocivil' => $estadoCivil, // V = Viúvo
                    'nacionalidade' => $paisNascimento,

                    'pessoaPoliticamenteExposta' => false, // 15 = Digital
                    'celular1' => [
                        'ddd' => substr($telefone, 0, 2),
                        'numero' => substr($telefone, 2, 10),
                        'ramal' => ''
                    ],

                    'endereco' => [
                        'bairro' => $bairro,
                        'cep' => $cep,
                        'cidade' => $cidade,
                        'logradouro' => $logradouro,
                        'uf' => $uf
                    ],

                    'identidade' => [
                        'numero' => $docIdentidade,
                        'emissor' => $orgaoEmissor,
                        'uf' => $ufEmissor,
                        'dataEmissao' => dataPtUsT($dataEmissao)
                    ]
                ]
            ];

            //echo json_encode($params);exit;
            $propostaGravada = $this->m_bmg->gravaPropostaSeguro($params);

            if ($propostaGravada['status']) {
                $returnData["status"] = true;
            } else {
                $returnData["status"] = false;
            }

            $returnData["mensagem"] = $propostaGravada['mensagem'];
            //CENÁRIO 02: BUSCAR CPF
        } else if (!empty($cpf)) {

            if ((strlen($cpf)) <= 10) {
                $cpf = substr("0000000" . $cpf, -11);
            }

            if ((strlen($cpf) != 11)) {
                $returnData["mensagem"] = "O CPF deve ser preenchido.";
            } else {
                $bmgLiberadoMED = $this->m_bmg->obterCartoesDisponiveis($cpf, BMG_CODIGO_PRODUTO_MED);
                $bmgLiberadoVIDA = $this->m_bmg->obterCartoesDisponiveis($cpf, BMG_CODIGO_PRODUTO_VIDA);
            }
        }



        if ($cpfINSS != $cpf) {
            $nomeCliente = "";
            $estadoCivil = "";
            $sexo = "";
            $nomeMae = "";
            $nomePai = "";
            $email = "";
            $telefone = "";
            $telefoneWaId = "";
            $logradouro = "";
            $bairro = "";
            $cep = "";
            $cidade = "";
            $uf = "";
            $complemento = "";
            $endNumero = "";
            $dataNascimento = "";
            $matricula = "";
            $docIdentidade = "";
            $docIdentidadeUf = "";
            $docIdentidadeOrgEmissor = "";
            $cidadeNascimento = "";
            $ufNascimento = "";
            $paisNascimento = "";
            $email = "";
            $tipoDocumento = "";
            $numeroDocumento = "";
            $dataEmissao = "";
            $orgaoEmissor = "";
            $ufEmissor = "";
        }

        //CENÁRIO 05: FETCH - BOTÃO ASSPA OU INSS CHECK CHAMADOS VIA PAGELOAD OU CLICK BOTÃO
        //Realizar check no calculadora ou INSS sem gravar draft de proposta

        $ultimaLigacao = $this->m_argus->ultimaLigacao(['assessor' => $this->session->nickname]);
        if ($ultimaLigacao['existRecord']) {
            $nomeCompleto = $ultimaLigacao['firstRow']->nome;
            $celular = formatarTelefone($ultimaLigacao['firstRow']->celular);
            $celularWaId = celularToWaId($ultimaLigacao['firstRow']->celular);
        }


        $data['nomeCompleto'] = $nomeCompleto;
        $data['celular'] = $celular;
        $data['celularWaId'] = $celularWaId;

        $data['cidadeNascimento'] = $cidadeNascimento;
        $data['ufNascimento'] = $ufNascimento;
        $data['paisNascimento'] = $paisNascimento;
        $data['tipoDocumento'] = $tipoDocumento;
        $data['numeroDocumento'] = $numeroDocumento;
        $data['dataEmissao'] = $dataEmissao;
        $data['orgaoEmissor'] = $orgaoEmissor;
        $data['ufEmissor'] = $ufEmissor;

        $data['cpf'] = $cpf;
        $data['bmgLiberadoMED'] = $bmgLiberadoMED;
        $data['bmgLiberadoVIDA'] = $bmgLiberadoVIDA;
        $data['cpfINSS'] = $cpfINSS;
        $data['nomeCliente'] = $nomeCliente;
        $data['estadoCivil'] = $estadoCivil;
        $data['sexo'] = $sexo;
        $data['nomeMae'] = $nomeMae;
        $data['nomePai'] = $nomePai;
        $data['email'] = $email;
        $data['telefone'] = $telefone;
        $data['logradouro'] = $logradouro;
        $data['bairro'] = $bairro;
        $data['cep'] = $cep;
        $data['cidade'] = $cidade;
        $data['uf'] = $uf;
        $data['complemento'] = $complemento;
        $data['endNumero'] = $endNumero;
        $data['dataNascimento'] = $dataNascimento;
        $data['matricula'] = $matricula;
        $data['instituidorMatricula'] = $instituidorMatricula;
        $data['orgao'] = $orgao;
        $data['codigoOrgao'] = $codigoOrgao;
        $data['docIdentidade'] = $docIdentidade;
        $data['docIdentidadeUf'] = $docIdentidadeUf;
        $data['docIdentidadeOrgEmissor'] = $docIdentidadeOrgEmissor;
        $data['bloqueio'] = $bloqueio;
        $data['session'] = $this->session;

        $data['integraallId'] = null;

        $data['statusId'] = $statusId;
        $data['nomeStatus'] = $nomeStatus;
        $data['statusAdicionalId'] = $statusAdicionalId;
        $data['statusAdicional'] = $statusAdicional;

        $data['linkKompletoCliente'] = $linkKompletoCliente;

        $data['assessor'] = $assessor;
        $data['assessorId'] = $assessorId;
        $data['aaspaCheck'] = $aaspaCheck;
        $data['inssCheck'] = $inssCheck;
        $data['tseCheck'] = $tseCheck;
        $data['last_update'] = $last_update;

        $data['nomeCompletoUltima'] = $nomeCompletoUltima;
        $data['celularUltima'] = $celularUltima;

        $data['returnData'] = $returnData;

        return $this->loadpage('bmg/receptivo', $data);
    }

    public function panorama_gravar_proposta_saque($params)
    {
        $returnData = [
            "status" => false,
            "proposta" => "",
            "mensagem" => ""
        ];

        $planoName = 'SAQUE ELETRONICO';
        $valorPlano = $params['valorSaque'] ?? '';
        $parcelas = $params['valorParcela'] ?? '';
        $prazo = $params['quantidadeParcelas'] ?? "96";
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

    public function bmg_saque($cpf = null)
    {
        $data['pageTitle'] = "BMG Saque";

        $cpf = $this->getpost('cpf') ?? '';
        $codigoEntidade = $this->getpost('codigoEntidade') ?? '';

        $data['codigoEntidade'] = $codigoEntidade;

        $dddPost = $this->getpost('ddd');
        $telefonePost = $this->getpost('telefone');
        $nomeCliente = $this->getpost('nomeCliente');

        $data['ddd'] = $dddPost;
        $data['telefone'] = $telefonePost;
        $data['nomeCliente'] = $nomeCliente;

        $idBanco = $this->getpost('idBanco');
        $agencia = $this->getpost('agencia');
        $conta = $this->getpost('conta');
        $digito = $this->getpost('digito');

        $valorSaque = $this->getpost('valorSaque') ?? '';

        $matricula = $this->getpost('matricula') ?? '';
        $numeroContaInterna = (int) $this->getpost('contaInterna') ?? '';

        if ($this->getpost('btnSaque') === 'cardSelected') {
            $valorSaqueMaximo = $this->getpost('valorSaqueMaximo');
            $contaInterna = $this->getpost('contaInterna');
            $matricula = $this->getpost('matricula');
            $entidade = $this->getpost('entidade');
            $cpf = $this->getpost('cpf');

            $cardDataJson = $this->request->getPost('cardData');
            $cardData = json_decode($cardDataJson);

            $data['valorSaque'] = $valorSaqueMaximo;
            $data['codigoEntidade'] = $entidade;

            $obtemValorParcela = $this->m_bmg->obterValorParcela($data);
            $valorParcela = $obtemValorParcela[0]->valorParcela;

            return redirect()->to(urlInstitucional . 'bmg-saque/0')
                ->with('contaInterna', $contaInterna)
                ->with('matricula', $matricula)
                ->with('valorParcela', $valorParcela)
                ->with('valorSaque', $valorSaqueMaximo)
                ->with('cpfDigitado', $cpf)
                ->with('cardData', $cardData);
        }

        if ($this->getpost('btnSaque') === 'salvar') {
            $numeroParcelas = (int) $this->getpost('parcelas') ?? '';
            $valorParcela = (float) $this->getpost('valorParcela') ?? '';
            $finalidadeCredito = (int) $this->getpost('finalidadeCredito') ?? 1;
            $digitoAgencia = $this->getpost('digitoAgencia') ?: null;
            $tipoSaque = (int) $this->getpost('tipoSaque');
            $observacao = $this->getpost('observacao') ?? '';

            if (isset($tipoSaque) && $tipoSaque == 1) {
                $tipoSaque = 1;
            } else {
                $tipoSaque = 2;
            }

            $dataSaque = [
                "cpf" => $cpf,
                'celular1' => [
                    'ddd' => $dddPost,
                    'numero' => $telefonePost,
                ],
                "agencia" => [
                    "numero" => $agencia,
                    "digitoVerificador" => $digitoAgencia
                ],
                "banco" => ["numero" => (int) $idBanco],
                "conta" => [
                    "numero" => $conta,
                    "digitoVerificador" => $digito,
                ],
                "finalidadeCredito" => $finalidadeCredito,
                "valorSaque" => (float) $valorSaque,
                'numeroContaInterna' => $numeroContaInterna,
                'codigoEntidade' => $codigoEntidade,
                'tipoSaque' => $tipoSaque,
                'matricula' => $matricula,
                'valorParcela' => $valorParcela,
                'numeroParcelas' => $numeroParcelas,
            ];

            if ($codigoEntidade == "164") {
                $dataSaque['sequencialOrgao'] = "4";
            }

            if ($codigoEntidade == "164" || $codigoEntidade == "4283-1") {
                $dataSaque['codigoSituacaoServidor'] = 2;
            }

            $returnData = $this->m_bmg->gravarPropostaSaque($dataSaque);

            $dataPanorama = [
                "cpf" => $cpf,
                'celular1' => [
                    'ddd' => $dddPost,
                    'numero' => $telefonePost,
                ],
                "produto" => "Saque",
                "valorSaque" => $valorSaque,
                'matricula' => $matricula,
                'valorParcela' => $valorParcela,
                'quantidadeParcelas' => $numeroParcelas,
                'nomeCliente' => $this->getpost('nomeCliente'),
                'especie' => $this->getpost('especie'),
                'adesao' => $returnData,
                'dataNascimento' => $this->getpost('dataNascimento'),
                'codigoEntidade' => $codigoEntidade,
                'observacao' => $observacao
            ];

            if (isset($returnData['erro']) && $returnData['erro']) {
                return redirect()->to(urlInstitucional . 'bmg-saque/0')
                    ->with('erro', $returnData['mensagem'])
                    ->with('contaInterna', $numeroContaInterna)
                    ->with('matricula', $matricula)
                    ->with('valorParcela', $valorParcela)
                    ->with('valorSaque', $valorSaque)
                    ->with('cpfDigitado', $cpf)
                    ->with('codigoEntidade', $codigoEntidade)
                    ->with('ddd', $dddPost)
                    ->with('telefone', $telefonePost)
                    ->with('nomeCliente', $this->getpost('nomeCliente'))
                    ->with('dataNascimento', $this->getpost('dataNascimento'))
                    ->with('banco', $idBanco)
                    ->with('agencia', $agencia)
                    ->with('conta', $conta)
                    ->with('digito', $digito)
                    ->with('especieBeneficio', $this->getpost('especie'))
                    ->with('uf', $this->getpost('uf'));
            } else {
                $propostaPanorama = $this->panorama_gravar_proposta_saque($dataPanorama);

                $database = [
                    'adesao' => $returnData,
                    "cpf" => $cpf,
                    'celular1' => [
                        'ddd' => $dddPost,
                        'numero' => $telefonePost,
                    ],
                    "valorSaque" => $valorSaque,
                    'produto' => "Saque",
                    'valorParcela' => $valorParcela,
                    'quantidadeParcelas' => $numeroParcelas,
                    'nomeCliente' => $this->getpost('nomeCliente'),
                    'panorama_id' => $propostaPanorama['proposta'],
                    'codigo_entidade' => $codigoEntidade,
                    'valor_parcela' => $valorParcela,
                    'numero_parcela' => $numeroParcelas,
                    'matricula' => $matricula,
                    'dataNascimento' => $this->getpost('dataNascimento'),
                    'userId' => $this->session->userId
                ];

                $this->m_bmg->gravar_proposta_bmg_database($database);
            }

            return redirect()->to(urlInstitucional . 'bmg-saque/0')->with('sucesso', $propostaPanorama['mensagem'] . " " . $returnData)->with('panoramaId', $propostaPanorama['proposta'])->with('numeroAdesao', $returnData);
        }

        if ($this->getpost('btnSaque') === 'consultar') {
            $valorSaque = $this->getpost('valorSaque') ?? '';
            $entidade = $this->getpost('codigoEntidade');

            $data['valorSaque'] = $valorSaque;
            $data['codigoEntidade'] = $entidade;

            $obtemValorParcela = $this->m_bmg->obterValorParcela($data);
            $valorParcela = $obtemValorParcela[0]->valorParcela;

            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'ok',
                    'valorParcela' => $valorParcela
                ]);
            }
        }

        if ($this->getpost('consultaCpf') === 'consultaCpf') {
            $cpf = $this->getpost('cpf') ?? '';

            return $this->bmg_limite_saque($cpf);
        }

        return $this->loadpage('bmg/saque', $data);
    }

    public function bmg_limite_saque($cpf)
    {
        $cpf = $this->getpost('cpf') ?? '';
        $entidade = $this->getpost('codigoEntidade');

        $params = [
            'cpf' => $cpf,
            'codigoEntidade' => $entidade
        ];

        if ($entidade == "164") {
            $params['sequencialOrgao'] = '4';
        }

        $returnData = $this->m_bmg->obterLimiteSaque($params);

        $dados['cardData'] = $returnData;

        if (isset($returnData->erro) && $returnData->erro) {
            return redirect()->to(urlInstitucional . 'bmg-saque/0')->with('erro', $returnData->mensagem)
                ->with('codigoEntidade', $entidade);
        }

        if (isset($returnData->cartoes[0]->limite->valorSaqueMaximo) && count($returnData->cartoes) == 1) {
            $valorMaximo = $returnData->cartoes[0]->limite->valorSaqueMaximo;
            $matricula = $returnData->cartoes[0]->cartao->matricula;
            $contaInterna = $returnData->cartoes[0]->cartao->numeroContaInterna;

            $data['valorSaque'] = $valorMaximo;
            $data['codigoEntidade'] = $entidade;

            $obtemValorParcela = $this->m_bmg->obterValorParcela($data);

            $valorParcela = $obtemValorParcela[0]->valorParcela ?? 0;
            $dados['valorParcela'] = $valorParcela;

            return redirect()->to(urlInstitucional . 'bmg-saque/0')
                ->with('cardData', $returnData)
                ->with('cpfDigitado', $cpf)
                ->with('valorParcela', $valorParcela)
                ->with('matricula', $matricula)
                ->with('contaInterna', $contaInterna)
                ->with('valorSaque', $valorMaximo)
                ->with('codigoEntidade', $entidade);
        } elseif (isset($returnData->cartoes) && count($returnData->cartoes) > 1) {
            return redirect()->to(urlInstitucional . 'bmg-saque/0')
                ->with('cardData', $returnData)
                ->with('cpfDigitado', $cpf)
                ->with('codigoEntidade', $entidade);
        } else {
            return redirect()->to(urlInstitucional . 'bmg-saque/0')
                ->with('cardData', $returnData)
                ->with('cpfDigitado', $cpf)
                ->with('codigoEntidade', $entidade);
        }
    }

    //http://localhost/InsightSuite/public/sign-in
    public function listarPropostas()
    {
        $buscarProp = $this->getpost('buscarProp');

        if (!empty($buscarProp)) {
            helper('cookie');
            $cpf = $this->getpost('txtCPF', false);
            $integraallId = $this->getpost('integraallId', false);
            $celular = $this->getpost('celular', false);
            $nome = $this->getpost('txtNome', false);
            $emailPessoal = $this->getpost('emailPessoal', false);
            //echo '22:16:13 - <h3>Dump 87 </h3> <br><br>' . var_dump($emailPessoal); exit;					//<-------DEBUG
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', false);
            $paginas = $this->getpost('paginas', false);
            $operadorFiltro = $this->getpost('operadorFiltro', false);
            $flag = $this->getpost('flag', false);

            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('integraallId', $integraallId);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('emailPessoal', $emailPessoal);
            Services::response()->setCookie('statusPropostaFiltro', $statusPropostaFiltro);
            Services::response()->setCookie('paginas', $paginas);
            Services::response()->setCookie('operadorFiltro', $operadorFiltro);
            Services::response()->setCookie('flag', $flag);

            //$aux = Services::request()->getCookie($valor);	
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $integraallId = $this->getpost('integraallId', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $emailPessoal = $this->getpost('emailPessoal', true);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', true);
            $paginas = $this->getpost('paginas', true);
            $operadorFiltro = $this->getpost('operadorFiltro', true);
            $flag = $this->getpost('flag', true);
        }

        $flag = (empty($flag) ? 'ACAO' : $flag);

        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];

        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        //if (!empty($paginas)) $whereCheck['paginas'] = $paginas;
        if (!empty($integraallId)) $likeCheck['integraallId'] = $integraallId;
        if (!empty($celular)) $likeCheck['telefonepessoal'] = $celular;
        if (!empty($statusPropostaFiltro)) $whereCheck['statusProposta'] = $statusPropostaFiltro;
        $whereCheck['vendedorUsuarioId'] = $this->session->parameters["integraallId"];
        if (!empty($nome)) $likeCheck['nomeCliente'] = $nome;
        if (!empty($emailPessoal)) $likeCheck['emailPessoal'] = $emailPessoal;
        if ($flag == "OPTIN") $whereCheck['Optin_pan'] = "V";

        // if ((count($likeCheck) == 0) and (count($whereCheck) == 0)){
        //     if ($flag == "ADESAO"){
        //         $fasesAdd = getFasesCategory('funil');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     } else if ($flag == "ACAO"){
        //         $fasesAdd = getFasesCategory('acao');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     } else if ($flag == "ACOMPANHAR"){
        //         $fasesAdd = getFasesCategory('acompanhar');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     } else if ($flag == "OCULTAS"){
        //         $fasesAdd = getFasesCategory('fim');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     }
        // }

        //foreach($fasesAdd as $item){echo "'" . $item . "', ";}exit;

        $likeCheck = array("likeCheck" => $likeCheck);

        $paginas = (empty($paginas)  ? 10 : $paginas);
        $this->dbMasterDefault->setLimit($paginas);
        $this->dbMasterDefault->setOrderBy(array('id_proposta', 'DESC'));
        $propostas = $this->dbMasterDefault->select('aaspa_propostas', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

        //INDICADORES
        $dados['indicadores'] = $this->indicadores();

        $dados['pageTitle'] = "AASPA - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['paginas'] = $paginas;
        $dados['integraallId'] = $integraallId;
        $dados['celular'] = $celular;
        $dados['emailPessoal'] = $emailPessoal;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        $dados['operadorFiltro'] = $operadorFiltro;
        $dados['session'] = $this->session;

        return $this->loadpage('aaspa/listar_propostas', $dados);
    }

    public function indicadores()
    {
        $indicadores = [];
        $indicadores['propostas_hoje'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE() AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_ontem'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_7dias'] = $this->dbMaster->runQuery("SELECT COUNT(*) AS total FROM aaspa_propostas WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_30dias'] = $this->dbMaster->runQuery("SELECT COUNT(*) AS total FROM aaspa_propostas WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        //$indicadores['top_indicacao'] = $this->dbMaster->runQuery("select chave_origem, count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE() and chave_origem is not null group by chave_origem order by total desc")['firstRow'];

        return $indicadores;
    }

    public function bmg_cartao($action)
    {
        $dados['pageTitle'] = "BMG Cartão";

        if ($action == "add") {
            $fixParams = [
                'codigoEntidade' => '1581-',
                'codigoServico' => '060',
                'codigoLoja' => BMG_LOJA_UNITY,
                'codigoFormaEnvioTermo' => 15,
                'bancoOrdemPagamento' => 0,
                'login' => BMG_SEGURO_LOGIN,
                'senha' => BMG_SEGURO_SENHA,
                'loginConsig' => BMG_SEGURO_LOGIN_CONSIG,
                'senhaConsig' => BMG_SEGURO_SENHA_CONSIG,
                'inficativoIN100' => false,
                'aberturaContaPagamento' => 0,
                'tipoSaque' => 0
            ];

            $params = [
                'cpf' => $this->getpost('cpf'),
                'matricula' => $this->getpost('matricula'),
                'valorRenda' => (float) str_replace(['.', ','], ['', '.'], $this->getpost('renda')),
                'dataRenda' => $this->getpost('dataRenda'),
                'tipoBenefício' => $this->getpost('tipoBenefício'),
                'Margem' => (float) $this->getpost('Margem'),
                'cliente' => [
                    'cpf' => $this->getpost('cpf'),
                    'nome' => $this->getpost('nomeCliente'),
                    'dataNascimento' => $this->getpost('dataNascimento'),
                    'sexo' => $this->getpost('sexo'),
                    'cidadeNascimento' => $this->getpost('cidadeNascimento'),
                    'ufNascimento' => $this->getpost('ufNascimento'),
                    'nacionalidade' => $this->getpost('nacionalidade'),
                    'grauInstituicao' => $this->getpost('grauInstituicao'),
                    'nomeMae' => $this->getpost('nomeMae'),
                    'nomePai' => $this->getpost('nomePai'),
                    'identidade' => [
                        'numero' => $this->getpost('numeroIdentidade'),
                        'emissor' => $this->getpost('emissor'),
                        'uf' => $this->getpost('ufIdentidade'),
                        'dataEmissao' => $this->getpost('dataEmissao')
                    ],
                    'celular1' => [
                        'ddd' => $this->getpost('ddd'),
                        'telefone' => $this->getpost('telefone')
                    ],
                    'endereco' => [
                        'cep' => $this->getpost('cep'),
                        'logradouro' => $this->getpost('logradouro'),
                        'endNumero' => $this->getpost('endNumero'),
                        'complemento' => $this->getpost('complemento') ?? "",
                        'bairro' => $this->getpost('bairro'),
                        'cidade' => $this->getpost('cidade'),
                        'uf' => $this->getpost('ufEnd')
                    ],
                    'banco' => [
                        'numero' => (int) $this->getpost('idBanco')
                    ],
                    'tipoDomicilio' => (int) $this->getpost('tipoDomicilio'),
                ]
            ] + $fixParams;

            return print_r($params);
        }

        if ($action == "0") {
            return $this->loadpage('bmg/cartao', $dados);
        }
    }
}
