<?php

namespace App\Controllers\Argus;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_twilio;
use Config\Services;

class Argus extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        //$this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
    }


    // {
    //     "idDominio": 585,
    //     "idCampanha": 1,
    //     "idSkill": 2,
    //     "idLote": 1164,
    //     "nrPlan": 68899135,
    //     "codCliente": "_aDmnVGyECSiY9Aza3Qq9YwkhmUQ%3D",
    //     "nomeCliente": "TEREZA COSTA VIEIRA DE BRITO",
    //     "cpfCnpj": "",
    //     "codUsuarioIntegracao": "168",
    //     "nomeUsuario": "LARA DIANA SANTOS",
    //     "idLigacao": 107372507,
    //     "dataInicioLigacao": "2025-03-14T13:46:00.000Z",
    //     "telefone": "73981487632",
    //     "telefoneE164": "5573981487632",
    //     "idTipoWebhook": 1
    // }




    
    //https://a613-2804-1b3-6149-9c04-d1cc-cd1c-6041-2e1c.ngrok-free.app/InsightSuite/public/argus-atendimento-webhook
    public function argus_atendimento_webhook(){
        $request = file_get_contents('php://input');
        $response = json_decode($request, true);

        //        {"idDominio":585,"idCampanha":1,"idSkill":2,"idLote":1123,"nrPlan":66308183,"codCliente":"_ZSv7X2ODCyCc%2BA3T2ALEFxM8","nomeCliente":"GINA ROSANE SILVEIRA DA FONSECA","cpfCnpj":"","codUsuarioIntegracao":"136","nomeUsuario":"BRUNA GUIMAR\u00C3ES DE OLIVEIRA","idLigacao":107468132,"dataInicioLigacao":"2025-03-17T09:17:14.000Z","telefone":"53981097589","telefoneE164":"5553981097589","idTipoWebhook":1}

        if ((isset($response['nomeCliente']))) {
            $idDominio = $response['idDominio'];
            $idCampanha = $response['idCampanha'];
            $idSkill = $response['idSkill'];
            $idLote = $response['idLote'];
            $idLigacao = $response['idLigacao'];
            $dataInicioLigacao = $response['dataInicioLigacao'];
            $idTipoWebhook = $response['idTipoWebhook'];

            $codCliente = $response['codCliente'];
            $nomeCliente = $response['nomeCliente'];
            $cpfCnpj = $response['cpfCnpj'];
            $nomeUsuario = $response['nomeUsuario'];
            $telefoneE164 = $response['telefoneE164'];

            //$this->telegram->notifyTelegramGroup($nomeCliente);

            if (!empty($nomeCliente)){
                $this->dbMasterDefault->insert('aaspa_cliente',['codCliente' => $codCliente, 'nome' => $nomeCliente, 'cpf' => $cpfCnpj, 'celular' => $telefoneE164, 'assessor' => $nomeUsuario, 'dataInicioLigacao' => $dataInicioLigacao, 'idLigacao' => $idLigacao]);
            }
            http_response_code(200);
            
        }

      

        // $codCliente = "_aDmnVGyECSiY9Aza3Qq9YwkhmUQ%3D";
        // $nomeCliente = "PEDRO HENRIQUE DE SOUZA";
        // $cpfCnpj = "";
        // $nomeUsuario = "FERNANDO DANTAS DOS SANTOS JUNIOR";
        // $idLigacao = 107372507;
        // $dataInicioLigacao = "2025-03-14T13:46:00.000Z";
        // $telefoneE164 = "5573981487632";


        //$output = $this->telegram->notifyTelegramGroup("CALL codCliente: $nomeCliente, $nomeUsuario: $idLigacao");
    }

        //https://8b46-177-73-197-2.ngrok-free.app/InsightSuite/public/argus-atendimento-webhook-vap
        //https://localhost/InsightSuite/public/argus-atendimento-webhook-vap
        //https://insightsuite.pravoce.io/argus-atendimento-webhook-vap
        public function argus_atendimento_webhook_vap(){
            $request = file_get_contents('php://input');
            $response = json_decode($request, true);

            //$this->telegram->notifyTelegramGroup("Nome " . $response['nomeCliente'] . " - "  . $request, telegramQuid);
    
            if ((isset($response['nomeCliente']))) {
                $idDominio = $response['idDominio'];
                $idCampanha = $response['idCampanha'];
                $idSkill = $response['idSkill'];
                $idLote = $response['idLote'];
                $idLigacao = $response['idLigacao'];
                $dataInicioLigacao = $response['dataInicioLigacao'];
                $idTipoWebhook = $response['idTipoWebhook'];
    
                $codCliente = $response['codCliente'];
                $nomeCliente = $response['nomeCliente'];
                $cpfCnpj = $response['cpfCnpj'];
                $nomeUsuario = $response['nomeUsuario'];
                $telefoneE164 = "55" . $response['telefone'];
    
                
                if (!empty($nomeCliente)){
                    $this->dbMasterDefault->insert('aaspa_cliente_vap',['codCliente' => $codCliente, 'nome' => $nomeCliente, 'cpf' => $cpfCnpj, 'celular' => $telefoneE164, 'assessor' => $nomeUsuario, 'dataInicioLigacao' => $dataInicioLigacao, 'idLigacao' => $idLigacao]);
                }
                http_response_code(200);
                
            }
    
          
    
            // $codCliente = "_aDmnVGyECSiY9Aza3Qq9YwkhmUQ%3D";
            // $nomeCliente = "PEDRO HENRIQUE DE SOUZA";
            // $cpfCnpj = "";
            // $nomeUsuario = "FERNANDO DANTAS DOS SANTOS JUNIOR";
            // $idLigacao = 107372507;
            // $dataInicioLigacao = "2025-03-14T13:46:00.000Z";
            // $telefoneE164 = "5573981487632";
    
    
            //$output = $this->telegram->notifyTelegramGroup("CALL codCliente: $nomeCliente, $nomeUsuario: $idLigacao");
    
    
    
        }


    
    
}
