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
        // $idDominio = $this->getpost('idDominio');
		// $idCampanha = $this->getpost('idCampanha');
		// $idSkill = $this->getpost('idSkill');
		// $idLote = $this->getpost('idLote');
        // $idLigacao = $this->getpost('idLigacao');
		// $dataInicioLigacao = $this->getpost('dataInicioLigacao');
		// $idTipoWebhook = $this->getpost('idTipoWebhook');

        $codCliente = $this->getpost('codCliente');
		$nomeCliente = $this->getpost('nomeCliente');
		$cpfCnpj = $this->getpost('cpfCnpj');
		$nomeUsuario = strtoupper($this->getpost('nomeUsuario'));
		$telefone = $this->getpost('telefone');
		$telefoneE164 = $this->getpost('telefoneE164');

        $codCliente = "_aDmnVGyECSiY9Aza3Qq9YwkhmUQ%3D";
        $nomeCliente = "PEDRO HENRIQUE DE SOUZA";
        $cpfCnpj = "";
        $nomeUsuario = "FERNANDO DANTAS DOS SANTOS JUNIOR";
        $idLigacao = 107372507;
        $dataInicioLigacao = "2025-03-14T13:46:00.000Z";
        $telefoneE164 = "5573981487632";

        if (!empty($nomeCliente)){
            $this->dbMasterDefault->insert('aaspa_cliente',['codCliente' => $codCliente, 'nome' => $nomeCliente, 'cpf' => $cpfCnpj, 'celular' => $telefoneE164, 'assessor' => $nomeUsuario, 'dataInicioLigacao' => $dataInicioLigacao, 'idLigacao' => $idLigacao]);
        }
        http_response_code(200);

    }


    
    
}
