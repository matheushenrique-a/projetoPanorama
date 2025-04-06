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
use App\Models\M_integraall;
use App\Models\M_argus;
use App\Models\M_seguranca;

class Aaspa extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $m_integraall;
    protected $m_argus;
    protected $m_security;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
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
    }



    public function argus_atendimento_webhook(){
        echo "13:32:22 - Breakpoint 9"; exit;					//<-------DEBUG
        

    }

   

    //http://localhost/InsightSuite/public/aaspa-zapsms
    public function zapsms($celular = null){
        $data['pageTitle'] = "AASPA - Enviar SMS e WhatsApp";

        //DADOS PESSOAIS
        $nomeCompleto = strtoupper($this->getpost('nomeCompleto'));

        if (empty($celular)){
            $celular = $this->getpost('celular');
            $celularWaId = celularToWaId($celular);    
        } else {
            $celular = formatarTelefone($celular);
            $celularWaId = celularToWaId($celular);    
        }
        $fname = firstName($nomeCompleto);

        //$cpf = numberOnly($this->getpost('cpf'));
        $sms = strtoupper($this->getpost('sms'));
        $tipoMensagem = strtoupper($this->getpost('tipoMensagem'));
        $linkAaspa = strtoupper($this->getpost('linkAaspa'));
        $linkAaspa2 = strtoupper($this->getpost('linkAaspa2'));
        $linkAaspa3 = strtoupper($this->getpost('linkAaspa3'));
        $btnSalvar = $this->getpost('btnSalvar');
        $btnConsultar = $this->getpost('btnConsultar');

        $returnData["status"] = false;
		$returnData["mensagem"] = "";

        if (!empty($btnSalvar)){
            if ((strlen($celularWaId) != 13)){
                $returnData["mensagem"] = "O telefone deve conter 11 números. Exemplo 31-99999-9999";
            } else {
                $this->dbMasterDefault->insert('record_log',['log' => "ZAPSMS " . $nomeCompleto . " - " . $celular . " - " . $sms . " - " . $tipoMensagem . " - " . $linkAaspa . " - " . $this->session->nickname]);

                // $cliente = $this->dbMasterDefault->select('aaspa_cliente', ['cpf' => $cpf]);
                // if ($cliente['existRecord']){
                //     $this->dbMasterDefault->update('aaspa_cliente', ['celular' => $celularWaId, 'nome' => $nomeCompleto, 'assessor' => $this->session->email], ['cpf' => $cpf], ['last_update' => 'current_timestamp()']);
                // } else {
                //     $added = $this->dbMasterDefault->insert('aaspa_cliente',['nome' => $nomeCompleto, 'cpf' => $cpf, 'celular' => $celularWaId, 'assessor' => $this->session->email]);
                // }
    
                if ($tipoMensagem == "WPP"){
                    //$this->twilio->sendWhatsApp("Olá 👋🏻! Somos da *PRA VOCE* e observamos que recentemente você utilizou nosso site ou WhatsApp. Caso tenha ficado alguma dúvida, responda a essa mensagem para falar com nosso time de atendimento. Desde já agradecemos pela atenção e interesse 🙏🏻!", $celularWaId);
                    $display_name = $nomeCompleto . " | " . $celular;
                    $returnData = $this->twilio->newConversationWithTemplate($display_name, $celularWaId, $this->session->email);
                    //$returnData =  $this->twilio->sendWhatsAppTemplate("HXc74e559c07f112bb8d75d91d5a47c087", $celularWaId); //HX813435d38d3962826c91ae0736608191 = Olá, tudo bem? Vamos prosseguir com seu atendimento telefônico por aqui. Para continuar, responda SIM abaixo.
                } 
                    
                if ($tipoMensagem == "WPP-MANUAL"){
                    
                    $linkMeeting = $this->session->parameters["google-meeting"];
                    $assessor = $this->session->nickname;
                    $fname = firstName($nomeCompleto);

                    $cliente = $this->dbMasterDefault->select('aaspa_sms', ['telefone' => $celularWaId]);

                    if (!$cliente['existRecord']){
                        $smsMSG = $this->dbMasterDefault->insert('aaspa_sms',['linkKompletoCliente' => $linkAaspa3, 'linkMeeting' => $linkMeeting, 'assessor' => $assessor, 'nomeCliente' => $nomeCompleto, 'telefone' => $celularWaId, 'status' => 'ENVIADO']);
                        $idCliente = $smsMSG["insert_id"];
                    } else {
                        $this->dbMasterDefault->update('aaspa_sms', ['linkKompletoCliente' => $linkAaspa3, 'linkMeeting' => $linkMeeting, 'assessor' => $assessor, 'nomeCliente' => $nomeCompleto, 'status' => 'ATUALIZADO'], ['telefone' => $celularWaId], ['last_update' => 'current_timestamp()']);
                        $idCliente = $cliente['firstRow']->id_proposta;
                    }

                    $msg1 = "Ola $fname, segue o caminho para continuarmos a ligacao:";
                    $msg2 = "https://beneficio.pravoce.io/comecar/id" . $idCliente; 
                    
                    $msgTelegram = "ASSESSOR: $assessor \nTELEFONE CLIENTE: $celularWaId \nNOME CLIENTE: $nomeCompleto \nLINK KOMPLETO: $linkAaspa3 \nMENSAGEM SUGERIDA:\n$msg1 \nLINK BENEFICIO:\n$msg2";
                    $this->telegram->notifyTelegramGroup($msgTelegram, telegramQuid);

                    $returnData["status"] = true;
                    $returnData["mensagem"] = "Pedido enviado ao Supervisor.";

                }  else if ($tipoMensagem == "SMS-GOOGLE"){
                    //$linkGoogle = $this->dbMasterDefault->select('user_account', ['nickname' => $this->session->nickname])['firstRow']->observacao;
                    $linkGoogle = $this->session->parameters["google-meeting"];
                    $returnData =  $this->twilio->sendSMS($celularWaId, $linkGoogle, $this->session->nickname);
                } else if ($tipoMensagem == "SMS-AASPA"){
                    if ($linkAaspa == ""){
                        $returnData["mensagem"] = "Informe o link do AASPA";
                    } else {
                        $returnData =  $this->twilio->sendSMS($celularWaId, $linkAaspa, $this->session->nickname);
                    }
                }  else if ($tipoMensagem == "SMS-BENEFICIOS"){
                    if ($linkAaspa2 == ""){
                        $returnData["mensagem"] = "Informe o link do AASPA Benefícios";
                        
                    } else {
                        $linkMeeting = $this->session->parameters["google-meeting"];
                        $assessor = $this->session->nickname;
		                $fname = firstName($nomeCompleto);

                        $cliente = $this->dbMasterDefault->select('aaspa_sms', ['telefone' => $celularWaId]);

                        if ($cliente['existRecord']){
                            $this->dbMasterDefault->update('aaspa_sms', ['linkKompletoCliente' => $linkAaspa2, 'linkMeeting' => $linkMeeting, 'assessor' => $assessor, 'nomeCliente' => $nomeCompleto, 'status' => 'ATUALIZADO'], ['telefone' => $celularWaId], ['last_update' => 'current_timestamp()']);
                            $returnData["status"] = true;
                            $returnData["mensagem"] = "SMS existente, link Kompleto atualizado.";
                        } else {
                            $smsMSG = $this->dbMasterDefault->insert('aaspa_sms',['linkKompletoCliente' => $linkAaspa2, 'linkMeeting' => $linkMeeting, 'assessor' => $assessor, 'nomeCliente' => $nomeCompleto, 'telefone' => $celularWaId, 'status' => 'ENVIADO']);
                            $msg1 = "Ola $fname, segue o caminho para continuarmos a ligacao:";
                            $msg2 = "https://beneficio.pravoce.io/comecar/id" . $smsMSG["insert_id"]; strtolower($linkAaspa2);
        
                            $returnData =  $this->twilio->sendSMS($celularWaId, $msg2, $this->session->nickname);                        
                            //$returnData =  $this->twilio->sendSMS($celularWaId, $msg1, $this->session->nickname);
                        }
                    }
                }   
            }
        } else if (!empty($btnConsultar)){

        } else {
            if (empty($celular)){
                //PEGA ULTIMA LIGACAO DO ASSESSOR
                $ultimaLigacao = $this->m_argus->ultimaLigacao(['assessor' => $this->session->nickname]);
                if ($ultimaLigacao['existRecord']){
                    $nomeCompleto = $ultimaLigacao['firstRow']->nome;
                    $celular = formatarTelefone($ultimaLigacao['firstRow']->celular);
                    $celularWaId = celularToWaId($ultimaLigacao['firstRow']->celular);
                }
            }
        }

        $chat = null;
        if ((!empty($celular))){
            $db =  $this->dbMasterDefault->getDB();
            $builder = $db->table('whatsapp_log');
            $builder->Like('whatsapp_log.To', $celularWaId); //bug do número 9 no whatsapp
            $builder->orLike('whatsapp_log.From', $celularWaId);
            $builder->orderBy('id', 'DESC');
            $builder->select('*');
            //echo $builder->getCompiledSelect();exit;
            $chat = $this->dbMasterDefault->resultfy($builder->get());
        }
        $data['chat'] = $chat;

        $db =  $this->dbMasterDefault->getDB();
        $builder = $db->table('customer_journey');
        $builder->Where('verificador', $celularWaId);
        $builder->orderBy('id_interaction', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$journey = $this->dbMasterDefault->resultfy($builder->get());
        $data['journey'] = $journey;


        $data['nomeCompleto'] = $nomeCompleto;
        $data['celular'] = $celular;
        $data['linkAaspa'] = $linkAaspa;
        $data['linkAaspa2'] = $linkAaspa2;
        $data['linkAaspa3'] = $linkAaspa3;
        $data['tipoMensagem'] = $tipoMensagem;
        $data['returnData'] = $returnData;
        $data['twilio'] = $this->twilio;
        

        return $this->loadpage('aaspa/zapsms', $data);
    }


    //http://localhost/InsightSuite/public/aaspa-receptivo
    public function receptivo($cpf, $integraallId = null){
        $data['pageTitle'] = "AASPA - Receptivo";

        $btnSalvar = $this->getpost('btnSalvar');
        $btnConsultar = $this->getpost('btnConsultar');
        $nomeCliente = strtoupper($this->getpost('nomeCliente'));
        $estadoCivil = strtoupper($this->getpost('estadoCivil'));
        $sexo = strtoupper($this->getpost('sexo'));
        $nomeMae = strtoupper($this->getpost('nomeMae'));
        $email = strtoupper($this->getpost('email'));
        $telefone = numberOnly(strtoupper($this->getpost('telefone')));
        $telefoneWaId = celularToWaId($telefone);
        $logradouro = strtoupper($this->getpost('logradouro'));
        $bairro = strtoupper($this->getpost('bairro'));
        $cep = strtoupper($this->getpost('cep'));
        $cidade = strtoupper($this->getpost('cidade'));
        $uf = strtoupper($this->getpost('uf'));
        $complemento = strtoupper($this->getpost('complemento'));
        $endNumero = strtoupper($this->getpost('endNumero'));
        $dataNascimento = strtoupper($this->getpost('dataNascimento'));
        $matricula = strtoupper($this->getpost('matricula'));
        $instituidorMatricula = strtoupper($this->getpost('instituidorMatricula'));
        $orgao = strtoupper($this->getpost('orgao'));
        $codigoOrgao = strtoupper($this->getpost('codigoOrgao'));
        $docIdentidade = strtoupper($this->getpost('docIdentidade'));
        $docIdentidadeUf = strtoupper($this->getpost('docIdentidadeUf'));
        $docIdentidadeOrgEmissor = strtoupper($this->getpost('docIdentidadeOrgEmissor'));
        $bloqueio = strtoupper($this->getpost('bloqueio'));

        $returnData["status"] = false;
		$returnData["mensagem"] = "";
        $nomeCompletoUltima = "";
        $celularUltima = "";
        //$integraallId = "";
        $nomeStatus = "";
        $statusId = "";
        $linkKompletoCliente = "";
        $statusAdicional = "";
        $assessor = "";
        $assessorId = "";
        $aaspaCheck = "";
        $inssCheck = "";
        $tseCheck = "";
        $last_update = "";
        $cpfINSS = "";
        $cliente = null;
        
        $cpf = numberOnly($cpf);
        if ((empty($cpf)) or ($cpf == "0")) { $cpf = numberOnly($this->getpost('cpf'));}
        if (empty($cpf)){ $cpf = numberOnly($this->getpost('cpfINSS'));}

        //ao consultar limpa os campos
        if (!empty($btnConsultar)){
            $nomeCliente = "";
            $estadoCivil = "";
            $sexo = "";
            $nomeMae = "";
            $email = "";
            $telefone = "";
            $logradouro = "";
            $bairro = "";
            $cep = "";
            $cidade = "";
            $uf = "";
            $complemento = "";
            $endNumero = "";
            $dataNascimento = "";
            $last_update = "";
            $matricula = "";
            $docIdentidade = "";
            $integraallId = "";
            $nomeStatus = "";
            $statusId = "";
            $linkKompletoCliente = "";
            $statusAdicional = "";
            $assessor = "";
            $assessorId = "";
            $aaspaCheck = "";
            $inssCheck = "";
            $tseCheck = "";
        }

        if ((!empty($integraallId)) and (($integraallId) != 0)){

            $cliente = $this->m_integraall->proposta_integraall($integraallId);
        } else if ((!empty($cpf)) and (strlen($cpf) == 11)){
            $cliente = $this->m_integraall->ultima_proposta($cpf);
        }

        //leitura através do ARGUS receptivo com CPF vindo da QueryString ou botão Consultar
        if (!is_null($cliente)){
            if ($cliente['existRecord']){
                $cpfINSS = $cliente['firstRow']->cpf;
                $nomeCliente = $cliente['firstRow']->nomeCliente;
                $estadoCivil = $cliente['firstRow']->estadoCivil;
                $sexo = $cliente['firstRow']->sexo;
                $nomeMae = $cliente['firstRow']->nomeMae;
                $email = $cliente['firstRow']->emailPessoal;
                $telefone = $cliente['firstRow']->telefonepessoal;
                $logradouro = $cliente['firstRow']->logradouro;
                $bairro = $cliente['firstRow']->bairro;
                $cep = $cliente['firstRow']->cep;
                $cidade = $cliente['firstRow']->cidade;
                $uf = $cliente['firstRow']->uf;
                $complemento = $cliente['firstRow']->complemento;
                $endNumero = $cliente['firstRow']->endNumero;
                $dataNascimento = dataUsPt($cliente['firstRow']->datanascimento);
                $last_update = $cliente['firstRow']->last_update;
                $matricula = $cliente['firstRow']->matricula;
                $docIdentidade = $cliente['firstRow']->docIdentidade;

                $integraallId = $cliente['firstRow']->integraallId;
                $nomeStatus = $cliente['firstRow']->nomeStatus;
                $statusId = $cliente['firstRow']->statusId;
                $linkKompletoCliente = $cliente['firstRow']->linkKompletoCliente;
                $statusAdicional = $cliente['firstRow']->statusAdicional;
                $assessor = $cliente['firstRow']->assessor;
                $assessorId = $cliente['firstRow']->assessorId;
                $aaspaCheck = $cliente['firstRow']->aaspaCheck;
                $inssCheck = $cliente['firstRow']->inssCheck;
                $tseCheck = $cliente['firstRow']->tseCheck;
            }
        } else if ((!empty($cpf)) and (strlen($cpf) != 11)){
            $returnData["mensagem"] = "O CPF deve ser preenchido.";
        }
        
        if (!empty($btnSalvar)){
            if ((strlen($cpf) != 11)){
                $returnData["mensagem"] = "O CPF deve ser preenchido.";
            } else {
                if ($cliente['existRecord']){
                    $integraallId = $cliente['firstRow']->integraallId;
                    $last_update = $cliente['firstRow']->last_update;
                    $nomeStatus = $cliente['firstRow']->nomeStatus;
                    $statusId = $cliente['firstRow']->statusId;
                    $linkKompletoCliente = $cliente['firstRow']->linkKompletoCliente;
                    $statusAdicional = $cliente['firstRow']->statusAdicional;
                    $aaspaCheck = $cliente['firstRow']->aaspaCheck;
                    $inssCheck = $cliente['firstRow']->inssCheck;
                    $tseCheck = $cliente['firstRow']->tseCheck;
                }

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
                    "vendedorUsuarioId" => $session->parameters["integraallId"], //dantas
                ];

                $dataPropostaInsight = [
                    "assessor" => $this->session->nickname,
                    "assessorId" => $this->session->user_id,
                ];
                    
                $propostaAdded = $this->m_integraall->criar_proposta_insight($dataProposta + $dataPropostaInsight);

                $returnData["status"] = true;
                $returnData["mensagem"] = "Proposta atualiza no Insight. Faça edições manualmente no Integraall.";
        
                if (empty($integraallId)) {
                    $result = $this->m_integraall->criar_proposta_integraall($dataProposta);

                    if ($result['sucesso']){
                        $detalhesGravacao = json_decode($result['retorno'], true);
    
                        //quando decode do resultado é vazio indica que não existe json e sim texto puro com erro
                        if (empty($detalhesGravacao)){
                            $returnData["status"] = false;
                            $returnData["mensagem"] = traduzirErroIntegraall($result['retorno']) . "<br>Detalhes: " . (empty($result['retorno'])  ? 'Nenhum detalhe retornado' : $result['retorno']); ;
                        
                        //quando decode do resultado é um array com 1 elemento, indica lista de erros
                        } else if ((is_array($detalhesGravacao)) and (isset($detalhesGravacao[0]))){
                            $returnData["status"] = false;
                            $returnData["mensagem"] = str_replace("Api Kompleto Respondeu", "Revise a proposta:", $detalhesGravacao[0]);
                            $returnData["mensagem"] = str_replace('\r\n', "<br>", $returnData["mensagem"]);
                            $returnData["mensagem"] = str_replace('"', "", $returnData["mensagem"]);
                            $returnData["mensagem"] = str_replace('::', ":", $returnData["mensagem"]);
                        
                        //cenario onde a proposta foi gravada com sucesso
                        } else if (isset($detalhesGravacao['message'])){
                            $returnData["status"] = true;
                            $returnData["mensagem"] = $detalhesGravacao['message'];
    
                            if (isset($detalhesGravacao['data'])){
                                $id = $detalhesGravacao['data']['id'];
                                $token = $detalhesGravacao['data']['token'];
                                $statusId = $detalhesGravacao['data']['status'];
                                $nome = $detalhesGravacao['data']['nome'];
                                if (isset($detalhesGravacao['data']['termos'])){
                                    $termoCliente = $detalhesGravacao['data']['termos']['cliente'];
                                    $termoVendedor = $detalhesGravacao['data']['termos']['vendedor'];
                                }
    
                                if (!empty($id)){
                                    $dataPropostaIntegraall['cpf'] = $cpf;
                                    $dataPropostaIntegraall['integraallId'] = $id;
                                    $dataPropostaIntegraall['statusId'] = $statusId;
                                    $dataPropostaIntegraall['nomeStatus'] = getStatusNomePorId($statusId);
                                    //$dataPropostaIntegraall['token'] = $token;

                                    $propostaAdded = $this->m_integraall->criar_proposta_insight($dataPropostaIntegraall);
                                    $returnData["mensagem"] = "Proposta criar no Insight e Integraall com ID: $id";
                                }
    
                            }
                        //cenário onde o json retorna erro de autorization ou algo de rede (mais baixo nível)
                        } else if (isset($detalhesGravacao['title'])){
                            $returnData["status"] = false;
                            $type = $detalhesGravacao['type'];
                            $title = $detalhesGravacao['title'];
                            $status = $detalhesGravacao['status'];
                            $traceId = $detalhesGravacao['traceId'];
    
                            $returnData["mensagem"] = "Falha geral - " . $detalhesGravacao['title'];
    
                            // Verifica se há erros
                            if (isset($detalhesGravacao['errors']) && is_array($detalhesGravacao['errors'])) {
                                $returnData["mensagem"] .= "<br>Erros encontrados:<br>";
    
                                foreach ($detalhesGravacao['errors'] as $campo => $mensagens) {
                                    $returnData["mensagem"] .= "Campo {$campo}";
                                    foreach ($mensagens as $mensagem) {
                                        $returnData["mensagem"] .=  "- {$mensagem}<br>";
                                    }
                                }
                            } else {
                                $returnData["mensagem"] .=  "<br>Nenhum detalhe informado.";
                            }
                        }
                    }
                }
            }
        } else {
            //PEGA ULTIMA LIGACAO DO ASSESSOR
            $ultimaLigacao = $this->m_argus->ultimaLigacao(['cpf' => $cpf]);
            if ($ultimaLigacao['existRecord']){
                $nomeCompletoUltima = $ultimaLigacao['firstRow']->nome;
                $celularUltima = $ultimaLigacao['firstRow']->celular;
            }
        }


        //CHAT
        $chat = null;
        if ((!empty($celular))){
            $db =  $this->dbMasterDefault->getDB();
            $builder = $db->table('whatsapp_log');
            $builder->Like('whatsapp_log.To', $telefoneWaId); //bug do número 9 no whatsapp
            $builder->orLike('whatsapp_log.From', $telefoneWaId);
            $builder->orderBy('id', 'DESC');
            $builder->select('*');
            //echo $builder->getCompiledSelect();exit;
            $chat = $this->dbMasterDefault->resultfy($builder->get());
        }
        $data['chat'] = $chat;

        //JOURNEY
        $db =  $this->dbMasterDefault->getDB();
        $builder = $db->table('customer_journey');
        $builder->Where('verificador', $telefoneWaId);
        $builder->orderBy('id_interaction', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$journey = $this->dbMasterDefault->resultfy($builder->get());
        $data['journey'] = $journey;

        $data['cpf'] = $cpf;
        $data['cpfINSS'] = $cpfINSS;
        $data['nomeCliente'] = $nomeCliente;
        $data['estadoCivil'] = $estadoCivil;
        $data['sexo'] = $sexo;
        $data['nomeMae'] = $nomeMae;
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

        $data['integraallId'] = $integraallId;
        $data['statusId'] = $statusId;
        $data['nomeStatus'] = $nomeStatus;
        $data['linkKompletoCliente'] = $linkKompletoCliente;
        $data['statusAdicional'] = $statusAdicional;
        $data['assessor'] = $assessor;
        $data['assessorId'] = $assessorId;
        $data['aaspaCheck'] = $aaspaCheck;
        $data['inssCheck'] = $inssCheck;
        $data['tseCheck'] = $tseCheck;
        $data['last_update'] = $last_update;

        $data['nomeCompletoUltima'] = $nomeCompletoUltima;
        $data['celularUltima'] = $celularUltima;

        $data['returnData'] = $returnData;

        return $this->loadpage('aaspa/receptivo', $data);
    }

    //http://localhost/InsightSuite/public/sign-in
    public function listarPropostas(){
        $buscarProp = $this->getpost('buscarProp');

        if (!empty($buscarProp)){
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
            $flag = $this->getpost('flag',false);
               
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
            $flag = $this->getpost('flag',true);
        }

        $flag = (empty($flag) ? 'ACAO' : $flag);
        
        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];
        
        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        //if (!empty($paginas)) $whereCheck['paginas'] = $paginas;
        if (!empty($integraallId)) $likeCheck['integraallId'] = $integraallId;
        if (!empty($celular)) $likeCheck['celular'] = $celular;
        if (!empty($statusPropostaFiltro)) $whereCheck['statusProposta'] = $statusPropostaFiltro;
        if (!empty($nome)) $likeCheck['nome'] = $nome;
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

        return $this->loadpage('aaspa/listar_propostas', $dados);
    }

    public function indicadores(){
        $indicadores = [];
        $indicadores['clicks_campanha'] = $this->dbMaster->runQuery("select count(*) total from campanha_click_count where DATE(last_updated) = CURDATE();")['firstRow']->total;
        $indicadores['clicks_campanha_inbound'] = $this->dbMaster->runQuery("select slug, count(*) total from campanha_click_count where DATE(last_updated) = CURDATE() group by slug order by total desc;")['firstRow'];
        $indicadores['clicks_campanha_ontem'] = $this->dbMaster->runQuery("select count(*) total from campanha_click_count where DATE(last_updated) = DATE_SUB(CURDATE(), INTERVAL 1 DAY);")['firstRow']->total;
        $indicadores['propostas_cadastradas'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE();")['firstRow']->total;
        $indicadores['propostas_cadastradas_ontem'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY);")['firstRow']->total;
        //$indicadores['top_indicacao'] = $this->dbMaster->runQuery("select chave_origem, count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE() and chave_origem is not null group by chave_origem order by total desc")['firstRow'];

        return $indicadores;
    }
    
}
