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
		
		$this->dbMasterDefault->insert('record_log',['log' => "SMS Enviado $telefone - $mensagem"]);

		try {
			$message = $twilio->messages->create("+" . $telefone, ["body" => $mensagem, "from" => fromWhatsApp, "statusCallback" => rootURL . "frontline-conversations-webhook"]);
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

			$this->dbMasterDefault->insert('record_log',['log' => "SMS ERRO $telefone - $mensagem - " . $returnData["mensagem"]]);
		}

		$returnData["raw"] = $message;

		//Registra conversa no histórico
		$data = (array('MessageSid' => $messageSid, 'Type' => 'SMS', 'ProfileName' => $author, 'Body' => $mensagem, 'SmsStatus' => 'Gravada', 'To' => normalizePhone(numberOnly($telefone)), 'WaId' => normalizePhone(fromWhatsApp), 'From' => normalizePhone(fromWhatsApp)));
		$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

		return $returnData;
	}

	//mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	function sendWhatsApp($body, $to){
		if (whatAppMsg) {
			$sid = TWILIO_ACCOUNT_SID_SMS;
			$token = TWILIO_AUTH_TOKEN_SMS;
			$twilio = new Client($sid, $token);

			$params = array(       
				"from" => "whatsapp:+" . fromWhatsApp,
				"body" => $body
			);

			$message = $twilio->messages->create("whatsapp:+" . $to, $params);

			//Registra conversa no histórico
			$MessageSid = substr($message, strpos($message, " sid=")+5, -1);
			$data = (array('MessageSid' => $MessageSid, 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'Body' => $body, 'SmsStatus' => 'Gravada', 'To' => normalizePhone($to), 'WaId' => normalizePhone(fromWhatsApp), 'From' => normalizePhone(fromWhatsApp)));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

			return $message;
		}
	}


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
			$messaging_service_sid = "MGe5bf2163a347b3c4f98c248e4459529f";
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
			$data = (array('MessageSid' => $messageSid, 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'Body' => "Olá 👋🏻! Para continuar seu atendimento telefônico por aqui clique em CONTINUAR:", 'SmsStatus' => 'Gravada', 'To' => normalizePhone($to), 'WaId' => normalizePhone(fromWhatsApp), 'From' => normalizePhone(fromWhatsApp)));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

			return $returnData;
		}
	}

	function routing($conversationSid, $workedEmail){
		$sid = TWILIO_ACCOUNT_SID_SMS;
		$token = TWILIO_AUTH_TOKEN_SMS;
		$twilio = new Client($sid, $token);

		try {
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

	
}