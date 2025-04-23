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
use App\Models\M_insight;

class Aaspa extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $m_integraall;
    protected $m_argus;
    protected $m_security;
    protected $m_insight;

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
        $this->m_insight = new M_insight();
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
                    $msg2 = "https://carteirinha.pravoce.io/comecar/id" . $idCliente; 
                    
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

                        // if ($cliente['existRecord']){
                        //     $this->dbMasterDefault->update('aaspa_sms', ['linkKompletoCliente' => $linkAaspa2, 'linkMeeting' => $linkMeeting, 'assessor' => $assessor, 'nomeCliente' => $nomeCompleto, 'status' => 'ATUALIZADO'], ['telefone' => $celularWaId], ['last_update' => 'current_timestamp()']);
                        //     $returnData["status"] = true;
                        //     $returnData["mensagem"] = "SMS já havia sido enviado, link Kompleto atualizado.";

                        // } else {
                            $smsMSG = $this->dbMasterDefault->insert('aaspa_sms',['linkKompletoCliente' => $linkAaspa2, 'linkMeeting' => $linkMeeting, 'assessor' => $assessor, 'nomeCliente' => $nomeCompleto, 'telefone' => $celularWaId, 'status' => 'ENVIADO']);
                            //$msg1 = "Ola $fname, segue o caminho para continuarmos a ligacao:";
                            $msg2 = "Ola $fname, segue seu link https://carteirinha.pravoce.io/comecar/id" . $smsMSG["insert_id"]; strtolower($linkAaspa2);
        
                            //$returnData =  $this->twilio->sendSMS($celularWaId, $msg1, $this->session->nickname);                        
                            $returnData =  $this->twilio->sendSMS($celularWaId, $msg2, $this->session->nickname);                        
                            //$returnData =  $this->twilio->sendSMS($celularWaId, $msg1, $this->session->nickname);
                        // }
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
    public function message_status($messageId){
       $returnData = $this->twilio->messageStatus('WHATSAPP', $messageId);

       echo "<h2>Consulta Mensagem</h2><h3>";
       echo "<br>Status mensagem:<br>" . $returnData["status"][0];
       echo "<br><br>Erro:<br>" . $returnData["erro"];
       echo "<br><br>Data Envio:<br>" . $returnData["data_envio"] . "</h3>";
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
        $cpfINSS = strtoupper($this->getpost('cpfINSS'));

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
        
        $cpf = numberOnly($cpf);
        if ((empty($cpf)) or ($cpf == "0")) { $cpf = numberOnly($this->getpost('cpf'));}

        
        //CENÁRIO 04: SALVAR PROPOSTA BOTÃO SALVAR
        if (!empty($btnSalvar)){
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

            }
        
        //CENÁRIO 01: CPF DIGITADO OU RECEBIDO VIA QUERY OU BOTÃO CONSULTAR CLICADO
        } else if (!empty($cpf)){
            if ((strlen($cpf) != 11)){
                $returnData["mensagem"] = "O CPF deve ser preenchido.";
            } else {
                //VERIFICA HISTÓRICO DE PROPOSTAS NO INTEGRAALL PARA ESSE CPF. 
                //Para seguir, a ultima proposta deve estar cancelada ou não pode existir nenhuma
                $cliente = $this->m_integraall->ultima_proposta($cpf);

                //existe histórico de propostas
                if ($cliente['existRecord']){
                    $statusAdicional = strtoupper($cliente['firstRow']->statusAdicional);
                    $nomeStatus = strtoupper($cliente['firstRow']->nomeStatus);
                    $integraallIdHistorico = strtoupper($cliente['firstRow']->integraallId);
                    
                    //para seguir, a última proposta precisa pelo menos de um status cancelamento, ambos falsos = proposta ativa
                    if ((strpos($statusAdicional,'CANCELA') === false) and (strpos($nomeStatus,'CANCELA') === false)) {
                        $returnData["mensagem"] = "Existe uma proposta em aberto no Integraall [$integraallIdHistorico].<br>Para prosseguir cancele a proposta primeiro.";
                    }
                }
            }

        //CENÁRIO 02: INTEGRAAL ID PASSADO VIA QUERY - OBJETIVO DE LEITURA
        //apenas carregar dados pelo ID, bloquear edição e ocultar botão gravar (consulta apenas)
        } else if (!empty($integraallId)) {
            $this->m_integraall->buscar_propostas($integraallId);
            $cliente = $this->m_integraall->proposta_integraall($integraallId);

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

                $statusId = $cliente['firstRow']->statusId;
                $nomeStatus = $cliente['firstRow']->nomeStatus;

                $statusAdicionalId = $cliente['firstRow']->statusAdicionalId;
                $statusAdicional = $cliente['firstRow']->statusAdicional;

                $integraallId = $cliente['firstRow']->integraallId;
                $linkKompletoCliente = $cliente['firstRow']->linkKompletoCliente;
                $assessor = $cliente['firstRow']->assessor;
                $assessorId = $cliente['firstRow']->assessorId;
                $aaspaCheck = $cliente['firstRow']->aaspaCheck;
                $inssCheck = $cliente['firstRow']->inssCheck;
                $tseCheck = $cliente['firstRow']->tseCheck;
            } else {
                $returnData["mensagem"] = "A proposta $integraallId não foi localizada no Insight";
            }
        }
        
        //CENÁRIO 05: FETCH - BOTÃO ASSPA OU INSS CHECK CHAMADOS VIA PAGELOAD OU CLICK BOTÃO
            //Realizar check no calculadora ou INSS sem gravar draft de proposta


        $data['chat'] = $this->m_insight->getChat($telefoneWaId);
        $data['journey'] = $this->m_insight->getJourney($telefoneWaId);

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

    public function indicadores(){
        $indicadores = [];
        $indicadores['propostas_hoje'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE() AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_ontem'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_7dias'] = $this->dbMaster->runQuery("SELECT COUNT(*) AS total FROM aaspa_propostas WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_30dias'] = $this->dbMaster->runQuery("SELECT COUNT(*) AS total FROM aaspa_propostas WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        //$indicadores['top_indicacao'] = $this->dbMaster->runQuery("select chave_origem, count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE() and chave_origem is not null group by chave_origem order by total desc")['firstRow'];

        return $indicadores;
    }
    
}
