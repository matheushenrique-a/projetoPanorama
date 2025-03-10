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
        parent::setDB("fgtsDB"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
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
        $error = "";
        $sucesso = "";

        if (!empty($btnSalvar)){

            if ((strlen($cpf) != 11) or (empty($nomeCompleto))){
                $error = "Digite um nome e CPF completos";
            } else {
                $cliente = $this->dbMaster->select('aaspa_cliente', ['cpf' => $cpf]);
                if ($cliente['existRecord']){
                    $this->dbMaster->update('aaspa_cliente', ['celular' => $celular, 'nome' => $nomeCompleto, 'assessor' => $this->session->nickname], ['cpf' => $cpf], ['last_update' => 'current_timestamp()']);
                } else {
                    $added = $this->dbMaster->insert('aaspa_cliente',['nome' => $nomeCompleto, 'cpf' => $cpf, 'celular' => $celular, 'assessor' => $this->session->nickname]);
                }
    
                if ($tipoMensagem == "WPP"){
                    //$this->twilio->sendWhatsApp("Olá 👋🏻! Somos da *PRA VOCE* e observamos que recentemente você utilizou nosso site ou WhatsApp. Caso tenha ficado alguma dúvida, responda a essa mensagem para falar com nosso time de atendimento. Desde já agradecemos pela atenção e interesse 🙏🏻!", $celularWaId);
                } 
    
                if ($tipoMensagem == "SMS-GOOGLE"){
                    $linkGoogle = $this->dbMaster->select('user_account', ['nickname' => $this->session->nickname])['firstRow']->observacao;
                    $resultSMS = $this->twilio->sendSMS( $celularWaId, "Ola $fname, por favor acessar o endereco $linkGoogle");
                    
                    if ($resultSMS['status']){
                        $sucesso = $resultSMS['mensagem'];
                    } else {
                        $error = $resultSMS['mensagem'];
                    }

                } else if ($tipoMensagem == "SMS-AASPA"){
                    if ($linkAaspa == ""){
                        $error = "Informe o link do AASPA";
                    } else {
                        $resultSMS = $this->twilio->sendSMS( $celularWaId, "Ola $fname, por favor acessar o endereco $linkAaspa");
                        if ($resultSMS['status']){
                            $sucesso = $resultSMS['mensagem'];
                        } else {
                            $error = $resultSMS['mensagem'];
                        }
                    }
                }   
            }
        } 

        $db =  $this->dbMaster->getDB();
        $builder = $db->table('whatsapp_log');
        $builder->Like('whatsapp_log.To', substr($celular,-8)); //bug do número 9 no whatsapp
        $builder->orLike('whatsapp_log.From', substr($celular,-8));
        $builder->orderBy('id', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$chat = $this->dbMaster->resultfy($builder->get());
        $data['chat'] = $chat;

        $db =  $this->dbMaster->getDB();
        $builder = $db->table('customer_journey');
        $builder->Where('verificador', $cpf);
        $builder->orderBy('id_interaction', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$journey = $this->dbMaster->resultfy($builder->get());
        $data['journey'] = $journey;


        $data['nomeCompleto'] = $nomeCompleto;
        $data['cpf'] = $cpf;
        $data['celular'] = $celular;
        $data['linkAaspa'] = $linkAaspa;
        $data['tipoMensagem'] = $tipoMensagem;
        $data['error'] = $error;
        $data['sucesso'] = $sucesso;

        return $this->loadpage('aaspa/zapsms', $data);
    }

    
}
