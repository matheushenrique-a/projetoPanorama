<?php
namespace App\Models;

use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_http;


class m_whatsapp extends Model {
    protected $m_http;
	protected $dbMasterDefault;

	public function __construct(){
        $this->m_http =  new M_http();
		$this->dbMasterDefault = new dbMaster();
	}

	public function getHeader(){
		// Dados do envio
		$token = "EAAOkO2w2V1sBOzI1pEnf9UTOtZAXUDiqdnCC3ZCVKMDP37bd8wT63UE1eCoThIHIQ6WtIctYaILuOKZAT3rkFDUj7khSgoxTDsLm1iAz7P9NHdetSqrlM9KZC5VdL3t4IOigerKT5R5ZBqLi7oeEvOAzyZCcZBivQjVT4FhzEadFnHcajQDSzGqXFcy";
		
		$headers = [];
		$headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: Bearer " . $token;
        return $headers;
	}

	//mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	function sendWhatsAppTemplate($templateName, $to, $conversation){
		$returnData["sucesso"] = false;
        $returnData["error"] = "";
        $returnData["message"] = null;

		if (whatAppMsg) {
			$headers = $this->getHeader();
			$url = META_CLOUD_API;

			$data = [
				"messaging_product" => "whatsapp",
				"to" => $to,
				"type" => "template",
				"template" => [
					"name" => $templateName,
					"language" => [
						"code" => "pt_BR"
					]
				]
			];
			
			$result = $this->m_http->http_request('POST', $url, $headers, $data);

			$messageId = 'N/I';
			$messageStatus = "TOBE";
			$body = "Olá 👋🏻! Para continuar seu atendimento telefônico por aqui clique em CONTINUAR:";

			if ($result['sucesso']){
				$retorno = json_decode($result['retorno'], true);
				
				if (isset($retorno['messaging_product'])){
					$returnData["sucesso"] = true;
					
					$messageId = $retorno['messages'][0]['id'];
					$messageStatus = $retorno['messages'][0]['message_status'];

					$returnData["message"]['messageId'] = $messageId;
					$returnData["message"]['messageStatus'] = $messageStatus;
				} else {
					$returnData["error"] = "Erro ao enviar mensagem: " . $result['retorno'];
					$messageStatus = "ERROR";
				}
			} else {
				$returnData["error"] = "Erro HTTP ao enviar mensagem: " . $result['retorno'];
				$messageStatus = "ERROR";
			}

			//Registra conversa no histórico
			$data = (array('ConversationSid' => $conversation['firstRow']->ConversationSid, 'MessageSid' => $messageId, 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'direction' => 'B2C', 'Body' => $body, 'SmsStatus' => strtoupper($messageStatus), 'error' => $returnData["error"], 'To' => normalizePhone($to), 'From' => (fromWhatsApp)));
			$added = $this->createMessage($data);
			$returnData["id"] = $added["insert_id"];
		} else {
			$returnData["error"] = "Envio WhatsApp desativado nas configurações.";
		}

		return $returnData;
	}

	//mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	function sendWhatsApp($body, $to, $conversation){
		$returnData["sucesso"] = false;
        $returnData["error"] = "";
        $returnData["message"] = null;

		if (whatAppMsg) {
			$headers = $this->getHeader();
			$url = META_CLOUD_API;

			$data = [
				"messaging_product" => "whatsapp",
				"recipient_type" => "individual",
				"to" => $to,
				"type" => "text",
				"text" => [
					"preview_url" => false,
					"body" => $body
					]
				];
			
			$result = $this->m_http->http_request('POST', $url, $headers, $data);

			$messageId = 'N/I';
			$messageStatus = "ACCEPTED";

			if ($result['sucesso']){
				$retorno = json_decode($result['retorno'], true);
				
				if (isset($retorno['messaging_product'])){
					$returnData["sucesso"] = true;
					$messageId = $retorno['messages'][0]['id'];
					$returnData["message"]['messageId'] = $messageId;
				} else {
					$returnData["error"] = "Erro ao enviar mensagem: " . $result['retorno'];
					$messageStatus = "ERROR";
				}
			} else {
				$returnData["error"] = "Erro HTTP ao enviar mensagem: " . $result['retorno'];
				$messageStatus = "ERROR";
			}

			//Registra conversa no histórico
			$data = (array('ConversationSid' => $conversation['firstRow']->ConversationSid, 'MessageSid' => $messageId, 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'direction' => 'B2C', 'Body' => $body, 'SmsStatus' => strtoupper($messageStatus), 'error' => $returnData["error"], 'To' => normalizePhone($to), 'From' => (fromWhatsApp)));
			$added = $this->createMessage($data, $conversation);
			$returnData["id"] = $added["insert_id"];
		} else {
			$returnData["error"] = "Envio WhatsApp desativado nas configurações.";
		}

		return $returnData;
	}

	public function getConversation($filter){
		$this->dbMasterDefault->setOrderBy(array("data_criacao", "DESC"));
		return $this->dbMasterDefault->select('whatsapp_conversations', $filter);
	}

	public function getConversationTopMsg($userId){
		$sql = "select c.id, c.ConversationSid, c.atendenteId, c.atendenteNome, c.telefoneCliente, c.nomeCliente, c.last_updated, c.data_criacao, MAX(l.id) topMsgId 
				FROM whatsapp_conversations c LEFT JOIN whatsapp_log l 
				ON c.ConversationSid = l.ConversationSid
				WHERE c.atendenteId = $userId AND status = 'OPEN'
				GROUP BY c.id, c.ConversationSid, c.atendenteId, c.atendenteNome, c.telefoneCliente, c.nomeCliente, c.last_updated, c.data_criacao;";
	
		return $this->dbMasterDefault->runQuery($sql);
	}

	public function getConversationTopMsgShort($userId){
		$sql = "select c.ConversationSid, MAX(l.id) topMsgId 
				FROM whatsapp_conversations c LEFT JOIN whatsapp_log l 
				ON c.ConversationSid = l.ConversationSid
				WHERE c.atendenteId = $userId AND status = 'OPEN'
				GROUP BY c.ConversationSid;";
	
		return $this->dbMasterDefault->runQuery($sql);
	}

	public function getTopConversation($userId){
		$sql = "SELECT id FROM whatsapp_conversations WHERE status = 'OPEN' and atendenteId = $userId ORDER BY id DESC LIMIT 1;";
	
		$topConversation = $this->dbMasterDefault->runQuery($sql);

        if ($topConversation['existRecord']){
			return $topConversation['firstRow']->id;
        } else {
			return 0;
		}
	}

	public function getTopMessage($ConversationSid){
		$sql = "SELECT id FROM whatsapp_log WHERE ConversationSid = '$ConversationSid' ORDER BY id DESC LIMIT 1;";
	
		$topMessage = $this->dbMasterDefault->runQuery($sql);

        if ($topMessage['existRecord']){
			return $topMessage['firstRow']->id;
        } else {
			return 0;
		}
	}

	public function deleteConversation($filter){
		$this->dbMasterDefault->delete('whatsapp_conversations', $filter);
	}

	public function createConversation($data){
		$added = $this->dbMasterDefault->insert('whatsapp_conversations', $data);

		$this->dbMasterDefault->setOrderBy(null);
		$conversation = $this->dbMasterDefault->select('whatsapp_conversations', ['id' => $added["insert_id"]]);
		return $conversation;
	}

	public function updateConversation($data, $filter){
		$updated = $this->dbMasterDefault->update('whatsapp_conversations', $data, $filter);
		return $updated;
	}

	public function getMessages($filter){
		$this->dbMasterDefault->setOrderBy(null);
		return $this->dbMasterDefault->select('whatsapp_log', $filter);
	}

	public function updateMessage($data, $filter, $dinamicField){
		//echo '19:46:21 - <h3>Dump 29 </h3> <br><br>' . var_dump($filter); exit;					//<-------DEBUG
		
		$updated = $this->dbMasterDefault->update('whatsapp_log', $data, $filter, $dinamicField);
		return $updated;
	}

	public function createMessage($data, $conversation){
		$added = $this->dbMasterDefault->insert('whatsapp_log', $data);

		//Atualiza o contador de mensagens da conversa
		$this->updateConversation(['msgCount' => $conversation['firstRow']->msgCount + 1], ['id' => $conversation['firstRow']->id], ['last_updated' => 'current_timestamp()']);
		
		return $added;
	}

}