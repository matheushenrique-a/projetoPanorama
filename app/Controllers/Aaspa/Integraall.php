<?php

namespace App\Controllers\Aaspa;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_twilio;
use Config\Services;
use App\Models\M_http;
use App\Models\M_integraall;
use App\Models\M_argus;

class Integraall extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $integraall;
    protected $m_argus;
    protected $m_http;
    protected $m_integraall;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        //$this->checkSession();
        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
        $this->m_http =  new M_http();
        $this->m_integraall =  new M_integraall();
        $this->m_argus =  new M_argus();
    }

    
    ///http://localhost/InsightSuite/public/integraall-token
    public function integraall_token(){
        $result = $this->m_integraall->tokenRenew();
        echo '07:57:09 - <h3>Dump 5 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
    }
    
    ///http://localhost/InsightSuite/public/integraall-cep/30575060
    public function cep($cep){
        $cep = numberOnly($cep);
        $result = $this->m_integraall->cep($cep);

        $returnData = array();
        $returnData["cep"] = "";

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            if (isset($retorno['cep'])){
                $returnData["cep"] = $cep;
                $returnData["logradouro"] = strtoupper($retorno['logradouro']);
                $returnData["complemento"] = strtoupper($retorno['complemento']);
                $returnData["unidade"] = strtoupper($retorno['unidade']);
                $returnData["bairro"] = strtoupper($retorno['bairro']);
                $returnData["localidade"] = strtoupper($retorno['localidade']);
                $returnData["uf"] = strtoupper($retorno['uf']);
                $returnData["estado"] = strtoupper($retorno['estado']);
                $returnData["regiao"] = strtoupper($retorno['regiao']);
                $returnData["ibge"] = strtoupper($retorno['ibge']);
                $returnData["gia"] = strtoupper($retorno['gia']);
                $returnData["ddd"] = strtoupper($retorno['ddd']);
                $returnData["siafi"] = strtoupper($retorno['siafi']);
            }
        }
        echo json_encode($returnData);
    }

    ///http://localhost/InsightSuite/public/calculadora-login
    public function calculadora_login(){
        $data = array();
        $data["login"] = 'angelo';
        $data["senha"] = '123456';

        // $data["login"] = 'API_dantas';
        // $data["senha"] = '123456';

        $result = $this->m_integraall->loginCalculadora($data);
        echo '07:57:09 - <h3>Dump 5 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
    }


    ///http://localhost/InsightSuite/public/integraall-detalhes-proposta
    public function detalhes_proposta(){
        $id = 21136;
        $result = $this->m_integraall->detalhesProposta($id);
        echo '07:57:09 - <h3>Dump 5 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
    }


    ///http://localhost/InsightSuite/public/integraall-buscar-propostas/24458
    public function buscar_propostas($integraallId){
        $result = $this->m_integraall->buscar_propostas($integraallId);
        echo json_encode($result);
    }

    //SYNC INTEGRAALL e INSIGHT
    ///http://localhost/InsightSuite/public/integraall-listar-propostas
    ///https://insightsuite.pravoce.io/integraall-listar-propostas
    public function listar_propostas(){
        $filters = ['DataCadastroInicio' => date('Y-m-d 00:00:00', strtotime('-7 days')), 'DataCadastroFim' => date('Y-m-d 23:59:59')]; 
        //$filters = ['TermoDaBusca' => '100.320.817-74']; 
        $result = $this->m_integraall->listarPropostas($filters);

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            if (isset($retorno['qtdResultado']) && $retorno['qtdResultado'] > 0){
                $propostas = $retorno['resultado'];

                $strDelta = "";
                $totalUpdates = 0;

                foreach ($propostas as $proposta){
                    // {
                    //     "id": 24610,
                    //     "nomeCliente": "AILTON DOS SANTOS",
                    //     "cpf": "08251517591",
                    //     "telefonePessoal": "(71)98166-5444",
                    //     "nomeProduto": "AASPA",
                    //     "nomeStatus": "Aguardando Aceite",
                    //     "nomeRevendedor": "QUID PROMOTORA",
                    //     "nomeVendedor": "Maria Luiza Da Silva",
                    //     "statusId": 1,
                    //     "dataCadastro": "2025-03-31T09:29:04",
                    //     "linkKompletoCliente": "https://kompleto.app.br/ASS30377",
                    //     "dataSolicitacaoAtivacao": null,
                    //     "token": "9661ac69c6c553b9dd1d2b36eeba7609449e8d2b882e412898a106a9cb689d63",
                    //     "matricula": "2023226869",
                    //     "tentativas": 0,
                    //     "nomeIndicadorMaster": "Viana Ventures",
                    //     "nomeIndicador": null,
                    //     "nomeGerenteIndicador": null,
                    //     "linkAtivo": true,
                    //     "produtoId": 6,
                    //     "statusAdicional": "Aguardando biometria",
                    //     "statusAdicionalId": 2,
                    //     "revendedorId": 144,
                    //     "vendedorUsuarioId": 1030
                    //   }

                    $data = [
                        'integraallId' => $proposta['id'],
                        "nomeCliente" => $proposta['nomeCliente'],
                        "cpf" => $proposta['cpf'],
                        "telefonepessoal" => $proposta['telefonePessoal'],
                        'nomeStatus' => $proposta['nomeStatus'],
                        'assessor' => $proposta['nomeVendedor'],
                        'statusId' => $proposta['statusId'],
                        'data_criacao' => $proposta['dataCadastro'],
                        'linkKompletoCliente' => $proposta['linkKompletoCliente'],
                        'matricula' => $proposta['matricula'],
                        'linkAtivo' => $proposta['linkAtivo'],
                        'produtoId' => $proposta['produtoId'],
                        'statusAdicional' => $proposta['statusAdicional'],
                        "revendedorId" => $proposta['revendedorId'],
                        "data_ativacao" => $proposta['dataSolicitacaoAtivacao'],
                        "vendedorUsuarioId" => $proposta['vendedorUsuarioId']
                    ];


                    // echo "<br><br>ID: " . $proposta['id'] . "<br>";
                    // echo "Cliente: " . $proposta['nomeCliente'] . "<br>";
                    // echo "cpf: " . $proposta['cpf'] . "<br>";
                    // echo "telefonePessoal: " . $proposta['telefonePessoal'] . "<br>";
                    // echo "nomeProduto: " . $proposta['nomeProduto'] . "<br>";
                    // echo "nomeStatus: " . $proposta['nomeStatus'] . "<br>";
                    // echo "nomeVendedor: " . $proposta['nomeVendedor'] . "<br>";
                    // echo "statusId: " . $proposta['statusId'] . "<br>";
                    // echo "dataCadastro: " . $proposta['dataCadastro'] . "<br>";
                    // echo "linkKompletoCliente: " . $proposta['linkKompletoCliente'] . "<br>";
                    // echo "dataSolicitacaoAtivacao: " . $proposta['dataSolicitacaoAtivacao'] . "<br>";
                    // echo "matricula: " . $proposta['matricula'] . "<br>";
                    // echo "tentativas: " . $proposta['tentativas'] . "<br>";
                    // echo "nomeIndicadorMaster: " . $proposta['nomeIndicadorMaster'] . "<br>";
                    // echo "nomeIndicador: " . $proposta['nomeIndicador'] . "<br>";
                    // echo "linkAtivo: " . $proposta['linkAtivo'] . "<br>";
                    // echo "produtoId: " . $proposta['produtoId'] . "<br>";
                    // echo "statusAdicional: " . $proposta['statusAdicional'] . "<br>";
                    // echo "revendedorId: " . $proposta['revendedorId'] . "<br>";
                    // echo "vendedorUsuarioId: " . $proposta['vendedorUsuarioId'] . "<br>";


                    $propostaIntegraall = $this->dbMasterDefault->select('aaspa_propostas', ['integraallId' => $data['integraallId']]);
                    //echo "Consultando proposta: " . $data['integraallId'] . "<br>";

                    if (!$propostaIntegraall['existRecord']){
                        $added = $this->dbMasterDefault->insert('aaspa_propostas', $data);
                    } else {
                           // echo '14:19:00 - <h3>Dump 30 </h3> <br><br>' . var_dump($propostaIntegraall) ;					//<-------DEBUG

                        $nomeStatusAtual = strtoupper($propostaIntegraall['firstRow']->nomeStatus);
                        $statusAdicionalAtual = strtoupper($propostaIntegraall['firstRow']->statusAdicional);

                        $nomeStatusNovo = strtoupper($data['nomeStatus']);
                        $statusAdicionalNovo = strtoupper($data['statusAdicional']);

                        if (($nomeStatusNovo <> $nomeStatusAtual) or ($statusAdicionalNovo <> $statusAdicionalAtual)){
                            $totalUpdates = $totalUpdates + 1;
                            $strDelta .= "\n\n<b>" . $data['integraallId'] . " | " . substr(strtoupper($data['nomeCliente']), 0, 17) . "...</b>\n";
                            $strDelta .= "🥷🏻 " . substr(strtoupper($data['assessor']), 0, 20) . "...\n";

                            $mudanca = "";
                            if (($nomeStatusAtual != $nomeStatusNovo)) {
                                $mudanca .= "❌ <s>$nomeStatusAtual</s> / ";
                            } else {
                                $mudanca .= "❌ / ";
                            }

                            if (($statusAdicionalAtual != $statusAdicionalNovo)) {
                                $mudanca .= "<s>$statusAdicionalAtual</s>\n";
                            } else {
                                $mudanca .= "\n";
                            }

                            $strDelta .= $mudanca;
                            $strDelta .= "👉 $nomeStatusNovo / $statusAdicionalNovo";

                            //condições da proposta averbada
                            if  (($nomeStatusNovo == 'AGUARDANDO AUDITORIA' and $statusAdicionalNovo == 'AGUARDANDO AVERBAçãO ENTIDADE') 
                            OR ($nomeStatusNovo == 'AGUARDANDO AUDITORIA' and $statusAdicionalNovo == 'AVERBADO GOV.')  
                            OR ($nomeStatusNovo == 'AGUARDANDO AVERBAçãO' and $statusAdicionalNovo == 'AGUARDANDO AVERBAçãO ENTIDADE') 
                            OR ($nomeStatusNovo == 'AGUARDANDO AVERBAçãO' and $statusAdicionalNovo == 'AVERBADO GOV.')) {
                                $strDelta .= "\n\n⭐️⭐️🎉 Proposta aprovada!";
                            }

                            if ($totalUpdates > 10) {
                                $strDelta .= "\n + propostas não listadas.";  
                                break;
                            } 

                        }

                        $updated = $this->dbMasterDefault->update('aaspa_propostas', $data, ['integraallId' => $data['integraallId']]);
                    }
                }

                if (!empty($strDelta)){
                    $strDelta = "♻️♻️♻️ SYNC INTEGRAALL" . $strDelta;
                    $result = $this->telegram->notifyTelegramGroup($strDelta, telegramQuid);
                }
                echo "Resultado: " . $strDelta;
            }
        }
    }
    
    ///http://localhost/InsightSuite/public/calculadora-qualificacao/00001421743
    public function calculadora_qualificacao($cpf = null){
        $this->checkSession();
        $data = array();
        $data["entrada"] = $cpf;
        $data["tipoConsulta"] = 1;

        $result = $this->m_integraall->qualificaCalculadora($data);

        $returnData = array();
        $returnData["cpf"] = $cpf;
        $returnData["status"] = "BLOQUEADO";
        $returnData["color"] = "#f22e46";
        $returnData["beneficio"] = '';

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);

            if (isset($retorno['resultados'])){
                $propostas = $retorno['resultados'];
                foreach ($propostas as $proposta){
                    // echo "<br><br>beneficio: " . $proposta['beneficio'] . "<br>";
                    // echo "bloqueioAssociacao: " . ($proposta['bloqueioAssociacao']  ? 'SIM' : 'NAO')  . "<br>";
                    // echo "especieCodigo: " . $proposta['especieCodigo'] . "<br>";
                    // echo "especieDescricao: " . $proposta['especieDescricao'] . "<br>";
                    // echo "possuiSindicato: " . ($proposta['possuiSindicato']  ? 'SIM' : 'NAO') . "<br>";
                    // echo "status: " . $proposta['status'] . "<br>";
    
                    if (!$proposta['bloqueioAssociacao']){
                        $returnData["status"] = "LIBERADO";
                        $returnData["color"] = "#008001";
                        $returnData["beneficio"] = $proposta['beneficio'];
                        break;
                    }
                }
            }
            
        }

        $dataPropostaInsight = [
            "cpf" => $cpf,
            "assessor" => $this->session->nickname,
            "assessorId" => $this->session->userId,
            "aaspaCheck" => $returnData["status"],
        ];
        
        $propostaAdded = $this->m_integraall->criar_proposta_insight($dataPropostaInsight, ["cpf" => $cpf]);

        echo json_encode($returnData);
    }


    ///http://localhost/InsightSuite/public/integraall-validar-tse/44105517953
    public function validar_tse($cpf){
        $this->checkSession();
        $filters = ['cpf' => $cpf, 'tipo'=> 6];    //tipo 6 = produto AASPA 
        $result = $this->m_integraall->tse($filters);

        //00060677007 cpf com falha

        $returnData = array();
        $returnData["cpf"] = $cpf;
        $returnData["status"] = "BLOQUEADO";
        $returnData["color"] = "#f22e46";
        $returnData["beneficio"] = '';

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            if (isset($retorno['resultado'])){
                $biometria = $retorno['resultado'];
                //"ELEITOR/ELEITORA COM BIOMETRIA COLETADA"
                //ELEITOR/ELEITORA COM BIOMETRIA NÃO COLETADA

                if (strpos($biometria, "NÃO COLETADA") !== false){
                    $returnData["status"] = "BLOQUEADO";
                    $returnData["color"] = "#f22e46";
                    $returnData["beneficio"] = $biometria;
                } else  if (strpos($biometria, "BIOMETRIA COLETADA") !== false){
                    $returnData["status"] = "LIBERADO";
                    $returnData["color"] = "#008001";
                    $returnData["beneficio"] = $biometria;
                }
            } else {
                $returnData["status"] = "FALHA";
                $returnData["color"] = "#f22e46";
            }
        } else {
            $returnData["status"] = "FALHA";
            $returnData["color"] = "#f22e46";
        }

        $dataPropostaInsight = [
            "cpf" => $cpf,
            "assessor" => $this->session->nickname,
            "assessorId" => $this->session->userId,
            "tseCheck" => $returnData["status"],
        ];
        
        $propostaAdded = $this->m_integraall->criar_proposta_insight($dataPropostaInsight, ["cpf" => $cpf]);

        echo json_encode($returnData);
    }
    
    //Vai no INSS validar o CPF
    ///http://localhost/InsightSuite/public/integraall-validar-cpf/15918660810
    ///https://insightsuite.pravoce.io/integraall-validar-cpf/15918660810
    public function validar_cpf($cpf){
        $this->checkSession();
        $filters = ['cpf' => $cpf, 'tipo'=> 6];    //tipo 6 = produto AASPA 
        $result = $this->m_integraall->validarCpf($filters);


        $returnData = array();
        $returnData["cpf"] = $cpf;
        $returnData["status"] = "BLOQUEADO";
        $returnData["color"] = "#f22e46";
        $returnData["beneficio"] = '';

        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            if (isset($retorno['cadastros'])){
                $proposta = $retorno['proposta'];

                foreach ($retorno['cadastros'] as $cadastro){
                    if (!$cadastro['bloqueio']){
                        $returnData["nomeCliente"] = strtoupper($cadastro['nomeCliente']  ?? "");
                        $returnData["cpf"] = $cadastro['cpf'];
                        $returnData["estadoCivil"] = estadoCivilParaNumero((empty($cadastro['estadoCivil'])  ? 'SOLTEIRO' : $cadastro['estadoCivil']));
                        $returnData["sexo"] = sexoParaNumero($cadastro['sexo']);
                        //echo $cadastro['sexo'] . "---" . $returnData["sexo"];exit;
                        $returnData["nomeMae"] = strtoupper($cadastro['nomeMae']  ?? "");
                        $returnData["email"] = trim($cadastro['email']  ?? "");
                        if (empty($returnData['email'])){ $returnData["email"] = strtolower(firstName($returnData["nomeCliente"])) . "@sem_email.com.br"; } 

                        $returnData["telefone"] = $cadastro['telefone'];

                        $ultimaLigacao = $this->m_argus->ultimaLigacao(['cpf' => $cpf]);
                        if ($ultimaLigacao['existRecord']){
                            $returnData["telefone"] = substr($ultimaLigacao['firstRow']->celular, 2);
                        }

                        $returnData["logradouro"] = strtoupper($cadastro['logradouro']  ?? "");
                        $returnData["bairro"] = strtoupper($cadastro['bairro']  ?? "");
                        $returnData["cep"] = $cadastro['cep'];
                        $returnData["cidade"] = strtoupper($cadastro['cidade']  ?? "");
                        $returnData["uf"] = $cadastro['uf'];
                        $returnData["complemento"] = strtoupper($cadastro['complemento']  ?? "");
                        $returnData["endNumero"] = $cadastro['endNumero'];
                        $returnData["dataNascimento"] = dataUsPt($cadastro['dataNascimento'],true);
                       
                        $calculoIdade = meuAniversario( $cadastro['dataNascimento']);
                        $returnData["meuAniversario"] = "Idade atual " . $calculoIdade['idade'] . " anos, faltam " . $calculoIdade['dias'] . " dias para o próximo aniversário";
                       
                        $returnData["matricula"] = $cadastro['matricula'];
                        $returnData["instituidorMatricula"] = $cadastro['instituidorMatricula'];
                        $returnData["orgao"] = $cadastro['orgao'];
                        $returnData["codigoOrgao"] = $cadastro['codigoOrgao'];
                        $returnData["docIdentidade"] = (empty($cadastro['docIdentidade'])  ? $cadastro['cpf'] : $cadastro['docIdentidade']); ;
                        $returnData["docIdentidadeUf"] = $cadastro['docIdentidadeUf'];
                        $returnData["docIdentidadeOrgEmissor"] = $cadastro['docIdentidadeOrgEmissor'];
                        $returnData["bloqueio"] = $cadastro['bloqueio'];

                        $returnData["status"] = "LIBERADO";
                        $returnData["color"] = "#008001";
                        break;
                    }
                }
            }
        }

        $dataPropostaInsight = [
            "cpf" => $cpf,
            "assessor" => $this->session->nickname,
            "assessorId" => $this->session->userId,
            "inssCheck" => $returnData["status"],
        ];
        
        $propostaAdded = $this->m_integraall->criar_proposta_insight($dataPropostaInsight, ["cpf" => $cpf]);

        echo json_encode($returnData);
    }
    
}
