<?php

namespace App\Controllers\Bmg;

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
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
        $this->m_integraall =  new M_integraall();
        $this->m_argus =  new M_argus();
        $this->m_security = new M_seguranca();
        $this->m_insight = new M_insight();
        $this->m_bmg = new M_bmg();
    }





    //http://localhost/InsightSuite/public/bmg-gravar-proposta
    //https://insightsuite.pravoce.io/bmg-gravar-proposta
    public function bmg_gravar_proposta()
    {
        $request = file_get_contents('php://input');
        $this->telegram->notifyTelegramGroup($request, telegramQuid);

        //DEBUG ONLY
        $request = '{"produto":"MED","cpf":"27265170300","conta":"21345340","plano":"110","codigoTipoPagamento":"2","nome":"NEIDE ROCHA DUARTE ","estadoCivil":"S","sexo":"1","mae":"SEBATIANA ROCHA DUARTE","pai":"","nacionalidade":"","tipoDocumento":"","rg":"","cidadeNascimento":"","dataNascimento":"27/06/1957","ufNascimento":"","dataEmissaoRg":"","orgaoEmissor":"","ufRg":"","email":"","logradouro":"","bairro":"","cep":"","cidade":"","uf":"","numero":"","complemento":"","docIdentidade":"","telefone":"(31)99578-1355"}';
        $response = json_decode($request, true);

        $returnData = [];

        //DEBUG ONLY
        // $response = [
        //     'plano' => '123',
        //     'codigoTipoPagamento' => '2',
        //     'conta' => '456789',

        //     // Dados do cliente
        //     'cidadeNascimento' => 'São Paulo',
        //     'cpf' => '12345678900',
        //     'dataNascimento' => '10/05/1980',
        //     'nome' => 'João da Silva',
        //     'mae' => 'Maria da Silva',
        //     'sexo' => '1', // 1 = Masculino
        //     'ufNascimento' => 'SP',
        //     'estadoCivil' => 'C', // C = Casado
        //     'nacionalidade' => 'Brasileira',
        //     'telefone' => '11987654321',

        //     // Endereço
        //     'bairro' => 'Centro',
        //     'cep' => '01001-000',
        //     'cidade' => 'São Paulo',
        //     'logradouro' => 'Rua Exemplo',
        //     'uf' => 'SP',

        //     // Identidade
        //     'docIdentidade' => '12345678',
        //     'orgaoEmissor' => 'SSP',
        //     'ufRg' => 'SP',
        //     'dataEmissaoRg' => '01/01/2015',

        //     // Outros dados
        //     'plano' => '110', // Exemplo de plano
        //     'produto' => BMG_CODIGO_PRODUTO_MED, // Exemplo de produto
        //     'codigoTipoPagamento' => '2', // Exemplo de código de tipo de pagamento
        //     'conta' => '123456789', // Exemplo de conta

        // ];

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

        // sleep(1);
        // $returnData["mensagem"] = "[EM CONSTRUÇÃO]<br>Proposta Gravada com Sucesso PANORAMA!<br>Número Contrato: 00000";
        // echo json_encode($returnData);
        // return $returnData; exit;

        $request = file_get_contents('php://input');

        //$request = '{"produto":"MED","cpf":"90216296072","conta":"123444","plano":"110","codigoTipoPagamento":"2","nome":"MATHEUS ","estadoCivil":"S","sexo":"1","mae":"SEBATIANA ROCHA DUARTE","pai":"","nacionalidade":"","tipoDocumento":"","rg":"","cidadeNascimento":"","dataNascimento":"27/06/1957","ufNascimento":"","dataEmissaoRg":"","orgaoEmissor":"","ufRg":"","email":"","logradouro":"","bairro":"","cep":"","cidade":"","uf":"","numero":"","complemento":"","docIdentidade":"","telefone":"(31)99578-1355"}';
        $response = json_decode($request, true);
        // $cliData = json_encode($response['dados']);

        //$this->telegram->notifyTelegramGroup("DADOS: " . $request, telegramQuid);
        // exit;


        // $data = [
        //     'CONTRATO' => '123457',
        //     'STATUS' => 'ADESÃO',
        //     'NOME_CLIENTE' => 'IVANILDO GIMENES GOMES',
        //     'ASSESSOR' => 'MATHEUS RYAN PIERRE DE LIMA',
        //     'CPF' => '90216296072',
        //     'ESTADO_CIVIL' => 'SOLTEIRO',
        //     'SEXO' => 'MASCULINO',
        //     'NOMEMAE' => 'LUCILA MERCEDES GOMES II',
        //     'EMAIL' => 'nao_tem@teste.com',
        //     'TELEFONE' => '11960799453',
        //     'LOGRADOURO' => 'Rua Exemplo',
        //     'BAIRRO' => 'Centro',
        //     'CEP' => '01001-000',
        //     'CIDADE' => 'São Paulo',
        //     'UF' => 'SP',
        //     'COMPLEMENTO' => 'Apto 12',
        //     'ENDNUMERO' => '100',
        //     'DATANASCIMENTO' => '12/02/1956',
        //     'MATRICULA' => '10987654321',
        //     'RG' => '1234567',
        //     'TABELA' => 'SEGURO BMG MED',
        //     'DATA_CADASTRO' => '05/05/2025',
        //     'BANCO' => 'BMG',
        //     'PRODUTO' => 'INSS',
        //     'PRAZO' => '1',
        //     'PARCELA' => '1',
        //     'EMPRESTIMO' => '1',
        //     'SEGURO' => '29,9'
        // ];

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
            $returnData["mensagem"] = "Erro ao gravar Panorama:<br>{$e->faultcode} - {$e->faultstring}";;
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


        // $cpf = '10789022320';
        // $conta = '8658088';
        // $plano = 111;
        // $codigoTipoPagamento = 4;
        // $this->m_bmg->geraScriptVenda($cpf, $conta, $plano, $codigoTipoPagamento);
        // exit;

        // stdClass Object
        // (
        //     [login] => 
        //     [senha] => 
        //     [excecaoDeRegraDeNegocio] => 
        //     [excecaoGenerica] => 
        //     [executadoComSucessso] => 1
        //     [mensagemDeErro] => 
        //     [script] => SCRIPT DE AUDITORIA BMG MED INDIVIDUAL Conforme estávamos falando Senhor(a) JOAO FERREIRA LUCAS , meu nome é _________, sou correspondente bancário/a do banco BMG e vamos concluir sua adesão do seguro. Informo que a ligação está sendo gravada. Por favor, poderia me confirmar se este é seu número de celular: (85)987805621? {Pausa resposta}. (Caso o número do telefone esteja incorreto ou não seja um número de celular, fazer a atualização do cadastro) Positivação  Opção 1 Positivação  Opção 2 Ótimo! Agora me confirme os 3 primeiros (ou os 3 últimos) números do seu CPF? {Pausa para a resposta do cliente} CPF: 107.890.223-20 Excelente! Por último me confirme o mês do seu aniversário ?{Pausa para a resposta do cliente} Data Nascimento: 23/04/1957 Ótimo! Agora me confirme sua data de nascimento (Mês/Ano) {Pausa para a resposta do cliente} Data Nascimento: 23/04/1957 Excelente! Por último me confirme o Nome completo da sua Mãe?(Acatar minimamente o nome e sobrenome, não sendo necessário nome completo){Pausa para a resposta do cliente}. Nome da Mãe: LUCIMAR FERREIRA LUCAS O Seguro Bmg MED INDIVIDUAL que você está contratando te dará cobertura em caso de Morte Acidental no valor de R$ 1.000,00, além disso você ainda terá vários outros benefícios que virão incluídos, como: Obs.: Obrigatório citar ao menos um dos benefícios. Consultas ilimitadas de telemedicina com Clínico Geral. Consultas presenciais e exames de baixo custo, pagos pelo segurado. Remédios genéricos com no mínimo 30% de desconto e de marca com mínimo 15%, em rede de farmácias credenciadas Sorteios no valor de R$ 5.000,00 (cinco mil reais) todo mês pela loteria federal Interação Livre Perguntar se o cliente já teve que pagar por consultas particulares. Perguntar se o cliente já teve gastos com compra de medicamento. Perguntar se o cliente já participou de sorteios ou o que faria se ganhasse em algum sorteio. Orientamos que o cliente fale algumas palavras, (evitar respostas sim ou não) Para usufruir de todas as coberturas e benefícios do seguro, pelo período de 12 meses, o Sr(a) pagará o valor de R$ 21,90, que poderá ser mensal (R$ 21,90 cobrado em cada mês) ou parcelado (12 parcelas de R$ 21,90) de acordo com sua escolha. Os benefícios estarão disponíveis em até 24h após aprovação do pagamento em seu cartão. A renovação do seguro será anual, sendo a primeira realizada de forma automática e as demais serão feitas através da corretora de seguros, mediante o seu consentimento. Caso tenha dúvidas, basta entrar em contato com a Central BMG no telefone 4002-7007 Sr(a) JOAO FERREIRA LUCAS , confirma a contratação do seguro BMG MED INDIVIDUAL nesta data 13/05/2025 no valor de R$ 21,90 por mês, por 12 meses de cobertura, que será lançado na fatura do seu cartão consignado BMG? {Pausa para a resposta do cliente} Informamos que o BMG MED INDIVIDUAL é uma parceria entre a Generali Brasil Seguros S.A e a BMG SEGURADORA, e as condições contratuais do seguro serão enviadas para o Sr(a) por SMS e as informações da corretagem estão disponíveis no site do Banco Bmg. Lembramos que o produto não é um seguro saúde, os serviços de assistência são complementares ao seguro de morte acidental. Agradecemos a confiança, bom dia/tarde/noite.
        // )


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

        // $cidadeNascimento = "";
        // $ufNascimento = "";
        // $paisNascimento = "";
        // $email = "";
        // $tipoDocumento = "";
        // $numeroDocumento = "";
        // $dataEmissao = "";
        // $orgaoEmissor = "";
        // $ufEmissor = "";

        $cpf = numberOnly($cpf);
        if ((empty($cpf)) or ($cpf == "0")) {
            $cpf = numberOnly($this->getpost('cpf'));
        }


        //CENÁRIO 01: SALVAR PROPOSTA
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

        //$telefone = "31995781355";
        $data['chat'] = $this->m_insight->getChat(celularToWaId($telefone));
        $data['journey'] = $this->m_insight->getJourney(celularToWaId($telefone));

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
            'PRODUTO' => 'INSS',
            'PRAZO' => $prazo,
            'PARCELA' => $parcelas,
            'EMPRESTIMO' => $valorPlano,
            'SEGURO' => '1'
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
            'SEGURO'
        ];

        $valores = [];

        foreach ($ordem as $campo) {
            $valores[] = isset($data[$campo]) ? $data[$campo] : '';
        }

        $dadosString = implode(';', $valores);

        $url = 'https://grupoquid.panoramaemprestimos.com.br/html.do?action=adicionarOperacao'
            . '&token=44321'
            . '&idImportacao=1466'
            . '&dados=' . urlencode($dadosString);


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
        $ufconta = $this->getpost('ufconta') ?? '';

        $telefone = $this->m_argus->ultimaLigacao(['assessor' => $this->session->nickname]);
        $nomeCliente = $telefone['firstRow']->nome ?? "";

        if ($telefone['existRecord']) {
            $ddd = substr($telefone['firstRow']->celular, 2, 2);
            $telefone = substr($telefone['firstRow']->celular, 4, 9);
        } else {
            $ddd = $this->getpost('ddd') ?? '';
            $telefone = $this->getpost('telefone') ?? '';
        }

        $data['ddd'] = $ddd;
        $data['telefone'] = $telefone;
        $data['nomeCliente'] = $nomeCliente;

        $idBanco = $this->getpost('idBanco') ?? '';
        $agencia = $this->getpost('agencia') ?? '';
        $conta = $this->getpost('conta') ?? '';
        $digito = $this->getpost('digito') ?? '';

        $valorSaque = $this->getpost('valorSaque') ?? '';

        $matricula = $this->getpost('matricula') ?? '';
        $numeroContaInterna = (int) $this->getpost('contaInterna') ?? '';

        if ($this->getpost('btnSaque') === 'salvar') {
            $numeroParcelas = (int) $this->getpost('parcelas') ?? '';
            $valorParcela = (float) $this->getpost('valorParcela') ?? '';

            $dataSaque = [
                "cpf" => $cpf,
                // "ufconta" => $ufconta,
                'celular1' => [
                    'ddd' => $ddd,
                    'numero' => $telefone,
                ],
                "agencia" => ["numero" => $agencia],
                "banco" => ["numero" => (int) $idBanco],
                "conta" => [
                    "numero" => $conta,
                    "digitoVerificador" => $digito,
                ],
                "valorSaque" => (float) $valorSaque,
                'numeroContaInterna' => $numeroContaInterna,
                'matricula' => $matricula,
                'valorParcela' => $valorParcela,
                'numeroParcelas' => $numeroParcelas,
            ];


            $returnData = $this->m_bmg->gravarPropostaSaque($dataSaque);

            $dataPanorama = [
                "cpf" => $cpf,
                'celular1' => [
                    'ddd' => $ddd,
                    'numero' => $telefone,
                ],
                "valorSaque" => $valorSaque,
                'matricula' => $matricula,
                'valorParcela' => $valorParcela,
                'quantidadeParcelas' => $numeroParcelas,
                'nomeCliente' => $this->getpost('nomeCliente'),
                'especie' => $this->getpost('especie'),
                'adesao' => $returnData, //
                'dataNascimento' => $this->getpost('dataNascimento'),
            ];



            if (isset($returnData['erro']) && $returnData['erro']) {
                return redirect()->to(urlInstitucional . 'bmg-saque/0')->with('erro', $returnData['mensagem']);
            } else {
                $propostaPanorama = $this->panorama_gravar_proposta_saque($dataPanorama);

                $database = [
                    'adesao' => $returnData,
                    "cpf" => $cpf,
                    'celular1' => [
                        'ddd' => $ddd,
                        'numero' => $telefone,
                    ],
                    "valorSaque" => $valorSaque,
                    'valorParcela' => $valorParcela,
                    'quantidadeParcelas' => $numeroParcelas,
                    'nomeCliente' => $this->getpost('nomeCliente'),
                    'panorama_id' => $propostaPanorama['proposta']
                ];

                $this->m_bmg->gravar_proposta_bmg_database($database);
            }

            return redirect()->to(urlInstitucional . 'bmg-saque/0')->with('sucesso', $propostaPanorama['mensagem'] . " " . $returnData);
        }

        if ($this->getPost('btnSaque') === 'consultar') {
            $valorSaque = $this->getPost('valorSaque') ?? '';

            $obtemValorParcela = $this->m_bmg->obterValorParcela($valorSaque);
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
        $matricula = $this->getpost('matricula') ?? '';
        $contaInterna = $this->getpost('contaInterna') ?? '';

        $params = [
            'cpf' => $cpf,
            'matricula' => $matricula,
            'contaInterna' => $contaInterna
        ];

        $returnData = $this->m_bmg->obterLimiteSaque($params);

        if (isset($returnData->limite->valorSaqueMaximo)) {
            $valorMaximo = $returnData->limite->valorSaqueMaximo;

            $obtemValorParcela = $this->m_bmg->obterValorParcela($valorMaximo);

            $valorParcela = $obtemValorParcela[0]->valorParcela;
            $dados['valorParcela'] = $valorParcela;
        }

        $dados['cardData'] = $returnData;

        if (isset($returnData->erro) && $returnData->erro) {
            return redirect()->to(urlInstitucional . 'bmg-saque/0')->with('erro', $returnData['mensagem']);
        } else if (!isset($returnData->limite->valorSaqueMaximo)) {
            return redirect()->to(urlInstitucional . 'bmg-saque/0')->with('cardData', $returnData)->with('cpfDigitado', $cpf);
        } else {
            return redirect()->to(urlInstitucional . 'bmg-saque/0')->with('cardData', $returnData)->with('cpfDigitado', $cpf)->with('valorParcela', $valorParcela);
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
}
