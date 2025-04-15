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
		$token = META_TOKEN_WHATSAPP;
		
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
		$returnData["messageId"] = "";

		$messageId = 'N/I';
		$messageStatus = "ACCEPTED";

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
			 
			if ($result['sucesso']){
				$retorno = json_decode($result['retorno'], true);
				//echo '18:35:30 - <h3>Dump 35 </h3> <br><br>' . var_dump($retorno); exit;					//<-------DEBUG
				
				if (isset($retorno['messaging_product'])){
					$returnData["sucesso"] = true;
					$returnData["messageId"] = $retorno['messages'][0]['id'];
				} else {
					$returnData["error"] = "Erro ao enviar mensagem: " . $result['retorno'];
					$messageStatus = "ERROR";
				}
			} else {
				$returnData["error"] = "Erro HTTP ao enviar mensagem: " . $result['retorno'];
				$messageStatus = "ERROR";
			}
			//Registra conversa no histórico
			$data = (array('ConversationSid' => $conversation['firstRow']->ConversationSid, 'MessageSid' => $returnData["messageId"], 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'direction' => 'B2C', 'Body' => $body, 'SmsStatus' => strtoupper($messageStatus), 'error' => $returnData["error"], 'To' => normalizePhone($to), 'From' => (fromWhatsApp)));
			$added = $this->createMessage($data, $conversation);
			$returnData["id"] = $added["insert_id"];
			
		} else {
			$messageStatus = "DISABLED";
			$returnData["error"] = "Envio WhatsApp desativado nas configurações.";
		}

		$returnData["status"] = traduzirStatusTwilio($messageStatus)[0];
		return $returnData;
	}

	//buca template na Cloud API
	function searchTempalte(){
		$headers = [];
		$headers[] = "Authorization: Bearer " . META_TOKEN_WHATSAPP;

		$url = META_CLOUD_API_RAW . META_CLOUD_BUSINESS_ID . '/message_templates?search=antedimento_telefonico';
		$result = $this->m_http->http_request('GET', $url, $headers);
		return $result;
	}

	//envia template direto pela CLoud API
	function sendWhatsAppTemplateCloud($templateName, $body, $to, $conversation){
		$returnData["sucesso"] = false;
        $returnData["error"] = "";
		$returnData["messageId"] = "";

		$messageId = 'N/I';
		$messageStatus = "ACCEPTED";

		if (whatAppMsg) {
			$headers = $this->getHeader();
			$url = META_CLOUD_API_RAW . META_CLOUD_PHONE_ID . '/messages';

			$data = [
				"messaging_product" => "whatsapp",
				"recipient_type" => "individual",
				"to" => $to,
				"type" => "template",
				"template" => [
					"name" => $templateName,
					"language" => ["code" => "PT_BR"]
					]
				];
			
			$result = $this->m_http->http_request('POST', $url, $headers, $data);
			 
			if ($result['sucesso']){
				$retorno = json_decode($result['retorno'], true);
				//echo '18:35:30 - <h3>Dump 35 </h3> <br><br>' . var_dump($retorno); exit;					//<-------DEBUG
				
				if (isset($retorno['messaging_product'])){
					$returnData["sucesso"] = true;
					$returnData["messageId"] = $retorno['messages'][0]['id'];
				} else {
					$returnData["error"] = "Erro ao enviar mensagem: " . $result['retorno'];
					$messageStatus = "ERROR";
				}
			} else {
				$returnData["error"] = "Erro HTTP ao enviar mensagem: " . $result['retorno'];
				$messageStatus = "ERROR";
			}
			//Registra conversa no histórico
			$data = (array('ConversationSid' => $conversation['firstRow']->ConversationSid, 'MessageSid' => $returnData["messageId"], 'Type' => 'WHATSAPP', 'ProfileName' => 'INSIGHT', 'direction' => 'B2C', 'Body' => $body, 'SmsStatus' => strtoupper($messageStatus), 'error' => $returnData["error"], 'To' => normalizePhone($to), 'From' => (fromWhatsApp)));
			$added = $this->createMessage($data, $conversation);
			$returnData["id"] = $added["insert_id"];
			
		} else {
			$messageStatus = "DISABLED";
			$returnData["error"] = "Envio WhatsApp desativado nas configurações.";
		}

		$returnData["status"] = traduzirStatusTwilio($messageStatus)[0];
		return $returnData;
	}

	//mensagens enviadas pelo chatbot, mas sensiveis a opção de notificação via whatsapp
	function getWhatsAppMedia($mediaId, $mime_type){
		$returnData["sucesso"] = false;
        $returnData["error"] = "";
        $returnData["fileName"] = "";
        $returnData["imageUrl"] = null;

		$headers = $this->getHeader();
		$url = META_CLOUD_API_RAW . $mediaId;

		$response = $this->m_http->http_request('GET', $url, $headers);

		if ($response['sucesso']) {
			$dados = json_decode($response['retorno'], true);
			if (isset($dados['url'])) {
				$imageUrl = $dados['url'] ?? null;
				$mime_type = $dados['mime_type'] ?? null;
				$file_size = $dados['file_size'] ?? null;
				$id = $dados['id'] ?? null;
	
				$fileName = 'media-' . $id . "." . getExtensionByMimeType($mime_type);
				$outputFile = PATH_SAVE_MEDIA . $fileName;
	
				//Header customizado para baixar imagem
				$headers = [];
				$headers[] = "Authorization: Bearer " . META_TOKEN_WHATSAPP;
				$headers[] = "User-Agent: WhatsApp/2.19.81 A";
				
				$this->dbMasterDefault->insert('record_log',['log' => "Curl URL: " . $imageUrl]);
				$ch = curl_init($imageUrl);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				//curl_setopt($ch, CURLOPT_CAINFO, PATH_SAVE_MEDIA . 'cacert.pem'); // caminho do seu arquivo
				// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // <-- ESSENCIAL para mídia
				$response = curl_exec($ch);
	
				if (curl_errno($ch)) {
					$returnData["error"] =  "Erro ao fazer o download Media Id<br>: $mediaId, Mime: $mime_type: " . curl_error($ch);
					$this->dbMasterDefault->insert('record_log',['log' => "Http Return Get Media: " . curl_error($ch)]);
				} else {
					try {
						file_put_contents($outputFile, $response);
						$returnData["fileName"] = $fileName;
						$returnData["sucesso"] = true;
					} catch (\Exception $e) {
						$returnData["error"] =  "Erro ao salvar arquivo path<br>: $outputFile - " . $e->getMessage();
					}
				}
				curl_close($ch);
			} else {
				$returnData["error"] = "Erro conteúdo resposta: " . $response['retorno'];
			}
		} else {
			$returnData["error"] = "Erro HTTP: " . $response['retorno'];
		}
		
		return $returnData;
	}

	public function getConversation($filter){
		$this->dbMasterDefault->setOrderBy(array("data_criacao", "DESC"));
		return $this->dbMasterDefault->select('whatsapp_conversations', $filter);
	}
	
	public function getConversationWindowById($ConversationSid){
		$conversa = $this->getConversation(['ConversationSid' => $ConversationSid]);
		if ($conversa['existRecord']){
			return $this->getConversationWindow($conversa['firstRow']->telefoneCliente);
		} else {
			return null;
		}
	}

	public function getConversationWindow($telefoneCliente){
		$returnData["janela_aberta"] = false;
        $returnData["minutos_passados"] = 0;
        $returnData["minutos_restantes"] = 0;
        $returnData["hora_fechamento"] = 0;

		$sql = "SELECT 
				dataUltimaMensagemCliente,
				TIMESTAMPDIFF(MINUTE, dataUltimaMensagemCliente, NOW()) AS minutos,
				DATE_ADD(dataUltimaMensagemCliente, INTERVAL 24 HOUR) AS fechamentoJanela
				FROM 
				whatsapp_conversations
				WHERE 
				telefoneCliente = '$telefoneCliente';";
	
		$result = $this->dbMasterDefault->runQuery($sql);

		if ($result['existRecord']){
			$minutos = $result['firstRow']->minutos; //minutos desde a ultima conversa. Se > 1440 (24h) a janela foi perdida.
			$dataUltimaMensagemCliente = $result['firstRow']->dataUltimaMensagemCliente; 
			$fechamentoJanela = $result['firstRow']->fechamentoJanela; 

			if (!empty($dataUltimaMensagemCliente)){
				if ($minutos < 1440){
					$returnData["janela_aberta"] = true;
					$returnData["minutos_passados"] = $minutos;
					$returnData["minutos_restantes"] = 1440 - $minutos;
					$returnData["hora_fechamento"] = dataUsPtHours($fechamentoJanela, true);
				}
			}
		}

		return $returnData;

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