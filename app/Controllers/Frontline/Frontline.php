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
        $this->checkSession();

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

		if (($EventType == 'onConversationStateUpdated') and ($StateFrom == 'active') and ($StateTo == 'closed')) {
			//remove conversas encerradas para evitar de travar as próximas chamadas
			$output = $this->twilio->closeConversation($ChatServiceSid, $ConversationSid);
			$this->dbMasterDefault->insert('record_log',['log' => "onConversationStateUpdated $ConversationSid, $StateFrom, $StateTo - " . json_encode($output)]);

			http_response_code(200);
		} else if (($EventType == 'onParticipantAdded') and (empty($Identity))) {
			//Busca o cliente pelo celular para exibir o nome na conversa
			$cliente = $this->dbMasterDefault->select('aaspa_cliente', ['celular' => numberOnly($From)]);

			$display_name = "CLIENTE LIGAÇÃO";
			if ($cliente['existRecord']){
				$nome = $cliente['firstRow']->nome;
				$cpf = $cliente['firstRow']->cpf;
				$id_proposta = $cliente['firstRow']->id_proposta;
				$display_name = strtoupper($nome) . " - " . $cpf;
			}

			$participants = $this->twilio->participantUpdate($ConversationSid, $ParticipantSid, $id_proposta, $display_name);
			http_response_code(200);
		} else if (($EventType == 'onMessageAdded')) {
			//Faz a busca dos participantes da conversa para logar o histórico da conversa
			$participants = $this->m_twilio->participants($ConversationSid);

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

			//salva mensagem trocada
			$data = (array('MessageSid' => $MessageSid, 'ProfileName' => $Author, 'Body' => $Body, 'SmsStatus' => 'Sent', 'To' => $To, 'WaId' => null, 'From' => numberOnly($From)));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);
		} else if (($EventType == 'onMessageAdd')) {
			$participants = $this->twilio->delete_message($ConversationSid, $MessageSid);
			$Body = strtoupper($Body);
			if (strpos($Body, "CLIENTE:") !== false){
				$extractName = explode(":", $Body);
				$display_name = $extractName[1] ?? "CLIENTE LIGAÇÃO";
				$participants = $this->twilio->participantUpdate($ConversationSid, $ParticipantSid, "1234", $display_name);
				http_response_code(200);

				$this->dbMasterDefault->delete('whatsapp_log', ['MessageSid' => $MessageSid]);
			}
		} else if (($EventType == 'onDeliveryUpdated')) {
			//$this->dbMasterDefault->insert('record_log',['log' => "onDeliveryUpdated $MessageSid, $Status, $ErrorCode"]);
			//$this->dbMasterDefault->update('whatsapp_log', ['SmsStatus' => $Status], ['MessageSid' => $MessageSid], ['last_update' => 'current_timestamp()']);
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
		$clientNumber = celularToWaId($this->getpost('Query'));
		
		//$clientNumber = "5531995781355";
		//$CustomerId = 4;
		//$Location = "GetCustomerDetailsByCustomerId";

		$autoContatoArray = [
			"objects" => [
				"customers" => [
					[
						"customer_id" => $clientNumber,
						"display_name" => "CLIENTE EM LIGAÇÃO",
						"cpf" => "000.000.000-01",
						"telefone" => "+" . $clientNumber,
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
			$channelsEmail = array("type" => "whatsapp", "value" => "whatsapp: +" . $clientNumber);
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
				{ "content": "Olá 👋🏻! Somos da *PRA VOCE* e observamos que recentemente você utilizou nosso site ou WhatsApp. Caso tenha ficado alguma dúvida, responda a essa mensagem para falar com nosso time de atendimento. Desde já agradecemos pela atenção e interesse 🙏🏻!", "whatsAppApproved": true},
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
