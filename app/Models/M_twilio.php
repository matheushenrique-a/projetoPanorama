<?php
namespace App\Models;

require_once 'twilio/vendor/autoload.php';

use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class m_twilio extends Model {
	public function __construct(){
		$this->dbMaster = new dbMaster();
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
		}

		$returnData["raw"] = $message;

		//Registra conversa no histórico
		$data = (array('MessageSid' => $returnData["mensagem"], 'ProfileName' => 'SMS', 'Body' => $mensagem, 'SmsStatus' => 'Sent', 'To' => $telefone, 'WaId' => fromWhatsApp, 'From' => "whatsapp:+" . fromWhatsApp));
		$result = $this->dbMaster->insert('whatsapp_log', $data);

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
			$result = $this->dbMaster->insert('whatsapp_log', $data);

			return $message;
		}
	}
	
}