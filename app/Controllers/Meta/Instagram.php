<?php

namespace App\Controllers\Meta;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use Config\Services;
use App\Models\M_chatGpt;
use App\Models\M_instagram;
use App\Models\M_seguranca;

class Instagram extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $chatgpt;
    protected $m_instagram;
    protected $m_security;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
		$this->dbMaster = new dbMaster();
       

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->chatgpt =  new M_chatGpt();
        $this->m_instagram =  new M_instagram();
        $this->m_security = new M_seguranca();
    }


    //http://localhost/InsightSuite/public/instagram-webhook
    //https://949c-2804-1b3-6149-85b2-101e-4ade-c16-4add.ngrok-free.app/InsightSuite/public/instagram-webhook
    public function instagram_webhook(){
        $mode =  $this->getpost('hub_mode') ?? '';
        $token =  $this->getpost('hub_verify_token') ?? '';
        $challenge =  $this->getpost('hub_challenge') ?? '';
        $WEBHOOK_VERIFY_TOKEN = 'PRAVOCE';

        // Recebe o JSON enviado pelo webhook do WhatsApp
        $json = file_get_contents('php://input');

        $data = json_decode($json, true);

        //echo '21:52:12 - <h3>Dump 19 </h3> <br><br>' . var_dump($data); exit;					//<-------DEBUG

         //usado no registro do webhook apenas
        if ($mode === 'subscribe' && $token === $WEBHOOK_VERIFY_TOKEN) {
            $this->telegram->notifyTelegramGroup("✅✅✅ META Webhook Registered.", telegramQuid);
            http_response_code(200); echo $challenge;
            exit;
        }

        // Verifica se há entries
        if (isset($data['entry']) && is_array($data['entry'])) {
            foreach ($data['entry'] as $entryIndex => $entry) {
                $changes = $entry['changes'] ?? [];

                foreach ($changes as $changeIndex => $change) {
                    
                    //NOVAS MENSAGENS RECEBIDAS
                    if (isset($change['field'])) {

                        $field = $change['field'] ?? [];
                        $from_id = $change['value']['from']['id'] ?? [];
                        $from_username = $change['value']['from']['username'] ?? [];
                        $media_id = $change['value']['media']['id'] ?? [];
                        $media_product_type = $change['value']['media']['media_product_type'] ?? [];
                        $value_id = $change['value']['id'] ?? [];
                        $parent_id = $change['value']['parent_id'] ?? [];
                        $text = $change['value']['text'] ?? [];

                        $this->telegram->notifyTelegramGroup("📩📩📩 META Webhook: \n TEXT: " . strtoupper($text) . "\n" . $json, telegramPraVoceGroupLogErrors);
                        if (strtoupper($text) == 'THIS IS AN EXAMPLE.') {
                            // Processa a mensagem recebida
                            $this->m_instagram->replayinstagram($value_id, "Obrigado");
                        }
                        

                    //EVENTOS DA CONTA
                    } else {
                        echo '21:51:12 - <h3>Dump 51 </h3> <br><br>' . var_dump($change); exit;					//<-------DEBUG

                        //$this->telegram->notifyTelegramGroup("🚨🚨🚨 META Webhook Review: \n" . $json, telegramPraVoceGroupLogErrors);
                        //$this->dbMasterDefault->insert('record_log',['log' => "Review Webhook Event: " . $json]);
                    }
                }
            }
        } else {
            $this->telegram->notifyTelegramGroup("🚨🚨🚨 META Webhook error: \n" . $json, telegramQuid);
        }

        http_response_code(200);
    }

    
        
}
