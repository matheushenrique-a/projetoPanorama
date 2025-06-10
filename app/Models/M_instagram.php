<?php
namespace App\Models;

use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_http;


class m_instagram extends Model {
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
	function replayinstagram($commentId, $responseText) {
		$commentId = $commentId; // ID do comentário recebido no webhook
		$accessToken = 'IGAAR620pClFZABZAE4xbW43OHNlQ1BCS2pLRkRYUTBPVzZAlVTAtVmhNZA3NsdjBrbGZATRWJfcjg3eU42TjAtaDFMNThkVjVrbk02Yy00aUNpZA3BESGVaNUZAhZA01RNTBFejlMWFF0SXRkVHBCdlg0d21vdmJKUnBYMnpMREh6bDBNNAZDZD'; // Token de página do Instagram/Facebook com as permissões adequadas
		$responseText = $responseText;

		// Endpoint da Graph API
		$url = "https://graph.facebook.com/v23.0/{$commentId}/replies";

		// Dados do corpo da requisição
		$data = [
			'message' => $responseText,
			'access_token' => $accessToken
		];

		// Inicializa cURL
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

		// Executa a requisição
		$response = curl_exec($ch);
		curl_close($ch);

		// Verifica a resposta
		echo "Resposta da API:\n";
		print_r($response);

	}

}