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
	function sendSMS($telefone, $mensagem){
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
			$message = $twilio->messages->create("+" . $telefone, ["body" => $mensagem, "from" => "+13393300703"]);
			// Suponha que $message seja o objeto retornado pelo Twilio
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
		$data = (array('MessageSid' => $returnData["mensagem"], 'ProfileName' => 'SMS', 'Body' => $mensagem, 'SmsStatus' => 'Sent', 'To' => $telefone, 'WaId' => fromWhatsApp, 'From' => "whatsapp:+" . fromWhatsApp));
		$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

		return $returnData;
	}

	//mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	function sendWhatsApp($body, $to){
		if (whatAppMsg) {
			$sid = TWILIO_ACCOUNT_SID;
			$token = TWILIO_AUTH_TOKEN;
			$twilio = new Client($sid, $token);

			$params = array(       
				"from" => "whatsapp:+" . fromWhatsApp,
				"body" => $body
			);

			$message = $twilio->messages->create("whatsapp:+" . $to, $params);

			//Registra conversa no histórico
			$MessageSid = substr($message, strpos($message, " sid=")+5, -1);
			$data = (array('MessageSid' => $MessageSid, 'ProfileName' => 'ChatBot', 'Body' => $body, 'SmsStatus' => 'Sent', 'To' => $to, 'WaId' => fromWhatsApp, 'From' => "whatsapp:+" . fromWhatsApp));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

			return $message;
		}
	}


	//mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	function sendWhatsAppTemplate($template, $to){
		$body = "";

		if (whatAppMsg) {
			$sid = TWILIO_ACCOUNT_SID;
			$token = TWILIO_AUTH_TOKEN;
			$twilio = new Client($sid, $token);

			$returnData = array();
			$returnData["status"] = true;
			$returnData["mensagem"] = "";
			$returnData["raw"] = null;
			$messaging_service_sid = "";
			$message = null;

			try {
				//echo $template;exit;
				$message = $twilio->messages->create("whatsapp:" . $to, ["contentSid" => $template, "from" => "whatsapp:+" . fromWhatsApp]);

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
			$MessageSid = substr($message, strpos($message, " sid=")+5, -1);
			$data = (array('MessageSid' => $MessageSid, 'ProfileName' => 'WHATSAPP', 'Body' => $body, 'SmsStatus' => 'Sent', 'To' => $to, 'WaId' => fromWhatsApp, 'From' => "whatsapp:+" . fromWhatsApp));
			$result = $this->dbMasterDefault->insert('whatsapp_log', $data);

			return $returnData;
		}
	}

	function routing($conversationSid, $workedEmail){
		$sid = TWILIO_ACCOUNT_SID;
		$token = TWILIO_AUTH_TOKEN;
		$twilio = new Client($sid, $token);

		try {
			$participant = $twilio->conversations->conversations($conversationSid)->participants->create(["identity" => $workedEmail]);
		} catch (Exception $e) {
			$this->dbMasterDefault->insert('record_log',['log' => "ROUTING Error Worker:$workedEmail - " . $e->getMessage()]);
			error_log("Create agent participant: " . $e->getMessage());
		}

		$participants = $twilio->conversations->v1->conversations($ConversationSid)->participants($ParticipantSid)->update($data);	
		return $participants;
	}

	//remove conversas presas no Frontline
	function closeConversation($service, $conversationId){
		$sid = TWILIO_ACCOUNT_SID;
		$token = TWILIO_AUTH_TOKEN;
		$twilio = new Client($sid, $token);
		
		//echo "$service, $conversationId";exit;
		$outpout = $twilio->conversations->v1->services($service)->conversations($conversationId)->delete();
		return $outpout;
	}

	function participantUpdate($ConversationSid, $ParticipantSid, $id_proposta, $display_name){
		$sid = TWILIO_ACCOUNT_SID;
		$token = TWILIO_AUTH_TOKEN;
		$twilio = new Client($sid, $token);
		$data = ["attributes" => json_encode(["avatar" => $display_name, "customer_id" => $id_proposta, "display_name" => $display_name])];

		try {
			$participants = $twilio->conversations->v1->conversations($ConversationSid)->participants($ParticipantSid)->update($data);	
		} catch (\Exception $e) {
			$this->dbMasterDefault->insert('record_log',['log' => "PARTICIPANTE ERROR $ConversationSid, $ParticipantSid, $id_proposta, $display_name - " . $e->getMessage()]);
		}
		
		return $participants;
	}

	
}