<?php

namespace App\Controllers\Aaspa;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\m_twilio;
use Config\Services;

class Aaspa extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
    }

    public function zapsms(){
        $data['pageTitle'] = "AASPA - Enviar SMS e WhatsApp";

        //DADOS PESSOAIS
        $nomeCompleto = strtoupper($this->getpost('nomeCompleto'));
        $celular = $this->getpost('celular');
        $celularWaId = celularToWaId($celular);
        $fname = firstName($nomeCompleto);

        $cpf = numberOnly($this->getpost('cpf'));
        $sms = strtoupper($this->getpost('sms'));
        $tipoMensagem = strtoupper($this->getpost('tipoMensagem'));
        $linkAaspa = strtoupper($this->getpost('linkAaspa'));
        $btnSalvar = $this->getpost('btnSalvar');

        $returnData["status"] = false;
		$returnData["mensagem"] = "";

        if (!empty($btnSalvar)){
            if ((strlen($cpf) != 11) or (empty($nomeCompleto))){
                $returnData["mensagem"] = "Digite um nome e CPF completos";
            } else if ((strlen($celularWaId) != 13)){
                $returnData["mensagem"] = "O telefone deve conter 11 números. Exemplo 31-99999-9999";
            } else {

                $this->dbMasterDefault->insert('record_log',['log' => "ZAPSMS " . $nomeCompleto . " - " . $celular . " - " . $cpf . " - " . $sms . " - " . $tipoMensagem . " - " . $linkAaspa . " - " . $this->session->nickname]);

                $cliente = $this->dbMasterDefault->select('aaspa_cliente', ['cpf' => $cpf]);
                if ($cliente['existRecord']){
                    $this->dbMasterDefault->update('aaspa_cliente', ['celular' => $celularWaId, 'nome' => $nomeCompleto, 'assessor' => $this->session->email], ['cpf' => $cpf], ['last_update' => 'current_timestamp()']);
                } else {
                    $added = $this->dbMasterDefault->insert('aaspa_cliente',['nome' => $nomeCompleto, 'cpf' => $cpf, 'celular' => $celularWaId, 'assessor' => $this->session->email]);
                }
    
                if ($tipoMensagem == "WPP"){
                    //$this->twilio->sendWhatsApp("Olá 👋🏻! Somos da *PRA VOCE* e observamos que recentemente você utilizou nosso site ou WhatsApp. Caso tenha ficado alguma dúvida, responda a essa mensagem para falar com nosso time de atendimento. Desde já agradecemos pela atenção e interesse 🙏🏻!", $celularWaId);
                    $returnData =  $this->twilio->sendWhatsAppTemplate("HX813435d38d3962826c91ae0736608191", $celularWaId); //HX813435d38d3962826c91ae0736608191 = Olá, tudo bem? Vamos prosseguir com seu atendimento telefônico por aqui. Para continuar, responda SIM abaixo.
                } 
    
                if ($tipoMensagem == "SMS-GOOGLE"){
                    $linkGoogle = $this->dbMasterDefault->select('user_account', ['nickname' => $this->session->nickname])['firstRow']->observacao;
                    $returnData =  $this->twilio->sendSMS( $celularWaId, "Ola $fname, por favor acessar o endereco $linkGoogle");
                } else if ($tipoMensagem == "SMS-AASPA"){
                    if ($linkAaspa == ""){
                        $returnData["mensagem"] = "Informe o link do AASPA";
                    } else {
                        $returnData =  $this->twilio->sendSMS( $celularWaId, "Ola $fname, por favor acessar o endereco $linkAaspa");
                    }
                }   
            }
        } 


        $chat = null;
        if ((!empty($cpf)) or (!empty($celular))){
            $db =  $this->dbMasterDefault->getDB();
            $builder = $db->table('whatsapp_log');
            $builder->Like('whatsapp_log.To', substr($celularWaId,-8)); //bug do número 9 no whatsapp
            $builder->orLike('whatsapp_log.From', substr($celularWaId,-8));
            $builder->orderBy('id', 'DESC');
            $builder->select('*');
            //echo $builder->getCompiledSelect();exit;
            $chat = $this->dbMasterDefault->resultfy($builder->get());
        }
        $data['chat'] = $chat;

        $db =  $this->dbMasterDefault->getDB();
        $builder = $db->table('customer_journey');
        $builder->Where('verificador', $cpf);
        $builder->orderBy('id_interaction', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$journey = $this->dbMasterDefault->resultfy($builder->get());
        $data['journey'] = $journey;


        $data['nomeCompleto'] = $nomeCompleto;
        $data['cpf'] = $cpf;
        $data['celular'] = $celular;
        $data['linkAaspa'] = $linkAaspa;
        $data['tipoMensagem'] = $tipoMensagem;
        $data['returnData'] = $returnData;

        return $this->loadpage('aaspa/zapsms', $data);
    }

    
}
