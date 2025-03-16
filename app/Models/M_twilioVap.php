<?php
namespace App\Models;

require_once 'twilio/vendor/autoload.php';

use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class m_twilioVap extends Model {
	protected $dbMasterDefault;

	public function __construct(){
		//$this->dbMaster = new dbMaster();

		 //o dbMasterDefault vai apontar para o banco do InsightSuite
		 $this->dbMasterDefault = new dbMaster();
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