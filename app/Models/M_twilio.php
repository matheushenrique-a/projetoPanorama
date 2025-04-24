<?php
namespace App\Models;

require_once 'twilio/vendor/autoload.php';

use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class m_twilio extends Model {
	protected $dbMasterDefault;

	public function __construct(){
		//$this->dbMaster = new dbMaster();

		 //o dbMasterDefault vai apontar para o banco do InsightSuite
		 $this->dbMasterDefault = new dbMaster();
	}

	

	//SMS Via Twilio
	function sendSMS($telefone, $mensagem, $author = 'INSIGHT'){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$returnData = array();
		$returnData["status"] = true;
		$returnData["mensagem"] = "";
		$returnData["raw"] = null;
		$message = null;
		$messageSid = "";
		
		try {
			$message = $twilio->messages->create("+" . $telefone, ["body" => $mensagem, "from" => "+" . fromWhatsAppSMS, "statusCallback" => rootURL . "frontline-conversations-webhook"]);
			//echo '09:11:00 - <h3>Dump 42 </h3> <br><br>' . var_dump($message); exit;					//<-------DEBUG

			// Suponha que $message seja o objeto retornado pelo Twilio
			$messageSid = $message->sid;
			$status = $message->status;
			$error_code = $message->errorCode; // Pode ser null se não houver erro
			$error_message = $message->errorMessage; // Pode ser null se não houver erro
			$date_created = $message->dateCreated; // Objeto DateTime
			$date_sent = $message->dateSent; // Objeto DateTime ou null

			if ($error_code){
				$returnData["status"] = false;
				$returnData["mensagem"] = "Erro ao enviar SMS - " . $error_message;
			} else {
				$returnData["status"] = true;
				$returnData["mensagem"] = "SMS enviado com sucesso - Status: " . $status;
			}
		} catch (\Exception $e) {
			$returnData["status"] = false;

			if ($e->getCode() == 21614) {
				$returnData["mensagem"] = "O número informado não existe - " . $e->getMessage();
			} else {
				$returnData["mensagem"] = "Erro inesperado: " . $e->getMessage();
			}
		}
		$this->dbMasterDefault->insert('record_log',['log' => "SMS REQUEST $telefone - " . $returnData["mensagem"]]);

		$returnData["raw"] = $message;

		//Registra conversa no histórico
		$data = (array('MessageSid' => $messageSid, 'Type' => 'SMS', 'ProfileName' => $author, 'Body' => $mensagem, 'SmsStatus' => 'Gravada', 'To' => normalizePhone(numberOnly($telefone)), 'WaId' => fromWhatsAppSMS, 'From' => fromWhatsAppSMS));
		$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

		return $returnData;
	}

	function newConversationWithTemplate($display_name, $to, $workedEmail){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$returnData["status"] = false;
		$returnData["mensagem"] = "";

		//echo "$display_name, $to, $workedEmail";exit;
		
		try {
			//criar uma conversa com um participante do whatsapp e outro com o identity
			$conversation = $twilio->conversations->v1->conversationWithParticipants->create(
				[
					"friendlyName" => $display_name,
					"participant" => [
						"{\"messaging_binding\": {\"address\": \"whatsapp:+" . $to . "\", \"proxy_address\": \"whatsapp:+" . fromWhatsApp .  "\"}}",
						"{\"identity\": \"" . $workedEmail . "\"}",
					],
				]
			);
			$returnData["status"] = true;
		} catch (\Exception $e) {
			$returnData["status"] = false;
			$returnData["mensagem"] = "Erro ao criar conversa - " . $e->getMessage();	
		}

		$this->dbMasterDefault->insert('record_log',['log' => "WPP TEMPLATE $to - " . $returnData["mensagem"]]);
		
		//envia uma mensagem para o participante do whatsapp
		$returnData =  $this->sendWhatsAppTemplate(templateAberturaAASPA, $to); //Tudo bem, vamos seguir com sua solicitação por aqui, basta escolher CONTINUAR abaixo:.
	
		$this->dbMasterDefault->insert('record_log',['log' => "WPP TEMPLATE MSG $to - " . $returnData["mensagem"]]);

		return $returnData;
	}

	//mensagens enviadas pelo chatbot
	function sendWhatsApp($body, $to){
		if (whatAppMsg) {
			$sid = TWILIO_ACCOUNT_SID_SMS;
			$token = TWILIO_AUTH_TOKEN_SMS;
			$twilio = new Client($sid, $token);

			$returnData = array();
			$returnData["status"] = true;
			$returnData["mensagem"] = "";
			$returnData["raw"] = null;
			$messaging_service_sid = TWILIO_MESSAGE_SERVICES;
			$message = null;

			try {
				$params = array(       
					"from" => "whatsapp:+" . fromWhatsApp,
					"body" => $body,
					"messagingServiceSid" => $messaging_service_sid
				);

				$message = $twilio->messages->create("whatsapp:+" . $to, $params);
				//echo '15:20:23 - <h3>Dump 59 </h3> <br><br>' . var_dump($message); exit;					//<-------DEBUG

				$messageSid = $message->sid;
				$status = $message->status;
				$body = $message->body;
				$error_code = $message->errorCode; // Pode ser null se não houver erro
				$error_message = $message->errorMessage; // Pode ser null se não houver erro
				$date_created = $message->dateCreated; // Objeto DateTime
				$date_sent = $message->dateSent; // Objeto DateTime ou null
	
				if ($error_code){
					$returnData["status"] = false;
					$returnData["mensagem"] = "Erro ao enviar WhatsApp - " . $error_message;
				} else {
					$returnData["status"] = true;
					$returnData["mensagem"] = "WhatsApp enviado com sucesso - Status: " . $status;
				}
			} catch (\Exception $e) {
				$returnData["status"] = false;
				$returnData["mensagem"] = "Erro inesperado: " . $e->getMessage();
			}

			$this->dbMasterDefault->insert('record_log',['log' => "WPP Enviado $to - " . $returnData["mensagem"]]);

			//echo $returnData["mensagem"];exit;
			
			//Registra conversa no histórico
			$data = (array('MessageSid' => $messageSid, 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'Body' => $body, 'SmsStatus' => 'Gravada', 'To' => normalizePhone($to), 'WaId' => normalizePhone(fromWhatsApp), 'From' => normalizePhone(fromWhatsApp)));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

			return $returnData;
		}
	}

	// //mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	// function sendWhatsApp2($body, $to){
	// 	if (whatAppMsg) {
	// 		$sid = TWILIO_ACCOUNT_SID_SMS;
	// 		$token = TWILIO_AUTH_TOKEN_SMS;
	// 		$twilio = new Client($sid, $token);

	// 		$params = array(       
	// 			"from" => "whatsapp:+" . fromWhatsApp,
	// 			"body" => $body
	// 		);

	// 		$message = $twilio->messages->create("whatsapp:+" . $to, $params);

	// 		//Registra conversa no histórico
	// 		$MessageSid = substr($message, strpos($message, " sid=")+5, -1);
	// 		$data = (array('MessageSid' => $MessageSid, 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'Body' => $body, 'SmsStatus' => 'Gravada', 'To' => normalizePhone($to), 'WaId' => normalizePhone(fromWhatsApp), 'From' => normalizePhone(fromWhatsApp)));
	// 		$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

	// 		return $message;
	// 	}
	// }


	//mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	function sendWhatsAppTemplate($template, $to){
		$body = "";

		if (whatAppMsg) {
			$sid = TWILIO_ACCOUNT_SID_SMS;
			$token = TWILIO_AUTH_TOKEN_SMS;
			$twilio = new Client($sid, $token);

			$returnData = array();
			$returnData["status"] = true;
			$returnData["mensagem"] = "";
			$returnData["raw"] = null;
			$messaging_service_sid = TWILIO_MESSAGE_SERVICES;
			$message = null;

			try {
				//echo $template;exit;
				//$message = $twilio->messages->create("whatsapp:" . $to, ["contentSid" => $template, "from" => "whatsapp:+" . fromWhatsApp]);
				$message = $twilio->messages->create("whatsapp:" . $to, ["messagingServiceSid" => $messaging_service_sid, "contentSid" => $template, "from" => "whatsapp:+" . fromWhatsApp]);

				//echo '15:20:23 - <h3>Dump 59 </h3> <br><br>' . var_dump($message); exit;					//<-------DEBUG

				$messageSid = $message->sid;
				$status = $message->status;
				$body = $message->body;
				//$messaging_service_sid = $message->messaging_service_sid;
				$error_code = $message->errorCode; // Pode ser null se não houver erro
				$error_message = $message->errorMessage; // Pode ser null se não houver erro
				$date_created = $message->dateCreated; // Objeto DateTime
				$date_sent = $message->dateSent; // Objeto DateTime ou null
	
				if ($error_code){
					$returnData["status"] = false;
					$returnData["mensagem"] = "Erro ao enviar WhatsApp - " . $error_message;
				} else {
					$returnData["status"] = true;
					$returnData["mensagem"] = "WhatsApp enviado com sucesso - Status: " . $status;
				}
			} catch (\Exception $e) {
				$returnData["status"] = false;
				$returnData["mensagem"] = "Erro inesperado: " . $e->getMessage();
			}

			$this->dbMasterDefault->insert('record_log',['log' => "WPP Enviado $to - " . $returnData["mensagem"]]);

			//echo $returnData["mensagem"];exit;
			
			//Registra conversa no histórico
			$data = (array('MessageSid' => $messageSid, 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'Body' => "Tudo bem, vamos seguir com sua solicitação por aqui, basta escolher CONTINUAR abaixo:", 'SmsStatus' => 'Gravada', 'To' => normalizePhone($to), 'WaId' => normalizePhone(fromWhatsApp), 'From' => normalizePhone(fromWhatsApp)));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

			return $returnData;
		}
	}

	function routing($conversationSid, $workedEmail){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		try {
			//Manually Adds operator as participant to the Conversation
			$participant =  $twilio->conversations->v1->conversations($conversationSid)->participants->create(["identity" => $workedEmail]);
			//$participant = $twilio->conversations->conversations($conversationSid)->participants->create(["identity" => $workedEmail]);
			$this->dbMasterDefault->insert('record_log',['log' => "ROUTING OK $conversationSid, Worker:$workedEmail"]);
		} catch (Exception $e) {
			$this->dbMasterDefault->insert('record_log',['log' => "ROUTING Error Worker:$workedEmail - " . $e->getMessage()]);
		}
	}

	function delete_message($conversationSid, $messageSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		try {
			$twilio->conversations->v1->conversations($conversationSid)->messages($messageSid)->delete();
		} catch (Exception $e) {
			$this->dbMasterDefault->insert('record_log',['log' => "TWILIO DELETE ERROR Error $conversationSid, $messageSid - " . $e->getMessage()]);
		}
	}

	function participants($ConversationSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);
				
		$participants = $twilio->conversations->v1->conversations($ConversationSid)->participants->read(5);	
		return $participants;
	}


	function message_update($conversationSid, $messageSid, $body){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		try {
			$twilio->conversations->v1->conversations($conversationSid)->messages($messageSid)->update(["body" => $body]);
		} catch (Exception $e) {
			$this->dbMasterDefault->insert('record_log',['log' => "TWILIO UPDATE MSG ERROR Error $conversationSid, $messageSid - " . $e->getMessage()]);
		}
	}

	//remove conversas presas no Frontline
	function closeConversation($service, $conversationId){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);
		
		//echo "$service, $conversationId";exit;
		$outpout = $twilio->conversations->v1->services($service)->conversations($conversationId)->delete();
		return $outpout;
	}

	//remove conversas presas no Frontline
	function messageStatus($type, $messageSid){

		if ($type == "SMS") {
			$sid = TWILIO_ACCOUNT_SID_SMS;
			$token = TWILIO_AUTH_TOKEN_SMS;	
		} else {
			$sid = TWILIO_ACCOUNT_SID_SMS;
			$token = TWILIO_AUTH_TOKEN_SMS;
		}

		$twilio = new Client($sid, $token);

		$returnData = array();
		$returnData["status"] = "INDEFINIDO";
		$returnData["erro"] = "INDEFINIDO";
		$returnData["data_envio"] = "INDEFINIDO";

		try {
			$message = $twilio->messages($messageSid)->fetch();

			$returnData["status"] = traduzirStatusTwilio($message->status);
			$returnData["erro"] = ($message->errorCode ? traduzirErroTwilio($message->errorCode . " - " . $message->errorMessage) : "NENHUM");
			$returnData["data_envio"] = ($message->dateSent ? $message->dateSent->format('d-m-Y H:i:s') : "PENDENTE ENVIO");
			$this->dbMasterDefault->update('whatsapp_log', ['SmsStatus' => $message->status], ['MessageSid' => $messageSid], ['last_updated' => 'current_timestamp()']);

		} catch (\Exception $e) {
			$returnData["status"] = "ERROR CONSULTA";
			$returnData["erro"] = traduzirErroTwilio($e->getMessage());
			$returnData["data_envio"] = "ERROR CONSULTA";
	
			$this->dbMasterDefault->insert('record_log',['log' => "ERRO CONSULTA MESSAGE SID $messageSid - $type" . $e->getMessage()]);
		}
		
		return $returnData;
	}

	function participantUpdate($ConversationSid, $ParticipantSid, $id_proposta, $display_name){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);
		//$data = ["attributes" => json_encode(["avatar" => $display_name, "customer_id" => $id_proposta, "display_name" => $display_name])];

		$data = [
			"identity" => $display_name,
			"attributes" => json_encode([
				"avatar" => $display_name, 
				"customer_id" => $id_proposta, 
				"display_name" => $display_name
			])
		];

		$participants = null;
		try {
			$participants = $twilio->conversations->v1->conversations($ConversationSid)->participants($ParticipantSid)->update($data);	
			//echo '20:56:16 - <h3>Dump 44 </h3> <br><br>' . var_dump($participants); exit;					//<-------DEBUG
			
			$this->dbMasterDefault->insert('record_log',['log' => "PARTICIPANTE SUCESSO $ConversationSid, $ParticipantSid, $id_proposta, $display_name - "]);
		} catch (\Exception $e) {
			$this->dbMasterDefault->insert('record_log',['log' => "PARTICIPANTE ERROR $ConversationSid, $ParticipantSid, $id_proposta, $display_name - " . $e->getMessage()]);
		}
		
		return $participants;
	}

	function users(){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$user = $twilio->frontlineApi->v1->users("MBbc1356caabcf44f7ab49ef172af5d32b")->fetch();
		echo '05:53:36 - <h3>Dump 63 </h3> <br><br>' . var_dump($user); exit;					//<-------DEBUG
	}

	// ChatServiceSid	IS94a7787086f64e4995841c514c96c773
	function FrontLineCleanUp(){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);
		
		$conversations = $twilio->conversations->v1->conversations->read([], 20);

		foreach ($conversations as $record) {
			$out = $record->delete();
			echo ($out . "-" . $record->sid . "-" . $record->friendlyName . "<BR>");
		}

		return $conversations;
	}

	// Recupera detalhes de uma conversation exemplo CHa935531a0e934d78ad47c778e33f9425
	function conversationDetails($conversationSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$conversation = $twilio->conversations->v1->conversations($conversationSid)->fetch();

		// {
		// 	"sid": "CHXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
		// 	"account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"chat_service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"messaging_service_sid": "MGaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"friendly_name": "My First Conversation",
		// 	"unique_name": "first_conversation",
		// 	"attributes": "{ \"topic\": \"feedback\" }",
		// 	"date_created": "2015-12-16T22:18:37Z",
		// 	"date_updated": "2015-12-16T22:18:38Z",
		// 	"state": "active",
		// 	"timers": {
		// 		"date_inactive": "2015-12-16T22:19:38Z",
		// 		"date_closed": "2015-12-16T22:28:38Z"
		// 	},
		// 	"bindings": {},
		// 	"url": "https://conversations.twilio.com/v1/Conversations/CHaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"links": {
		// 		"participants": "https://conversations.twilio.com/v1/Conversations/CHaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Participants",
		// 		"messages": "https://conversations.twilio.com/v1/Conversations/CHaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Messages",
		// 		"webhooks": "https://conversations.twilio.com/v1/Conversations/CHaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Webhooks"
		// 	}
		// 	}
			
		return $conversation;
	}

	// Recupera detalhes de uma conversation exemplo CHa935531a0e934d78ad47c778e33f9425
	function createConversation(){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$conversation = $twilio->conversations->v1->conversations->create(["friendlyName" => "Friendly Conversation",]);
			
		return $conversation;
	}

	// Recupera detalhes de uma conversation exemplo CHa935531a0e934d78ad47c778e33f9425
	function updateConversations($conversationSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$conversation = $twilio->conversations->v1->conversations($conversationSid)->update(["friendlyName" => "Important Customer Question"]);
			
		return $conversation;
	}

	// Adiciona uma msg a uma conversa
	function addMessageToConversations($conversationSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$message = $twilio->conversations->v1->conversations($conversationSid)->messages->create(["subject" => "Boas Vindas", "author" => "smee","body" => "Ahoy there!",]);
		
		//output
		// {
		// 	"sid": "IMaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"conversation_sid": "CHXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
		// 	"body": "Ahoy there!",
		// 	"media": null,
		// 	"author": "smee",
		// 	"participant_sid": "MBaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"attributes": "{ \"importance\": \"high\" }",
		// 	"date_created": "2015-12-16T22:18:37Z",
		// 	"date_updated": "2015-12-16T22:18:38Z",
		// 	"index": 0,
		// 	"delivery": {
		// 	  "total": 2,
		// 	  "sent": "all",
		// 	  "delivered": "some",
		// 	  "read": "some",
		// 	  "failed": "none",
		// 	  "undelivered": "none"
		// 	},
		// 	"content_sid": null,
		// 	"url": "https://conversations.twilio.com/v1/Conversations/CHaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Messages/IMaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
		// 	"links": {
		// 	  "delivery_receipts": "https://conversations.twilio.com/v1/Conversations/CHaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Messages/IMaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Receipts",
		// 	  "channel_metadata": "https://conversations.twilio.com/v1/Conversations/CHaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Messages/IMaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/ChannelMetadata"
		// 	}
		//   }
		return $message;
	}

	// Lista todas as mensagems de uma conversa
	//        $msg = $this->twilio->getMessagesDetails("CHa935531a0e934d78ad47c778e33f9425", "IM802a1208297a494eb421873bfd6b95bb");

	function getMessagesDetailsAggregated($conversationSid, $msgSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$message = $twilio->conversations->v1->conversations($conversationSid)->messages($msgSid)->fetch();
	
		echo "SID: " . $message->sid . "<br>";
		echo "Autor: " . $message->author . "<br>";
		echo "Corpo: " . $message->body . "<br>";
		echo "Criada em: " . $message->dateCreated->format('Y-m-d H:i:s') . "<br>";
		echo "Atributos: " . $message->attributes . "<br>";
		echo "Delivery: " . json_encode($message->delivery) . "<br>";

		return $message;
	}

	function getMessagesDetailsIndividual($conversationSid, $msgSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$deliveryReceipts = $twilio->conversations->v1
		->conversations($conversationSid)
		->messages($msgSid)
		->deliveryReceipts->read(20);

		foreach ($deliveryReceipts as $receipt) {
			echo "-----------------------------<br>";
			echo "SID: " . $receipt->sid . "<br>";
			echo "Message SID: " . $receipt->messageSid . "<br>";
			echo "Conversation SID: " . $receipt->conversationSid . "<br>";
			echo "Participant SID: " . $receipt->participantSid . "<br>";
			echo "Status da entrega: " . $receipt->status . "<br>"; // delivered, read, failed, etc.
			echo "Erro: " . ($receipt->errorCode ? $receipt->errorCode . ' - ' . $receipt->errorMessage : 'Nenhum') . "<br>";
			echo "Data de criação: " . $receipt->dateCreated->format('Y-m-d H:i:s') . "<br>";
			echo "Data de atualização: " . $receipt->dateUpdated->format('Y-m-d H:i:s') . "<br>";
		}

		return $deliveryReceipts;
	}

	//mostra mensagens de uma conversa
	//        $msg = $this->twilio->listMessages("CHa935531a0e934d78ad47c778e33f9425");
	function listMessages($conversationSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$messages = $twilio->conversations->v1->conversations($conversationSid)->messages->read([], 20);

		foreach ($messages as $msg) {
			echo "SID: " . $msg->sid . "<br>";
			echo "Autor: " . $msg->author . "<br>";
			echo "Corpo: " . $msg->body . "<br>";
			echo "Data de criação: " . $msg->dateCreated->format('Y-m-d H:i:s') . "<br>";
			echo "Participante SID: " . $msg->participantSid . "<br>";
			echo "Índice: " . $msg->index . "<br>";
			echo "Atributos: " . $msg->attributes . "<br>";
			echo "-----------------------------" . "<br>";
		}

		return $messages;
	}

	function participantsofConversations($conversationSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$participants = $twilio->conversations->v1->conversations($conversationSid)->participants->read(20);

		foreach ($participants as $participant) {
			echo "-----------------------------" . "<br>";
			echo "Participant SID: " . $participant->sid . "<br>";
			echo "Conversation SID: " . $participant->conversationSid . "<br>";
			echo "Identity: " . ($participant->identity ?? 'N/A') . "<br>";
		
			if (!empty($participant->messagingBinding)) {
				echo "Canal (Proxy Address): " . ($participant->messagingBinding['proxy_address'] ?? 'N/A') . "<br>";
				echo "Contato (Address): " . ($participant->messagingBinding['address'] ?? 'N/A') . "<br>";
			}
		
			echo "Role SID: " . ($participant->roleSid ?? 'N/A') . "<br>";
			echo "Data de criação: " . $participant->dateCreated->format('Y-m-d H:i:s') . "<br>";
			echo "Última atualização: " . $participant->dateUpdated->format('Y-m-d H:i:s') . "<br>";
			echo "Atributos customizados: " . ($participant->attributes ?? '{}') . "<br>";
		}

		return $participant;
	}


	function participantUpdate2($conversationSid, $participantSid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$data = [
				"name" => "dasntas@pvc.com",
				"attributes" => json_encode(["customer_id" => "12312", "name" => "dantas 2"])
			];
		
		//$participant = $twilio->conversations->v1->conversations($conversationSid)->participants($participantSid)->update(["dateUpdated" => new \DateTime("2019-05-15T13:37:35Z")]);
		$participant = $twilio->conversations
					->v1
					->conversations($conversationSid)
					->participants($participantSid)
					->update($data);

		return $participant;
	}

	
	function transferChat($conversationSid, $participantDelete, $workedEmailNewParticipant){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		//remove um
		$twilio->conversations->v1->conversations($conversationSid)->participants($participantDelete)->delete();

		//adiciona outro
		$this->routing($conversationSid, $workedEmailNewParticipant);

		return $participant;
	}

	

	function listUsers(){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$users = $twilio->conversations->v1->users->read(40);

		$i = 0;
		foreach ($users as $user) {
			$i++;
			echo "$i: ------------------------<br>";
			echo "SID: " . $user->sid . "<br>";
			echo "Identity: " . $user->identity . "<br>";
			echo "Friendly Name: " . ($user->friendlyName ?? 'N/A') . "<br>";
			echo "Atributos: " . $user->attributes . "<br>";
			echo "Role SID: " . ($user->roleSid ?? 'N/A') . "<br>";
			echo "Is Notifiable: " . ($user->isNotifiable ? 'Sim' : 'Não') . "<br>";
			echo "Criado em: " . $user->dateCreated->format('Y-m-d H:i:s') . "<br>";
			echo "Atualizado em: " . $user->dateUpdated->format('Y-m-d H:i:s') . "<br>";
			echo "URL: " . $user->url . "<br>";
		}

		return $users;
	}

	function listUserConversations($userid){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$userConversations = $twilio->conversations->v1
			->users($userid)
			->userConversations->read(20);

		foreach ($userConversations as $conv) {
			echo "-----------------------------<br>";
			echo "Conversation SID: " . $conv->conversationSid . "<br>";
			echo "User SID: " . $conv->userSid . "<br>";
			echo "Account SID: " . $conv->accountSid . "<br>";
			echo "Chat Service SID: " . $conv->chatServiceSid . "<br>";
			echo "Role SID: " . ($conv->roleSid ?? 'N/A') . "<br>";
			echo "Attributes: " . $conv->attributes . "<br>";
			echo "Conversation State: " . $conv->conversationState . "<br>";
			echo "Last Read Message Index: " . ($conv->lastReadMessageIndex ?? 'N/A') . "<br>";
			//echo "Last Read Timestamp: " . ($conv->lastReadTimestamp ? $conv->lastReadTimestamp->format('Y-m-d H:i:s') : 'N/A') . "<br>";
			echo "Criado em: " . $conv->dateCreated->format('Y-m-d H:i:s') . "<br>";
			echo "Atualizado em: " . $conv->dateUpdated->format('Y-m-d H:i:s') . "<br>";
		}

		return $userConversations;
	}


	function listCustomerConversations($to){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		$participantConversations = $twilio->conversations->v1->participantConversations->read(
			["address" => "whatsapp:+" . $to],
			20
		);
		
		foreach ($participantConversations as $conv) {
			echo "-----------------------------<br>";
			echo "Conversation SID: " . $conv->conversationSid . "<br>";
			echo "Participant SID: " . $conv->participantSid . "<br>";
			echo "User SID: " . ($conv->userSid ?? 'N/A') . "<br>";
			echo "Account SID: " . $conv->accountSid . "<br>";
			echo "Chat Service SID: " . $conv->chatServiceSid . "<br>";
			echo "Role SID: " . ($conv->roleSid ?? 'N/A') . "<br>";
			//echo "Attributes: " . $conv->attributes . "<br>";
			echo "Conversation State: " . $conv->conversationState . "<br>";
			echo "Last Read Message Index: " . ($conv->lastReadMessageIndex ?? 'N/A') . "<br>";
			//echo "Criado em: " . $conv->dateCreated->format('Y-m-d H:i:s') . "<br>";
			//echo "Atualizado em: " . $conv->dateUpdated->format('Y-m-d H:i:s') . "<br>";
		}

		return $participantConversations;
	}

}