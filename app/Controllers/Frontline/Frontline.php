<?php

namespace App\Controllers\Frontline;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_twilio;
use Config\Services;

class Frontline extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        //parent::setDB("fgtsDB"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        //$this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
    }

	//CONVADDED
	// AccountSid	ACd07f72009069ead82dcf03497b6cb3b1
	// Attributes	{}
	// ChatServiceSid	IS94a7787086f64e4995841c514c96c773
	// ConversationSid	CHe5121ced57664b8988b58135a4e73267
	// DateCreated	2023-04-05T01:48:15.295Z
	// EventType	onParticipantAdded
	// MessagingBinding.Address	whatsapp:+557781597780
	// MessagingBinding.ProxyAddress	whatsapp:+551142002007
	// MessagingBinding.Type	whatsapp
	// ParticipantSid	MB1746ece4d17c4fae9c9dc7cc4793aeba
	// RetryCount	0
	// RoleSid	RL6fc139425b7d426aa8cad04a019d4c97
	// Source	WHATSAPP	

	//RECEIVING A MESSAGE
	// AccountSid	ACd07f72009069ead82dcf03497b6cb3b1
	// Attributes	{"messageId":"PFKtt4Hp74-tZTuIeaLCd"}
	// Author	dantas@pravoce.io
	// Body	Tchau
	// ChatServiceSid	IS94a7787086f64e4995841c514c96c773
	// ClientIdentity	dantas@pravoce.io
	// ConversationSid	CHa735d9d11d624e1ba6d3d7795a265842
	// DateCreated	2023-01-26T14:26:25.726Z
	// EventType	onMessageAdded
	// Index	11
	// MessageSid	IM911929d7dc03433db1250dfba8e076d7
	// MessagingServiceSid	MGf3b9b1482fbd78f567b2b6533ff35ef6
	// ParticipantSid	MB2cc81d6e603b487b99a259702711d7e9
	//CLOSING CONVERSATION
	// AccountSid	ACd07f72009069ead82dcf03497b6cb3b1
	// ChatServiceSid	IS94a7787086f64e4995841c514c96c773
	// ConversationSid	CHa735d9d11d624e1ba6d3d7795a265842
	// EventType	onConversationStateUpdated
	// MessagingServiceSid	MGf3b9b1482fbd78f567b2b6533ff35ef6
	// Reason	API
	// RetryCount	0
	// Source	API
	// StateFrom	active
	// StateTo	closed
	// StateUpdated	2023-01-26T14:31:41.305Z
	//http://localhost/InsightSuite/public/frontline-conversations-webhook
	//https://insightsuite.pravoce.io/frontline-conversations-webhook
	public function frontline_conversations_webhook(){
		$AccountSid = $this->getpost('AccountSid');
		$MessageSid = $this->getpost('MessageSid');
		$Author = $this->getpost('Author');
		$Body = $this->getpost('Body');
		$ChatServiceSid = $this->getpost('ChatServiceSid');
		$ClientIdentity = $this->getpost('ClientIdentity');
		$ConversationSid = $this->getpost('ConversationSid');
		$EventType = $this->getpost('EventType');
		$ParticipantSid = $this->getpost('ParticipantSid');
		$State = $this->getpost('State');
		$StateFrom = $this->getpost('StateFrom');
		$StateTo = $this->getpost('StateTo');
		$Status = $this->getpost('Status');
		$Media = $this->getpost('Media');
		$Identity = $this->getpost('Identity');		
		$ErrorCode = $this->getpost('ErrorCode');		
		$From = $this->getpost('MessagingBinding_Address');
		$To = $this->getpost('MessagingBinding_ProxyAddress');
		$FriendlyName = $this->getpost('FriendlyName');
		$SmsSid = $this->getpost('SmsSid');
		$SmsStatus = $this->getpost('SmsStatus');


		//$output = $this->telegram->notifyTelegramGroup("clientNumberWaId: $clientNumberWaId, CustomerId: $CustomerId");

		//$participants = $this->twilio->participantUpdate("CH0cba079bd7384d90b70a87651681f6c9", "MB905f02b772ce4ca493af29a047f7a4cc", "01", "DANTAS");
		//exit;

		if (!empty($SmsSid)){
			$this->dbMasterDefault->update('whatsapp_log', ['SmsStatus' => $SmsStatus], ['MessageSid' => $SmsSid], ['last_updated' => 'current_timestamp()']);
		} else if (($EventType == 'onConversationStateUpdated') and ($StateFrom == 'active') and ($StateTo == 'closed')) {
			//remove conversas encerradas para evitar de travar as próximas chamadas
			$output = $this->twilio->closeConversation($ChatServiceSid, $ConversationSid);
			$this->dbMasterDefault->insert('record_log',['log' => "onConversationStateUpdated $ConversationSid, $StateFrom, $StateTo - " . json_encode($output)]);

			http_response_code(200);
		} else if (($EventType == 'onConversationAdded')) {
			
		} else if (($EventType == 'onParticipantAdded') and (empty($Identity))) {

		} else if (($EventType == 'onMessageAdded')) {
			//Faz a busca dos participantes da conversa para logar o histórico da conversa
			$participants = $this->twilio->participants($ConversationSid);

			//Verifica os participantes da conversa para extrair from/to
			foreach ($participants as $record) {
				//identity vazio seriam os clientes
				if (empty($record->identity)){
					//se author é um email indica que origem = Atendente QUID
					if (strpos($Author, "@") !== false){
						$From = $record->messagingBinding["proxy_address"];
						$To = $record->messagingBinding["address"];
					} else {
						$To = $record->messagingBinding["proxy_address"];
						$From = $record->messagingBinding["address"];
					}
					//echo "Quem Mandou: $Author, O que: $Body, De: $From, Para: $To";
					break;
				}
			}

			if (isset($Media[0])){$Body = "audio/photo";}

			http_response_code(200);
			if (strpos($Author, "@") !== false){
				$Author = 'Assessor: ' . substr($Author, 0, 10) . "...";
			} else {
				$Author = 'Cliente';
			}

			//salva mensagem trocada
			$data = (array('MessageSid' => $MessageSid, 'Type' => 'WHATSAPP', 'ProfileName' => $Author, 'Body' => $Body, 'SmsStatus' => 'Gravada', 'To' => numberOnly($To), 'WaId' => null, 'From' => numberOnly($From)));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);
		} else if (($EventType == 'onDeliveryUpdated')) {
			//$this->dbMasterDefault->insert('record_log',['log' => "onDeliveryUpdated $MessageSid, $Status, $ErrorCode"]);
			$this->dbMasterDefault->update('whatsapp_log', ['SmsStatus' => $Status], ['MessageSid' => $MessageSid], ['last_updated' => 'current_timestamp()']);
		}
	}

	//http://localhost/InsightSuite/public/frontline-pre-conversations-webhook
	//https://a613-2804-1b3-6149-9c04-d1cc-cd1c-6041-2e1c.ngrok-free.app/InsightSuite/public/frontline-pre-conversations-webhook
	public function frontline_pre_conversations_webhook(){
		$AccountSid = $this->getpost('AccountSid');
		$MessageSid = $this->getpost('MessageSid');
		$Author = $this->getpost('Author');
		$Body = $this->getpost('Body');
		$ChatServiceSid = $this->getpost('ChatServiceSid');
		$ClientIdentity = $this->getpost('ClientIdentity');
		$ConversationSid = $this->getpost('ConversationSid');
		$EventType = $this->getpost('EventType');
		$ParticipantSid = $this->getpost('ParticipantSid');
		$State = $this->getpost('State');
		$StateFrom = $this->getpost('StateFrom');
		$StateTo = $this->getpost('StateTo');
		$Status = $this->getpost('Status');
		$Media = $this->getpost('Media');
		$Identity = $this->getpost('Identity');		
		$ErrorCode = $this->getpost('ErrorCode');		
		$From = $this->getpost('MessagingBinding_Address');
		$To = $this->getpost('MessagingBinding_ProxyAddress');
		$FriendlyName = $this->getpost('FriendlyName');

		if (($EventType == 'onConversationAdd')) {
			$this->dbMasterDefault->insert('record_log',['log' => "PRE onConversationAdd FriendlyName: " . numberOnly($FriendlyName)]);
			if (strlen(numberOnly($FriendlyName)) == 13){
				$cliente = $this->dbMasterDefault->select('aaspa_cliente', ['celular' => numberOnly($FriendlyName)]);

				$display_name = "CLIENTE LIGAÇÃO";
				$id_proposta = "2025";
				if ($cliente['existRecord']){
					
					$nome = $cliente['firstRow']->nome;
					$cpf = $cliente['firstRow']->cpf;
					$id_proposta = $cliente['firstRow']->id_proposta;
					$display_name = strtoupper($nome) . " | ID" . $id_proposta . " | CPF: " . $cpf;
					$this->dbMasterDefault->insert('record_log',['log' => "onConversationAdd Cliente Existe: $display_name"]);
				} else {
					$this->dbMasterDefault->insert('record_log',['log' => "onConversationAdd Cliente Não  Existe - " . numberOnly($From)]);
				}
				
				$conversationProperties = ['friendly_name' => $display_name,'attributes' => json_encode(['avatar' => $display_name])];

				header('Content-Type: application/json');
				echo json_encode($conversationProperties);
				exit;
			}
			http_response_code(200);
		} else if (($EventType == 'onParticipantAdd') and (empty($Identity))) {
			//Busca o cliente pelo celular para exibir o nome na conversa
			$cliente = $this->dbMasterDefault->select('aaspa_cliente', ['celular' => numberOnly($From)]);

			$display_name = "CLIENTE LIGAÇÃO";
			$id_proposta = "2025";
			if ($cliente['existRecord']){
				
				$nome = $cliente['firstRow']->nome;
				$cpf = $cliente['firstRow']->cpf;
				$id_proposta = $cliente['firstRow']->id_proposta;
				$display_name = strtoupper($nome) . " | ID" . $id_proposta . " | CPF: " . $cpf;
				$this->dbMasterDefault->insert('record_log',['log' => "onParticipantAdded Cliente Existe: $display_name"]);
			} else {
				$this->dbMasterDefault->insert('record_log',['log' => "onParticipantAdded Cliente Não  Existe - " . numberOnly($From)]);
			}

			$participants = $this->twilio->participantUpdate($ConversationSid, $ParticipantSid, $id_proposta, $display_name);
			http_response_code(200);
		}
	}

	//IMPORTANTE: Essa função informa o número para responder mensagens de saída do Frontline
	// ChannelType	whatsapp
	// ChannelValue	whatsapp:+5531995781355
	// CustomerId	4
	// Location	GetProxyAddress
	// Worker	dantas@pravoce.io
	//http://localhost/InsightSuite/public/frontline-outgoing-conversation
	//https://insightsuite.pravoce.io/frontline-outgoing-conversation
	public function frontline_outgoing_conversation(){
		$ChannelType = $this->getpost('ChannelType');
		$ChannelValue = $this->getpost('ChannelValue');
		$Location = $this->getpost('Location');
		
		header('Content-Type: application/json; charset=utf-8');
		$clienteDetail = array ("proxy_address" => "whatsapp:+" . fromWhatsApp);
		echo json_encode($clienteDetail);
	}
    
	//http://localhost/InsightSuite/public/frontline-routing-webhook
	//https://insightsuite.pravoce.io/frontline-routing-webhook
	function frontline_routing_webhook(){
		$Author = $this->getpost('Author');
		$Body = $this->getpost('Body');
		$ChatServiceSid = $this->getpost('ChatServiceSid');
		$ClientIdentity = $this->getpost('ClientIdentity');
		$EventType = $this->getpost('EventType');
		$ParticipantSid = $this->getpost('ParticipantSid');
		$State = $this->getpost('State');
		$StateFrom = $this->getpost('StateFrom');
		$StateTo = $this->getpost('StateTo');
		$Media = $this->getpost('Media');
		$Identity = $this->getpost('Identity');		
		$To = $this->getpost('MessagingBinding_ProxyAddress');
		$MessageSid = $this->getpost('MessageSid');
		$AccountSid = $this->getpost('AccountSid');

		$ConversationSid = $this->getpost('ConversationSid');
		$From = celularToWaId($this->getpost('MessagingBinding_Address'));
		
		$worker = $this->dbMasterDefault->select('aaspa_cliente', ['celular' => $From]);
		if ($worker['existRecord']){
			$workedEmail = $worker['firstRow']->assessor;
		} else {
			$workedEmail = "info@pravoce.io";
		}

		$this->dbMasterDefault->insert('record_log',['log' => "ROUNTING $ConversationSid, $From, $To, $workedEmail"]);

		$this->twilio->routing($ConversationSid, $workedEmail);
		http_response_code(200);
	}


	//QUANDO O CLIENTE É CLICADO NA LISTA
	// CustomerId	C18
	// Location	GetCustomerDetailsByCustomerId
	// Worker	dantas@pravoce.io

	//QUANDO ABRE A LISTA GENÉRICA
	// Location	GetCustomersList
	// PageSize	30
	// Worker	dantas@pravoce.io

	//QUANDO TEM QUERY
	// Location	GetCustomersList
	// PageSize	30
	// Query	STEFA
	// Worker	dantas@pravoce.io

	//http://localhost/InsightSuite/public/frontline-crm-inbound
	//https://insightsuite.pravoce.io/frontline-crm-inbound
	public function frontline_crm_inbound(){
		$Location = $this->getpost('Location');
		$CustomerId = $this->getpost('CustomerId');
		$Worker = $this->getpost('Worker');
		$Anchor = $this->getpost('Anchor');
		$Query = ($this->getpost('Query'));
		$clientNumberWaId = celularToWaId($Query); //retorna 55 + apenas números, 5531995781355
		
		//$clientNumber = "5531995781355";
		//$CustomerId = 4;
		//$Location = "GetCustomerDetailsByCustomerId";
		//$Location = "GetCustomersList";

		$nomeAssessor = $this->dbMasterDefault->select('user_account', ['email' => $Worker])['firstRow']->nickname;
		header('Content-Type: application/json');

		//OCORRE AO ABRIR A LISTA DE CLIENTES OU NUMERO NÃO COMPLETAMENTE DIGITADO
		if (($Location == "GetCustomersList") and (strlen($clientNumberWaId) != 13)) {
			//cliente vazio

			if (!empty($nomeAssessor)){
				$sqlQuery = "SELECT CONCAT(id_proposta, '-', celular) customer_id, nome display_name, cpf, celular telefone FROM aaspa_cliente where assessor = '$nomeAssessor' ORDER BY data_criacao DESC LIMIT 50;";		
				//echo $sqlQuery;exit;	
				$cliente = $this->dbMasterDefault->runQuery($sqlQuery);
				$clientes = $cliente["result"]->getResultArray();
	
				$autoContatoArray = [
					"objects" => [
						"customers" => $clientes, "searchable" => true
					]
				];

			} else {
				$autoContatoArray = [
					"objects" => [
						"customers" => [
							[
							"customer_id" => "N/A",
							"display_name" => "DIGITE O TELEFONE",
							"cpf" => "000.000.000-01",
							"telefone" => "",
							"email" => "",
							]
					], "searchable" => true
					]
				];
			}


			echo json_encode($autoContatoArray);


		//OCORRE AO ABRIR A LISTA DE CLIENTES E TODOS OS DIGITOS DO TELEFONE FORAM DIGITADOS 55+11 =13 DIGITOS
		} else if (($Location == "GetCustomersList") and (strlen($clientNumberWaId) == 13)) {
			$cliente = $this->dbMasterDefault->select('aaspa_cliente', ['celular' => $clientNumberWaId]);

			if ($cliente['existRecord']){
				$nome = $cliente['firstRow']->nome;
				$cpf = $cliente['firstRow']->cpf;
				$id_proposta = $cliente['firstRow']->id_proposta;

				$autoContatoArray = [
					"objects" => [
						"customers" => [
							[
								"customer_id" => $id_proposta . "-" . $clientNumberWaId,
								"display_name" => $nome . " | " . formatarTelefone($clientNumberWaId),
								"cpf" => $cpf,
								"telefone" => "+" . $clientNumberWaId,
								"email" => "",
							]
							], "searchable" => true
					]
				];
			} else {
				$autoContatoArray = [
					"objects" => [
						"customers" => [
							[
								"customer_id" => $clientNumberWaId,
								"display_name" => "CONTATO DIRETO: " . formatarTelefone($clientNumberWaId),
								"cpf" => "",
								"telefone" => "+" . $clientNumberWaId,
								"email" => "",
							]
							], "searchable" => true
					]
				];
			}
			echo json_encode($autoContatoArray);
		
		
		//OCORRE AO SE CLICAR SOBRE UM CLIENTE JÁ LOCALIZADO NA LISTA
		} else if (($Location = "GetCustomerDetailsByCustomerId") and (!empty($CustomerId))) {
		
			$clientNumberWaId = $CustomerId; //HERDA O TELEFONE DO ID DO CLIENTE

			if (strlen($clientNumberWaId) == 13){ //INDICA QUE O ID DO CLIENTE É O PROPRIO TELEFONE DE 13 DIGITOS
				//Ao clientar em detalhes do cliente, só precisa retornar o telefone
				$channelsWhatsApp = array("type" => "whatsapp", "value" => "whatsapp: +" . $clientNumberWaId);
				$clienteContacts = array ("channels" => array($channelsWhatsApp));

				$autoContatoArray = [
					"customer_id" => $clientNumberWaId,
					"display_name" => "CONTATO DIRETO: " . formatarTelefone($clientNumberWaId),
					"cpf" => "",
					"telefone" => "+" . $clientNumberWaId,
					"email" => "",
				];


				$customerList = json_encode($autoContatoArray + $clienteContacts);
				echo '{
					"objects": {
						"customer": ' . $customerList . '
					}
				}';
			} else if (strpos($CustomerId, "-") !== false){ //INDICA QUE É UM "CÓDIGO-TELEFONE DIGTADO"
				$partes = explode("-", $CustomerId);
				$id_proposta = $partes[0]; 
				$clientNumberWaId = $partes[1];

				$cliente = $this->dbMasterDefault->select('aaspa_cliente', ['id_proposta' => $id_proposta]);

				if ($cliente['existRecord']){
					$nome = strtoupper($cliente['firstRow']->nome);
					$cpf = $cliente['firstRow']->cpf;
					$id_proposta = $cliente['firstRow']->id_proposta;
					
					//Ao clientar em detalhes do cliente, só precisa retornar o telefone
					$channelsWhatsApp = array("type" => "whatsapp", "value" => "whatsapp: +" . $clientNumberWaId);
					$clienteContacts = array ("channels" => array($channelsWhatsApp));

					$autoContatoArray = [
						"customer_id" => $id_proposta . "-" . $clientNumberWaId,
						"display_name" => $nome . " | " . formatarTelefone($clientNumberWaId),
						"cpf" => $cpf,
						"telefone" => "+" . $clientNumberWaId,
						"email" => "",
					];


					$customerList = json_encode($autoContatoArray + $clienteContacts);
					echo '{
						"objects": {
							"customer": ' . $customerList . '
						}
					}';
				}
			}
		}
	}


	public function frontline_crm_inbound_BACKUP(){
		
		$Location = $this->getpost('Location');
		$CustomerId = $this->getpost('CustomerId');
		$Worker = $this->getpost('Worker');
		$Anchor = $this->getpost('Anchor');
		$clientNumber = ($this->getpost('Query'));
		$clientNumberWaId = celularToWaId($clientNumber);
		
		//$clientNumber = "5531995781355";
		//$CustomerId = 4;
		//$Location = "GetCustomerDetailsByCustomerId";

		
		$autoContatoArray = [
			"objects" => [
				"customers" => [
					[
						"customer_id" => $clientNumberWaId,
						"display_name" => "CLIENTE NA LIGAÇÃO",
						"cpf" => "000.000.000-01",
						"telefone" => "+" . $clientNumberWaId,
						"email" => "info@pravoce.io",
					]
					], "searchable" => true
			]
		];

		

		//Busca pelo telefone do cliente sempre vai retornar o proprio telefone já que não existe integração com nenhum CRM - AutoCadastro
		if (empty($CustomerId)){
			$cliente = $this->dbMasterDefault->select('aaspa_cliente', ['celular' => $clientNumber]);

			if ($cliente['existRecord']){
				$nome = $cliente['firstRow']->nome;
				$cpf = $cliente['firstRow']->cpf;
				$id_proposta = $cliente['firstRow']->id_proposta;

				$autoContatoArray = [
					"objects" => [
						"customers" => [
							[
								"customer_id" => $id_proposta,
								"display_name" => $nome,
								"cpf" => $cpf,
								"telefone" => "+" . $clientNumber,
								"email" => "info@pravoce.io",
							]
							], "searchable" => true
					]
				];
			}

			$autoContato = json_encode($autoContatoArray);
			echo $autoContato;
		} else {
			//Ao clientar em detalhes do cliente, só precisa retornar o telefone
			$channelsEmail = array("type" => "whatsapp", "value" => "whatsapp: +" . $CustomerId);
			$clienteContacts = array ("channels" => array($channelsEmail));

			$customerList = json_encode($autoContatoArray + $clienteContacts);
			echo '{
				"objects": {
					"customer": ' . $customerList . '
				}
			}';
		}
	}

	// ConversationSid	CH1dda8e1feb16490197e0668adc722225
	// CustomerId	1
	// Location	GetTemplatesByCustomerId
	// Worker	dantas@pravoce.io
	//http://localhost/InsightSuite/public/frontline-template-inbound
	//https://insightsuite.pravoce.io/frontline-template-inbound
	public function frontline_template_inbound()
	{
		$ConversationSid = $this->getpost('ConversationSid');
		$CustomerId = $this->getpost('CustomerId');
		$Location = $this->getpost('Location');
		$Worker = $this->getpost('Worker');

		$Worker = "AASPA";		
		date_default_timezone_set("America/Sao_Paulo");  
        $h = date('G');

        if($h>=6 && $h<=11){
            $saudacao = "Bom dia";
        } else if($h>=12 && $h<=17) {
            $saudacao = "Boa tarde";
        } else {
            $saudacao = "Boa noite";
        }

		header('Content-Type: application/json; charset=utf-8');
		echo '[
			{
			  "display_name": "AASPA - BOAS VINDAS",
			  "templates": [
				{ "content": "Olá 👋🏻! Para continuar seu atendimento telefônico por aqui clique em CONTINUAR:", "whatsAppApproved": true}

			  ]
			},
			{
			  "display_name": "AASPA - DOCUMENTOS PENDENTES",
			  "templates": [
				{ "content": "Para procedermos com seu atendimento, por genteliza envie uma foto 📸 (frente e verso) do seu *documento de Identidade* ou *Carteira de Motorista (CNH)*."},
			  ]
			}
		  ]';
	}
}
