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
use App\Models\M_whatsapp;
use App\Models\M_argus;

class WhatsApp extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $chatgpt;
    protected $m_whatsapp;
    protected $m_argus;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
		$this->dbMaster = new dbMaster();
       

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->chatgpt =  new M_chatGpt();
        $this->m_whatsapp =  new M_whatsapp();
        $this->m_argus =  new M_argus();
    }

    //http://localhost/InsightSuite/public/whatsapp-chat
    public function whatsapp_chat(){
        $this->checkSession();

        $ConversationSid =  $this->getpost('ConversationSid') ?? '';
        $currentConversationSid =  $this->getpost('currentConversationSid') ?? '';
        $search =  $this->getpost('search');
        $newConversation =  $this->getpost('newConversation');
        $closeConversation =  $this->getpost('closeConversation');
        $messageToSend =  $this->getpost('messageToSend');
        $btnSendMsg =  $this->getpost('btnSendMsg');
        $directContact =  $this->getpost('directContact');

        $userId = $this->session->userId;
        $atendenteNome = $this->session->nickname;
        $messages = [];
        $currentConversation = null;
        $clientesCRM = null;
        $topConversation = null;

        //se o usuario clicou em uma conversa específica
        if (!empty($ConversationSid)){
            $messages = $this->m_whatsapp->getMessages(['ConversationSid' => $ConversationSid]);
            $currentConversation = $this->m_whatsapp->getConversation(['ConversationSid' => $ConversationSid]);
        } 
        //caso uma busca no CRM tenha sido feita
        else  if (!empty($search)){
            $clientesCRM = $this->m_argus->buscarClienteCRM($search);
        } 
        //caso uma nova conversa tenha sido solicitada com um cliente do CRM
        else if (!empty($newConversation)){
            $clientesCRMNew = $this->m_argus->buscarCliente(['id_proposta' => $newConversation]);
            if ($clientesCRMNew['existRecord']){
                $conversation = $this->m_whatsapp->createConversation([
                    'telefoneCliente' => normalizePhone($clientesCRMNew['firstRow']->celular),
                    'telefoneBot' => fromWhatsApp,
                    'nomeCliente' => $clientesCRMNew['firstRow']->nome,
                    'nomeBot' => 'INSIGHT',
                    'atendenteId' => $userId,
                    'atendenteNome' => $atendenteNome,
                ]);

                return redirect()->to('whatsapp-chat?ConversationSid=' . $conversation['firstRow']->ConversationSid);exit;
            }
        //Cria conversa com número avulso / direto
        } else if (!empty($directContact)){
                $conversation = $this->m_whatsapp->createConversation([
                    'telefoneCliente' => normalizePhone($directContact),
                    'telefoneBot' => fromWhatsApp,
                    'nomeCliente' => 'CONTATO DIRETO | ' . formatarTelefone($directContact),
                    'nomeBot' => 'INSIGHT',
                    'atendenteId' => $userId,
                    'atendenteNome' => $atendenteNome,
                ]);

                return redirect()->to('whatsapp-chat?ConversationSid=' . $conversation['firstRow']->ConversationSid);exit;
        //fecha uma conversa
        } else if (!empty ($closeConversation)) {
            $this->m_whatsapp->deleteConversation(['conversationSid' => $closeConversation], ['status' => 'CLOSED']);

        //envia uma nova mensagem após pressionar o botão Enviar
        } else if (!empty($btnSendMsg) or !empty($messageToSend)) {
            
            //recupera a conversa antes de enviar uma mensagem
            $conversation = $this->m_whatsapp->getConversation(['ConversationSid' => $currentConversationSid]);
            if ($conversation['existRecord']){
                $result = $this->m_whatsapp->sendWhatsApp($messageToSend, normalizePhone($conversation['firstRow']->telefoneCliente), $conversation);
                
                //busca todas as mensagens trocadas
                $messages = $this->m_whatsapp->getMessages(['ConversationSid' => $currentConversationSid]);
                $currentConversation = $this->m_whatsapp->getConversation(['ConversationSid' => $currentConversationSid]);
            }
        }

        //listar conversas abertas para o usuario logado
        $conversations = $this->m_whatsapp->getConversationTopMsg($userId);

        //elege a primeira conversa com a selecionada caso nenhuma outra esteja marcada
        if ((empty($ConversationSid)) && (empty($search))){
            if ($conversations['existRecord']){
                $messages = $this->m_whatsapp->getMessages(['ConversationSid' => $conversations['firstRow']->ConversationSid]);
                $currentConversation = $this->m_whatsapp->getConversation(['ConversationSid' => $conversations['firstRow']->ConversationSid]);
            }
        }

        //registra a conversa mais recente enviada ao cliente para monitorar e buscar números acima
        $topConversation = $this->m_whatsapp->getTopConversation($userId);
        $toptMessage = $this->m_whatsapp->getTopMessage((isset($currentConversation['firstRow']->ConversationSid)  ? $currentConversation['firstRow']->ConversationSid : 0));

        
        $data['pageTitle'] = "WhatsApp Chat";
        $data['ConversationSid'] = $ConversationSid;
        $data['toptMessage'] = $toptMessage;
        $data['conversations'] = $conversations;
        $data['messages'] = $messages;
        $data['currentConversation'] = $currentConversation;
        $data['clientesCRM'] = $clientesCRM;
        $data['search'] = $search;
        $data['session'] = $this->session;
        $data['topConversation'] = $topConversation;
        return $this->loadpage('whatsapp/chat', $data);

    }


    //http://localhost/InsightSuite/public/whatsapp-webhook
    // https://b31f-177-73-197-2.ngrok-free.app/InsightSuite/public/whatsapp-webhook
    public function whatsapp_webhook(){
        //$result = $this->m_whatsapp->getWhatsAppMedia("1357103935532763", "image/jpeg");
        //http_response_code(200);
       // exit;

        $mode =  $this->getpost('hub_mode') ?? '';
        $token =  $this->getpost('hub_verify_token') ?? '';
        $challenge =  $this->getpost('hub_challenge') ?? '';
        $WEBHOOK_VERIFY_TOKEN = 'PRAVOCE0404';
        // Recebe o JSON enviado pelo webhook do WhatsApp
        $json = file_get_contents('php://input');

        //DEBUG nova mensagem
        //$json = '{"object": "whatsapp_business_account", "entry": [{"id": "1403356640797060", "changes": [{"value": {"messaging_product": "whatsapp", "metadata": {"display_phone_number": "15556418758", "phone_number_id": "643196615539553"}, "contacts": [{"profile": {"name": "Dantas"}, "wa_id": "553195781355"}], "messages": [{"from": "553195781355", "id": "wamid.HBgMNTUzMTk1NzgxMzU1FQIAEhgWM0VCMDZBMkVCQTkxOTMzNkVBMjcwQgA=", "timestamp": "1743813734", "text": {"body": "ok"}, "type": "text"}]}, "field": "messages"}]}]}';

        //DEBUG stauts mensagem
        //$json = '{"object": "whatsapp_business_account", "entry": [{"id": "1403356640797060", "changes": [{"value": {"messaging_product": "whatsapp", "metadata": {"display_phone_number": "15556418758", "phone_number_id": "643196615539553"}, "statuses": [{"id": "wamid.HBgMNTUzMTk1NzgxMzU1FQIAEhgWM0VCMDZBMkVCQTkxOTMzNkVBMjcwQgA=", "status": "read", "timestamp": "1743813795", "recipient_id": "553195781355"}]}, "field": "messages"}]}]}';
        // $json = '{"object": "whatsapp_business_account", "entry": [{"id": "1403356640797060", "changes": [{"value": {"messaging_product": "whatsapp", "metadata": {"display_phone_number": "15556418758", "phone_number_id": "643196615539553"}, "statuses": [{"id": "wamid.HBgMNTUzMTk1NzgxMzU1FQIAERgSNzVDMjFEMjIxOTAxRjJBQjU2AA==", "status": "read", "timestamp": "1743892998", "recipient_id": "553195781355"}]}, "field": "messages"}]}]}';
        
        //DEBUG Both message and status
        //$json = '{"object": "whatsapp_business_account", "entry": [{"id": "1403356640797060", "changes": [{"value": {"messaging_product": "whatsapp", "metadata": {"display_phone_number": "15556418758", "phone_number_id": "643196615539553"}, "contacts": [{"profile": {"name": "Dantas"}, "wa_id": "553195781355"}], "messages": [{"from": "553195781355", "id": "wamid.HBgMNTUzMTk1NzgxMzU1FQIAEhgWM0VCMDZBMkVCQTkxOTMzNkVBMjcwQgA=", "timestamp": "1743813734", "text": {"body": "ok"}, "type": "text"}], "statuses": [{"id": "wamid.HBgMNTUzMTk1NzgxMzU1FQIAERgSREU1RjI5RDIxMEExOTU4NjZBAA==", "status": "read", "timestamp": "1743813795", "recipient_id": "553195781355"}]}, "field": "messages"}]}]}';
        
        $data = json_decode($json, true);

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
                    
                    //MUDANÇAS DE STATUS
                    if (isset($change['value']['statuses'])) {
                        $statuses = $change['value']['statuses'] ?? [];

                        foreach ($statuses as $statusIndex => $status) {
                            $messageSid = $status['id'];
                            $statusType = strtoupper($status['status']);
                            $timestamp = $status['timestamp'];
                            $recipientId = $status['recipient_id'];
    
                            //atualiza o status da mensagem
                            $this->m_whatsapp->updateMessage(['SmsStatus' => $statusType], ['MessageSid' => $messageSid], ['last_updated' => 'current_timestamp()']);
                        }
                    }

                    //NOVAS MENSAGENS RECEBIDAS
                    if (isset($change['value']['messages'])) {
                        $messages = $change['value']['messages'] ?? [];
                        $to = $change['value']['metadata']['display_phone_number'] ?? '';

                        foreach ($messages as $messageIndex => $message) {
                            $messageId = $message['id'];
                            $messageType = $message['type'];
                            $messageBody = $message['text']['body'] ?? '';
                            $from = $message['from'];
                            $timestamp = $message['timestamp'];
                            $contactName = $change['value']['contacts'][0]['profile']['name'] ?? '';
                            $waId = $change['value']['contacts'][0]['wa_id'] ?? '';

                            //verifica se existe uma conversa aberta
                            $conversation = $this->m_whatsapp->getConversation(['telefoneCliente' => normalizePhone($from), 'status' => 'OPEN']);

                            if (!$conversation['existRecord']){
                                //cria conversa se necessário
                                $conversation = $this->m_whatsapp->createConversation([
                                    'telefoneCliente' => normalizePhone($from),
                                    'telefoneBot' => $to,
                                    'nomeCliente' => $contactName,
                                    'nomeBot' => 'INSIGHT',
                                    'atendenteId' => null, //TODO Routing Rule
                                    'atendenteNome' => null,
                                ]);
                            }

                            //Registra a mensagem recebida na conversa existente
                            $data = ['ConversationSid' => $conversation['firstRow']->ConversationSid, 'media_format' => $messageType, 'MessageSid' => $messageId, 'Type' => 'WHATSAPP', 'ProfileName' => $contactName, 'direction' => 'C2B', 'SmsStatus' => 'RECEIVED', 'To' => ($to), 'From' => normalizePhone($from)];
                            
                            if ($messageType == "text"){
                                $data['Body'] = $messageBody;
                            } else if ($messageType == "image"){
                                $mediaId = $message['image']['id'];
                                $mime_type = $message['image']['mime_type'];
                                $data['Body'] = $message['image']['caption'] ?? "Imagem recebida.";

                                $result = $this->m_whatsapp->getWhatsAppMedia($mediaId, $mime_type);
                                if ($result['sucesso']) {$data['media_name'] = $result['fileName'];}

                            } else if ($messageType == "audio"){
                                $mediaId = $message['audio']['id'];
                                $mime_type = $message['audio']['mime_type'];
                                $data['Body'] = "Áudio recebido.";
                                $result = $this->m_whatsapp->getWhatsAppMedia($mediaId, $mime_type);
                                if ($result['sucesso']) {$data['media_name'] = $result['fileName'];}
                            }

                            $this->m_whatsapp->createMessage($data, $conversation);
                            $this->m_whatsapp->updateConversation(['msgCount' => $conversation['firstRow']->msgCount + 1], ['id' => $conversation['firstRow']->id], ['last_updated' => 'current_timestamp()']);
                        }
                    }
                }
            }
        } else {
            $this->telegram->notifyTelegramGroup("🚨🚨🚨 META Webhook error: \n" . $json, telegramQuid);
        }

        http_response_code(200);
    }

    //http://localhost/InsightSuite/public/whatsapp-send-template
    public function whatsapp_send_template(){
        $this->checkSession();

        $to = '5531995781355';
        $nomeCliente = 'Dantas';
        $templateName = "antedimento_telefonico";
        $atendenteId = $this->session->userId ?? 1;
        $atendenteNome = $this->session->nickname ?? 'Dantas';

        //verifica se existe uma conversa aberta
        $conversation = $this->m_whatsapp->getConversation(['telefoneCliente' => normalizePhone($to), 'status' => 'OPEN']);
        
        if (!$conversation['existRecord']){
            //cria conversa se necessário
            $conversation = $this->m_whatsapp->createConversation([
                'telefoneCliente' => normalizePhone($to),
                'telefoneBot' => fromWhatsApp,
                'nomeCliente' => $nomeCliente,
                'nomeBot' => 'INSIGHT',
                'atendenteId' => $this->session->userId,
                'atendenteNome' => $this->session->nickname,
            ]);
        }

        $result = $this->m_whatsapp->sendWhatsAppTemplate($templateName, $to, $conversation);

        if ($result['sucesso']) {
            echo $result["message"]['messageId'];
        } else {
            echo $result["error"];
        }
    }

    //http://localhost/InsightSuite/public/whatsapp-send-text
    public function whatsapp_send_text(){
        $this->checkSession();
        
        $to = '5531995781355';
        $nomeCliente = 'Dantas';
        $atendenteId = $this->session->userId ?? 1;
        $atendenteNome = $this->session->nickname ?? 'Dantas';
        $body = 'Novo teste B2c';

        //verifica se existe uma conversa aberta
        $conversation = $this->m_whatsapp->getConversation(['telefoneCliente' => normalizePhone($to), 'status' => 'OPEN']);
        
        //cria conversa se necessário
        if (!$conversation['existRecord']) $conversation = $this->m_whatsapp->createConversation(['telefoneCliente' => normalizePhone($to),'telefoneBot' => fromWhatsApp,'nomeCliente' => $nomeCliente,'nomeBot' => 'INSIGHT','atendenteId' => $this->session->userId,'atendenteNome' => $this->session->nickname,]);

        $result = $this->m_whatsapp->sendWhatsApp($body, $to, $conversation);

        echo $result["message"]['messageId'] ?? $result["error"];
    }

    //http://localhost/InsightSuite/public/whatsapp-listner/1/1/6128123e-12e0-11f0-983b-fe427d5affb6/14
    public function whatsapp_listner($atendenteId, $topConversation, $ConversationSid, $topMessage){

        //todas novas conversas acima dos ids já buscados
        $sql = "SELECT id, ConversationSid, telefoneCliente, nomeCliente FROM whatsapp_conversations WHERE id > $topConversation AND status = 'OPEN' and atendenteId = 1;";
        $incomingConversations = $this->dbMasterDefault->runQuery($sql);

        //listar conversas abertas para o usuario logado com o código da Mensagem mais atual existente
        $incomingNewMessages = $this->m_whatsapp->getConversationTopMsgShort($atendenteId);

        //todas novas mensagens acima dos ids já buscados para uma conversa
        $sql = "select id, ConversationSid, Body, ProfileName, direction, l.Type, media_format, media_name, SmsStatus, l.To, l.From, l.error, last_updated from whatsapp_log l where ConversationSid = '$ConversationSid' and id > $topMessage order by id;";
        $incomingMessageDetails = $this->dbMasterDefault->runQuery($sql);

        $saidaConversas = ['newConversations' => []];
        $saidaMensagens = ['newMessages' => []];
        $saidaMensagensDetalhe = ['newMessageDetails' => []];
        
        if ($incomingConversations['existRecord']){$saidaConversas = ['newConversations' => $incomingConversations["result"]->getResult()];}
        if ($incomingNewMessages['existRecord']){$saidaMensagens = ['newMessages' => $incomingNewMessages["result"]->getResult()];}
        if ($incomingMessageDetails['existRecord']){$saidaMensagensDetalhe = ['newMessageDetails' => $incomingMessageDetails["result"]->getResult()];}

        echo json_encode($saidaConversas + $saidaMensagens + $saidaMensagensDetalhe);
    }

    //http://localhost/InsightSuite/public/whatsapp-direct
    public function whatsapp_direct(){
        // Recupera o JSON do corpo da requisição
        $json = file_get_contents("php://input");
        $request = json_decode($json, true);

        // Acessa os dados
        $messageToSend = $request['message'] ?? '';
        $conversationSid = $request['conversationSid'] ?? '';
        $returnData["sucesso"] = false;

        //verifica se existe uma conversa aberta
        $conversation = $this->m_whatsapp->getConversation(['conversationSid' => $conversationSid]);
        if ($conversation['existRecord']){
            $telefoneCliente = $conversation['firstRow']->telefoneCliente;

            if (!empty($telefoneCliente)){
                $returnData = $this->m_whatsapp->sendWhatsApp($messageToSend, $telefoneCliente, $conversation);
                //messageDetail.direction, messageDetail.last_updated, messageDetail.Body, messageDetail.ProfileName
                $returnData["direction"] = "B2C";
                $returnData["last_updated"] = time_elapsed_string(date("Y-m-d H:i:s"));
                $returnData["Body"] = $messageToSend;
                $returnData["ProfileName"] = "INSIGHT";
            }
        }

        header("Content-Type: application/json");
        echo json_encode($returnData);
    }
        
}
