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
use App\Models\M_seguranca;

class WhatsApp extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $chatgpt;
    protected $m_whatsapp;
    protected $m_argus;
    protected $m_security;

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
        $this->m_security = new M_seguranca();
    }

    public function checkWindow(){
        $conversationWindow = $this->m_whatsapp->getConversationWindow('5531995781355');
        echo '15:59:41 - <h3>Dump 23 </h3> <br><br>' . var_dump($conversationWindow); exit;					//<-------DEBUG

    }

    //http://localhost/InsightSuite/public/whatsapp-chat
    public function whatsapp_chat(){
        $this->checkSession();

        $ConversationSid =  $this->getpost('ConversationSid') ?? '';
        $currentConversationSid =  $this->getpost('currentConversationSid') ?? '';
        $searchCRM =  $this->getpost('searchCRM');
        $searchWORK =  $this->getpost('searchWORK');
        $newConversation =  $this->getpost('newConversation');
        $newConversationWork =  $this->getpost('newConversationWork');
        $closeConversation =  $this->getpost('closeConversation');
        $messageToSend =  $this->getpost('messageToSend');
        $btnSendMsg =  $this->getpost('btnSendMsg');
        $directContact =  $this->getpost('directContact');
        
        $selectedTab = "CHAT";
        $userId = $this->session->userId;
        $atendenteNome = $this->session->nickname;
        $messages = [];
        $currentConversation = null;
        $conversationWindow = null;
        $clientesCRM = null;
        $usuariosInternos = null;
        $topConversation = null;
        $searchTerm = "";
        $typeSearch ="";

        //se o usuario clicou em uma conversa específica
        if (!empty($ConversationSid)){
            $messages = $this->m_whatsapp->getMessages(['ConversationSid' => $ConversationSid]);
            $currentConversation = $this->m_whatsapp->getConversation(['ConversationSid' => $ConversationSid]);
            $conversationWindow = $this->m_whatsapp->getConversationWindow($currentConversation['firstRow']->telefoneCliente);
            $selectedTab = "CHAT";
        } 
        //caso uma busca no CRM tenha sido feita
        else  if ((!empty($searchCRM))){
            $clientesCRM = $this->m_argus->buscarClienteCRM($searchCRM);
            $typeSearch = "CRM";

            if ($searchCRM == "CRM"){
                $searchTerm = "";
            } else {
                $searchTerm = $searchCRM;
            }
            $selectedTab = "CRM";

        //busca colegas de trabalho
        } else  if ((!empty($searchWORK))){
            $typeSearch = "WORK";
            $usuariosInternos = $this->m_security->buscarUsuarios($searchWORK);

            if ($searchWORK == "WORK"){
                $searchTerm = "";
            } else {
                $searchTerm = $searchWORK;
            }
            $selectedTab = "WORK";
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
            $selectedTab = "CHAT";
        
        }

        //caso uma nova conversa tenha sido solicitada com um colaborador interno (chat interno)
        else if (!empty($newConversationWork)){
            $usuarioInterno = $this->m_security->buscarUsuario(['userId' => $newConversationWork]);
            if ($usuarioInterno['existRecord']){
                $conversation = $this->m_whatsapp->createConversation([
                    'telefoneCliente' => null,
                    'telefoneBot' => null,
                    'nomeCliente' => $usuarioInterno['firstRow']->nickname,
                    'nomeBot' => 'WORK',
                    'atendenteId' => $this->session->userId,
                    'atendenteNome' => $this->session->nickname,
                ]);
                
                return redirect()->to('whatsapp-chat?ConversationSid=' . $conversation['firstRow']->ConversationSid);exit;
            }
            $selectedTab = "CHAT";
        
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
                $selectedTab = "CHAT";
                return redirect()->to('whatsapp-chat?ConversationSid=' . $conversation['firstRow']->ConversationSid);exit;
        //fecha uma conversa
        } else if (!empty ($closeConversation)) {
            $this->m_whatsapp->updateConversation(['status' => 'CLOSED'], ['conversationSid' => $closeConversation]);
            $selectedTab = "CHAT";
        //envia uma nova mensagem após pressionar o botão Enviar
        } else if (!empty($btnSendMsg) or !empty($messageToSend)) {
            
            //recupera a conversa antes de enviar uma mensagem
            $conversation = $this->m_whatsapp->getConversation(['ConversationSid' => $currentConversationSid]);
            if ($conversation['existRecord']){
                $result = $this->m_whatsapp->sendWhatsApp($messageToSend, normalizePhone($conversation['firstRow']->telefoneCliente), $conversation);
                
                //busca todas as mensagens trocadas
                $messages = $this->m_whatsapp->getMessages(['ConversationSid' => $currentConversationSid]);
                $currentConversation = $this->m_whatsapp->getConversation(['ConversationSid' => $currentConversationSid]);
                $conversationWindow = $this->m_whatsapp->getConversationWindow($currentConversation['firstRow']->telefoneCliente);
            }
            $selectedTab = "CHAT";
        }

        //LISTA TODAS CONVERSAS ABERTAS / CORRENTES DO USUARIO
        $conversations = $this->m_whatsapp->getConversationTopMsg($userId);

        //elege a primeira conversa com a selecionada caso nenhuma outra esteja marcada
        if ((empty($ConversationSid)) && (empty($search))){
            if ($conversations['existRecord']){
                $messages = $this->m_whatsapp->getMessages(['ConversationSid' => $conversations['firstRow']->ConversationSid]);
                $currentConversation = $this->m_whatsapp->getConversation(['ConversationSid' => $conversations['firstRow']->ConversationSid]);
                $conversationWindow = $this->m_whatsapp->getConversationWindow($currentConversation['firstRow']->telefoneCliente);
            }
        }

        //registra a conversa mais recente enviada ao cliente para monitorar e buscar números acima
        $topConversation = $this->m_whatsapp->getTopConversation($userId);
        $toptMessage = $this->m_whatsapp->getTopMessage((isset($currentConversation['firstRow']->ConversationSid)  ? $currentConversation['firstRow']->ConversationSid : 0));

        $templates = $this->whatsapp_list_templates((isset($conversationWindow['janela_aberta'])) ? $conversationWindow['janela_aberta'] : false);
        
        $data['pageTitle'] = "WhatsApp Chat";
        $data['ConversationSid'] = $ConversationSid;
        $data['toptMessage'] = $toptMessage;
        $data['conversations'] = $conversations;
        $data['messages'] = $messages;
        $data['currentConversation'] = $currentConversation;
        $data['conversationWindow'] = $conversationWindow;
        $data['clientesCRM'] = $clientesCRM;
        $data['usuariosInternos'] = $usuariosInternos;
        $data['searchCRM'] = $searchCRM;
        $data['searchWORK'] = $searchWORK;
        $data['typeSearch'] = $typeSearch;
        $data['searchTerm'] = $searchTerm;
        $data['session'] = $this->session;
        $data['topConversation'] = $topConversation;
        $data['templates'] = $templates;
        $data['selectedTab'] = $selectedTab;
        return $this->loadpage('whatsapp/chat', $data);

    }


    //http://localhost/InsightSuite/public/whatsapp-webhook
    // https://99fe-177-73-197-2.ngrok-free.app/InsightSuite/public/whatsapp-webhook
    public function whatsapp_webhook(){
        //$result = $this->m_whatsapp->getWhatsAppMedia("1357103935532763", "image/jpeg");
        //http_response_code(200);
       // exit;

        $mode =  $this->getpost('hub_mode') ?? '';
        $token =  $this->getpost('hub_verify_token') ?? '';
        $challenge =  $this->getpost('hub_challenge') ?? '';
        $WEBHOOK_VERIFY_TOKEN = 'PRAVOCE';
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

                            $returnErros = $status['errors'] ?? [];
                            foreach ($returnErros as $errorIndex => $errorArray) {
                                $detail = $errorArray['title'] ?? "";
                                $this->telegram->notifyTelegramGroup("🚨🚨🚨 Error Message $messageSid \n$detail", telegramQuid);
                            }

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
                            $data = [
                                'ConversationSid' => $conversation['firstRow']->ConversationSid,
                                'media_format' => $messageType,
                                'MessageSid' => $messageId,
                                'Type' => 'WHATSAPP',
                                'ProfileName' => $contactName,
                                'direction' => 'C2B',
                                'SmsStatus' => 'RECEIVED',
                                'To' => ($to),
                                'From' => normalizePhone($from)
                            ];
                            
                            if ($messageType == "text"){
                                $contextMessageId = $message['context']['id'] ?? "";

                                if (empty($contextMessageId)) {
                                    $data['Body'] = $messageBody;
                                } else {
                                    //reply to message
                                    $BodyOriginal = $this->dbMasterDefault->select('whatsapp_log', ['MessageSid' => $contextMessageId])['firstRow']->Body ?? "";
                                    $data['Body'] = "Em resposta a [$BodyOriginal]:<br>$messageBody";
                                }

                            } else if ($messageType == "reaction"){
                                $reactionMessage_id = $message['reaction']['message_id'];
                                $emoji = $message['reaction']['emoji'];

                                $BodyOriginal = $this->dbMasterDefault->select('whatsapp_log', ['MessageSid' => $reactionMessage_id])['firstRow']->Body ?? "";
                                $data['Body'] = "Em reação a [$BodyOriginal]<br>$emoji";
                            } else if ($messageType == "button"){
                                $data['Body'] = $message['button']['text'];
                            } else if ($messageType == "image"){
                                $mediaId = $message['image']['id'];
                                $mime_type = $message['image']['mime_type'];
                                $data['Body'] = $message['image']['caption'] ?? "Imagem recebida.";

                                $result = $this->m_whatsapp->getWhatsAppMedia($mediaId, $mime_type);
                                if ($result['sucesso']) {$data['media_name'] = $result['fileName'];}
                            } else if ($messageType == "sticker"){
                                $mediaId = $message['sticker']['id'];
                                $mime_type = $message['sticker']['mime_type'];
                                $data['Body'] = $message['image']['caption'] ?? "Sticker recebida.";

                                $result = $this->m_whatsapp->getWhatsAppMedia($mediaId, $mime_type);
                                if ($result['sucesso']) {$data['media_name'] = $result['fileName'];}

                            } else if ($messageType == "audio"){
                                $mediaId = $message['audio']['id'];
                                $mime_type = $message['audio']['mime_type'];
                                $data['Body'] = "Áudio recebido.";
                                $result = $this->m_whatsapp->getWhatsAppMedia($mediaId, $mime_type);
                                if ($result['sucesso']) {$data['media_name'] = $result['fileName'];}
                            } else if ($messageType == "video"){
                                $mediaId = $message['video']['id'];
                                $mime_type = $message['video']['mime_type'];
                                $data['Body'] = "Vídeo recebido.";
                                $result = $this->m_whatsapp->getWhatsAppMedia($mediaId, $mime_type);
                                if ($result['sucesso']) {$data['media_name'] = $result['fileName'];}
                            }

                            $this->m_whatsapp->createMessage($data, $conversation);
                            //echo '15:42:09 - <h3>Dump 16 </h3> <br><br>' . var_dump($conversation['firstRow']->id); exit;					//<-------DEBUG
                            $this->m_whatsapp->updateConversation(['dataUltimaMensagemCliente' => date('Y-m-d H:i:s'), 'msgCount' => $conversation['firstRow']->msgCount + 1], ['id' => $conversation['firstRow']->id], ['last_updated' => 'current_timestamp()']);
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
    //TWILIO
    public function whatsapp_send_template(){
        $this->checkSession();

        $to = '5531995781355';
        $nomeCliente = 'Dantas';
        $templateName = "continuar_chamada";
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

    //http://localhost/InsightSuite/public/whatsapp-send-template-cloud
    //META CLOUD API
    public function whatsapp_send_template_cloud($templateName, $body, $to, $conversation){

        //$conversation = '88f3a584-186d-11f0-9224-fe427d5affb6';
        //$to = '5531995781355';
        //$templateName = "antedimento_telefonico";

        $result = $this->m_whatsapp->sendWhatsAppTemplateCloud($templateName, $body, $to, $conversation);
        return  $result;
    }

    //http://localhost/InsightSuite/public/whatsapp-list-templates
    //META CLOUD API
    public function whatsapp_list_templates($status){

        //Direto da Meta
        //$result = $this->m_whatsapp->searchTempalte();
        $templates = $this->dbMasterDefault->select('whatsapp_templates', ['whatsAppApproved' => !$status]);

        return $templates;


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

        if (empty($ConversationSid) or ($ConversationSid == 0)){
            echo json_encode(['error' => 'ConversationSid não informado.']);exit;
        }

        //NOVAS CONVERSAS
        //Todas novas conversas acima dos ids já buscados
        $sql = "SELECT id, ConversationSid, telefoneCliente, nomeCliente FROM whatsapp_conversations WHERE id > $topConversation AND status = 'OPEN' and atendenteId = 1;";
        $incomingConversations = $this->dbMasterDefault->runQuery($sql);

        //CONVERSAS ATUAIS DO ASSESSOR
        //Listar conversas abertas para o usuario logado com o código da Mensagem mais atual existente
        $incomingNewMessages = $this->m_whatsapp->getConversationTopMsgShort($atendenteId);

        //NOVAS MENSAGENS DA CONVERTA ABERTA - ultimas 10 mensagens
        //todas novas mensagens acima dos ids já buscados para uma conversa
        //$sql = "select id, ConversationSid, Body, ProfileName, direction, l.Type, media_format, media_name, SmsStatus, l.To, l.From, l.error, last_updated from whatsapp_log l where ConversationSid = '$ConversationSid' and id > $topMessage order by id;";
        $sql = "select id, ConversationSid, Body, ProfileName, direction, l.Type, media_format, media_name, SmsStatus, l.To, l.From, l.error, last_updated from whatsapp_log l where ConversationSid = '$ConversationSid' order by id DESC LIMIT 10;";
        $incomingMessageDetails = $this->dbMasterDefault->runQuery($sql);
        foreach ($incomingMessageDetails["result"]->getResult() as $messagesToConvert){
            $messagesToConvert->SmsStatus = traduzirStatusTwilio($messagesToConvert->SmsStatus)[0];
        }

        //STATUS JANELA DA CONVERSA
        //monitora status da janela de conversa se aproveitando da lista de conversas 
        $conversationWindow = $this->m_whatsapp->getConversationWindowById($ConversationSid);

        $saidaConversas = ['newConversations' => []];
        $saidaMensagens = ['newMessages' => []];
        $saidaMensagensDetalhe = ['newMessageDetails' => []];
        $saidaConversationWindow = ['conversationWindow' => $conversationWindow];
        
        if ($incomingConversations['existRecord']){$saidaConversas = ['newConversations' => $incomingConversations["result"]->getResult()];}
        if ($incomingNewMessages['existRecord']){$saidaMensagens = ['newMessages' => $incomingNewMessages["result"]->getResult()];}
        if ($incomingMessageDetails['existRecord']){$saidaMensagensDetalhe = ['newMessageDetails' => $incomingMessageDetails["result"]->getResult()];}

        echo json_encode($saidaConversas + $saidaMensagens + $saidaMensagensDetalhe + $saidaConversationWindow);
    }

    //http://localhost/InsightSuite/public/whatsapp-direct
    public function whatsapp_direct(){
        // Recupera o JSON do corpo da requisição
        $json = file_get_contents("php://input");
        $request = json_decode($json, true);

        // Acessa os dados
        $messageToSend = $request['message'] ?? '';
        $conversationSid = $request['conversationSid'] ?? '';
        $tipo = $request['tipo'] ?? '';
        $templateName = $request['templateName'] ?? '';

        //  $messageToSend = "Olá";
        //  $conversation =  ' fb85faf8-1a01-11f0-9224-fe427d5affb6';
        //  $tipo = 'message';
        //  $telefoneCliente = '5531995781355';
        // $templateName = 'continuar_chamada';

        //$result = $this->whatsapp_send_template_cloud($templateName, $messageToSend, $telefoneCliente, $conversation);
        //echo '11:53:22 - <h3>Dump 32 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG

        //exit;

        $returnData = [];
        if (empty($messageToSend)) {$returnData["error"] = "Mensagem vazia.";}

        //verifica se existe uma conversa aberta o que sera o normal no envio direct
        $conversation = $this->m_whatsapp->getConversation(['conversationSid' => $conversationSid]);

        if ($conversation['existRecord']){
            $telefoneCliente = $conversation['firstRow']->telefoneCliente;

            if (!empty($telefoneCliente)){
                if ($tipo == 'message') {
                    $returnData += $this->m_whatsapp->sendWhatsApp($messageToSend, $telefoneCliente, $conversation);
                } else if (($tipo == 'template') and (!empty($templateName))) {
                    $returnData += $this->whatsapp_send_template_cloud($templateName, $messageToSend, $telefoneCliente, $conversation);
                }

                $returnData["Body"] = $messageToSend;
                $returnData["direction"] = "B2C";
                $returnData["last_updated"] = time_elapsed_string(date("Y-m-d H:i:s"));
                
                $returnData["ProfileName"] = "INSIGHT";
            }
        }

        header("Content-Type: application/json");
        echo json_encode($returnData);
    }

    //http://localhost/InsightSuite/public/whatsapp-auditoria
    public function whatsapp_auditoria($telefoneCliente = null){

        if (!empty($telefoneCliente)){
            $this->whatsapp_auditoria_details($telefoneCliente);
            exit;
        }

        $data_inicial = date('Y-m-d 00:00:01'); 
        $data_final = date('Y-m-d 23:59:59');

        $sql = "SELECT distinct l.To telefoneCliente FROM whatsapp_log l WHERE last_updated >= '$data_inicial' and last_updated <= '$data_final' AND l.To <> '" . normalizePhone(fromWhatsApp) . "' AND l.To <> '5531995781355';";
        $chatsDia = $this->dbMasterDefault->runQuery($sql);

        $chatTranscript = "";

        if ($chatsDia['existRecord']){
            foreach ($chatsDia["result"]->getResult() as $row){
                $telefoneCliente = $row->telefoneCliente;

                $sql = "SELECT * FROM whatsapp_log l WHERE (l.To = '$telefoneCliente' OR l.from = '$telefoneCliente') AND (last_updated >= '$data_inicial' and last_updated <= '$data_final') ORDER BY id DESC; ";
                $chatDetail = $this->dbMasterDefault->runQuery($sql);

                $chatTranscript .= "<h2>Chat com cliente: $telefoneCliente </h2>\n";
                
                if ($chatDetail['existRecord']){
                    foreach ($chatDetail["result"]->getResult() as $row){
                        $chatTranscript .= $row->id . "-" . $row->ProfileName . ": " . $row->Body . "<br>\n";
                    }
                }
            }
        }

        $basePrompt = "Você é o supervisor de um time de vendas de um produto chamado AASAP e deve fazer uma auditoria 
        em todos os chats conduzidos hoje entre os vendedores e os clientes. Seu o objetivo é identificar conversas que 
        violem os termos e políticas do WhatsApp já que as conversas são realizadas por esse canal. 
        Você deve identificar casos de desconforto pelo cliente na conversa que possa resultar em bloqueio ou 
        report de spam pelo cliente. Você também deve identificar situações onde preço ou custo do produto é discutida, 
        essa tema é proibido de ser tratado pelo chat pela minha empresa. Agora, leia os chats abaixo e retorne uma coleção 
        json chamada auditoria contendo items com 3 colunas: telefone_cliente: número do telefone do cliente, gravidade: o nível de gravidade 
        do desvio ou do risco gerado pelo vendedor, frase_feedback: uma frase com um feedback para orientar o 
        vendedor sobre o ocorrido e como evitar esse tipo de ocorrência. Abaixo está a lista de conversas \n\n";

        $basePrompt .= $chatTranscript;
        
        $result = $this->chatgpt->runQuery($basePrompt, 'json');

        if ($result['existResposta']) {
            if (isset($result['conteudo'])){
                $data = json_decode($result['conteudo'], true);

                if (isset($data['auditoria'])){
                    foreach ($data['auditoria'] as $item) {
                        // echo "Telefone do cliente: " . $item['telefone_cliente'] . "<bR>";
                        // echo "Gravidade: " . $item['gravidade'] . "<bR>";
                        // echo "Feedback: " . $item['frase_feedback'] . "<bR>";
                        // echo str_repeat("-", 50) . "<bR>";

                        $userId = null;
                        $ultimaLigacao = $this->m_argus->ultimaLigacao(['celular' => $item['telefone_cliente']]);
                        if ($ultimaLigacao['existRecord']){
                            $userId = $this->dbMasterDefault->select('user_account', ['nickname' => $ultimaLigacao['firstRow']->assessor])['firstRow']->userId;
                        }

                        $dataNotificacao = [
                            'userId' => $userId,
                            'notifica_user' => true,
                            'notifica_supervisor' => true,
                            'notifica_manager' => true,
                            'contexto_grupo' => "AASPA",
                            'last_updated' => date('Y-m-d H:i:s'),
                            'tipo' => "auditoria_whatsapp",
                            'titulo' => "Inspetor WhatsApp IA",
                            'json_detalhes' => json_encode($item),
                        ];

                        $added = $this->dbMasterDefault->insert('insight_notificacoes', $dataNotificacao);

                        $this->telegram->notifyTelegramGroup("❌❌❌ AUDITORIA WhatsApp - [" . numberOnly($item['telefone_cliente']) . "][" . $item['gravidade'] . "\n" . $item['frase_feedback'] . "\nInspecionar:\n" . rootURL  . "whatsapp-auditoria/" . $item['telefone_cliente'], telegramQuid);
                    }
                } else {
                    $this->telegram->notifyTelegramGroup("❌❌❌ AUDITORIA WhatsApp ERRO - Auditoria Inválida", telegramQuid);
                }
            }
        }
    }

    public function whatsapp_auditoria_details($telefoneCliente){
        $sql = "SELECT * FROM whatsapp_log l WHERE (l.To = '$telefoneCliente' OR l.from = '$telefoneCliente') ORDER BY id; ";
        $chatDetail = $this->dbMasterDefault->runQuery($sql);

        echo "<h2>Chat com cliente: $telefoneCliente </h2>";
        
        if ($chatDetail['existRecord']){
            foreach ($chatDetail["result"]->getResult() as $row){
                echo dataUsPtHours($row->last_updated, true) . " - " . $row->id . " - " . $row->ProfileName . ": " . $row->Body . "<br>";
            }
        }

    }

    public function whatsapp_listar_templates(){
        $buscarProp = $this->getpost('buscarProp');
        $fases = $this->listarCategoriaTemplates();

        if (!empty($buscarProp)){
            helper('cookie');
            $content = $this->getpost('content', false);
            $display_name = $this->getpost('display_name', false);
            $whatsAppApproved = $this->getpost('whatsAppApproved', false);
               
            Services::response()->setCookie('content', $content);
            Services::response()->setCookie('display_name', $display_name);
            Services::response()->setCookie('whatsAppApproved', $whatsAppApproved);
        } else {
            $content = $this->getpost('content', true);
            $display_name = $this->getpost('display_name', true);
            $whatsAppApproved = $this->getpost('whatsAppApproved', true);
        }
        
        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];
        
        if (!empty($content)) $likeCheck['content'] = $content;
        if (!empty($display_name)) $whereCheck['display_name'] = $display_name;
        if (!empty($whatsAppApproved)) $whereCheck['whatsAppApproved'] = $whatsAppApproved;

        $likeCheck = array("likeCheck" => $likeCheck);

        $paginas = (empty($paginas)  ? 10 : $paginas); 
        $this->dbMaster->setLimit($paginas);
        $this->dbMaster->setOrderBy(array('template_id', 'DESC'));
        $templates = $this->dbMaster->select('whatsapp_templates', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

        $dados['pageTitle'] = "WhatsApp - Listar propostas";
        $dados['templates'] = $templates;
        $dados['content'] = $content;
        $dados['display_name'] = $display_name;
        $dados['whatsAppApproved'] = $whatsAppApproved;
        $dados['paginas'] = $paginas;
        
        //echo '15:27:27 - <h3>Dump 91 </h3> <br><br>' . var_dump($fases); exit;					//<-------DEBUG
        $dados['fases'] = $fases;

        return $this->loadpage('whatsapp/whatsapp-listar-templates', $dados);
    }

    public function whatsapp_criar_templates($template_id = 0, $action){
        $dados['pageTitle'] = "WhatsApp - Criar/Editar Template";
        
        $btnSalvar = $this->getpost('btnSalvar');
        $display_name = $this->getpost('display_name');
        $content = $this->getpost('content');
        $whatsAppApproved = $this->getpost('whatsAppApproved');
        $fases = $this->listarCategoriaTemplates();

        if ($action == "remove") {
            $this->dbMaster->delete('whatsapp_templates', ['template_id' => $template_id]);
            return redirect()->to('whatsapp-listar-templates');exit;
        
        //Entrada da Inclusão
        } else if ((empty($btnSalvar)) and ($template_id == 0)) {
            $label = "Incluir Template WhatsApp";
            $display_name = "";
            $content = "";
            $conwhatsAppApprovedtent = "";
            $template_id = 0;

        //Entrada da Edicao
        } else  if ((empty($btnSalvar)) and ($template_id != 0)) { 
            $label = "Editar Template WhatsApp";
            $template = $this->dbMaster->select('whatsapp_templates', ['template_id' => $template_id]);
            $display_name = $template['firstRow']->display_name;
            $content = $template['firstRow']->content;
            $whatsAppApproved = $template['firstRow']->whatsAppApproved;
            $whatsAppApproved = ($whatsAppApproved ? "1" : "0");

        //Submit da Inclusão
        } else  if ((!empty($btnSalvar)) and ($template_id == 0)) {  
            $display_name = (empty($display_name)  ? 'GERAL' : $display_name); 
            $content = (empty($content)  ? 'Nenhuma mensagem digitara' : $content); 
            $whatsAppApproved = ($whatsAppApproved == "0"  ? false : true);

            $added = $this->dbMaster->insert('whatsapp_templates',['display_name' => $display_name, 'content' => $content, 'whatsAppApproved' => $whatsAppApproved]);
            return redirect()->to('whatsapp-listar-templates');exit;

        //Submit da Edição
        } else  if ((!empty($btnSalvar)) and ($template_id != 0)) {
            $display_name = (empty($display_name)  ? 'GERAL' : $display_name); 
            $content = (empty($content)  ? 'Nenhuma mensagem digitara' : $content); 
            $whatsAppApproved = ($whatsAppApproved == "0"  ? false : true);
            
            $this->dbMaster->update('whatsapp_templates', ['display_name' => $display_name, 'content' => $content, 'whatsAppApproved' => $whatsAppApproved], ['template_id' => $template_id], ['last_update' => 'current_timestamp()']);
            return redirect()->to('whatsapp-listar-templates');exit;
        }


        $dados['label'] = $label;
        $dados['fases'] = $fases;
        $dados['display_name'] = $display_name;
        $dados['content'] = $content;
        $dados['whatsAppApproved'] = $whatsAppApproved;
        $dados['template_id'] = $template_id;

        return $this->loadpage('whatsapp/whatsapp-criar-templates', $dados);
    }

    public function listarCategoriaTemplates(){
        $db =  $this->dbMaster->getDB();
        $builder = $db->table('whatsapp_templates');
        $builder->orderBy('display_name', 'ASC');
        $builder->distinct();
        $builder->select('display_name');
		//echo $builder->getCompiledSelect();exit;
		return $this->dbMaster->resultfy($builder->get());
    }
        
}
