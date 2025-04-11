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


    public function listaOPeradores(){
        $this->dbMasterDefault->setOrderBy(array('nickname', 'ASC'));
        $users = $this->dbMasterDefault->select('user_account', ['empresa' => $this->session->empresa]);
		return $users;
    }  

    //http://localhost/InsightSuite/public/argus-listar-chamadas
    public function listarChamadas(){
        $buscarProp = $this->getpost('buscarProp');
        $company = "";
        if ($this->session->empresa == "VAP"){$company = "_vap";}
        $users = $this->listaOPeradores();

        if (!empty($buscarProp)){
            helper('cookie');
            $cpf = $this->getpost('txtCPF', false);
            $idLigacao = $this->getpost('idLigacao', false);
            $celular = $this->getpost('celular', false);
            $nome = $this->getpost('txtNome', false);
            $emailPessoal = $this->getpost('emailPessoal', false);
            //echo '22:16:13 - <h3>Dump 87 </h3> <br><br>' . var_dump($emailPessoal); exit;					//<-------DEBUG
            $statusWhatsApp = $this->getpost('statusWhatsApp', false);
            $paginas = $this->getpost('paginas', false);
            $operadorFiltro = $this->getpost('operadorFiltro', false);
            $flag = $this->getpost('flag',false);
            
            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('idLigacao', $idLigacao);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('emailPessoal', $emailPessoal);
            Services::response()->setCookie('statusWhatsApp', $statusWhatsApp);
            Services::response()->setCookie('paginas', $paginas);
            Services::response()->setCookie('operadorFiltro', $operadorFiltro);
            Services::response()->setCookie('flag', $flag);

            //$aux = Services::request()->getCookie($valor);	
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $idLigacao = $this->getpost('idLigacao', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $emailPessoal = $this->getpost('emailPessoal', true);
            $statusWhatsApp = $this->getpost('statusWhatsApp', true);
            $paginas = $this->getpost('paginas', true);
            $operadorFiltro = $this->getpost('operadorFiltro', true);
            $flag = $this->getpost('flag',true);
        }

        $flag = (empty($flag) ? 'ACAO' : $flag);
        
        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];
        
        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        //if (!empty($paginas)) $whereCheck['paginas'] = $paginas;
        if (!empty($idLigacao)) $likeCheck['idLigacao'] = $idLigacao;
        if (!empty($celular)) $likeCheck['celular'] = numberOnly($celular);
        if (!empty($statusWhatsApp)) $whereCheck['statusProposta'] = $statusWhatsApp;
        if (!empty($nome)) $likeCheck['nome'] = $nome;
        if (!empty($emailPessoal)) $likeCheck['emailPessoal'] = $emailPessoal;
        if ($flag == "OPTIN") $whereCheck['Optin_pan'] = "V";
        
        //foreach($fasesAdd as $item){echo "'" . $item . "', ";}exit;

        $likeCheck = array("likeCheck" => $likeCheck);

        $paginas = (empty($paginas)  ? 10 : $paginas); 
        $this->dbMasterDefault->setLimit($paginas);
        $this->dbMasterDefault->setOrderBy(array('id_proposta', 'DESC'));
       //$propostas = $this->dbMasterDefault->select('aaspa_cliente_vap', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

       

        $query = "select *, (select count(*) from whatsapp_log w where w.to = c.celular) messages from aaspa_cliente$company c where 1=1 ";
        if (!empty($cpf))
            $query .= " and c.cpf like '%$cpf%' ";
        if (!empty($idLigacao))
            $query .= "and c.idLigacao like '%$idLigacao%' ";
        if (!empty($celular))
            $query .= "and c.celular like '%$celular%' ";
        if (!empty($nome))
            $query .= "and c.nome like '%$nome%' ";
        if (!empty($operadorFiltro))
            $query .= "and c.assessor like '%$operadorFiltro%' ";
        if (!empty($statusWhatsApp))
            $query .= " having messages > 0";
        

        $query .= " order by id_proposta desc limit $paginas;";

        //echo $query;exit;
        $propostas = $this->dbMasterDefault->runQuery($query);



        $dados['pageTitle'] = "ARGUS - Listar chamadas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['paginas'] = $paginas;
        $dados['idLigacao'] = $idLigacao;
        $dados['celular'] = $celular;
        $dados['emailPessoal'] = $emailPessoal;
        $dados['statusWhatsApp'] = $statusWhatsApp;
        $dados['operadorFiltro'] = $operadorFiltro;
        $dados['users'] = $users;

        return $this->loadpage('aaspa/listar_chamadas', $dados);
    }

    
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


        //https://8b46-177-73-197-2.ngrok-free.app/InsightSuite/public/metricas-ligacao-operador
        //http://localhost/InsightSuite/public/metricas-ligacao-operador
        //https://insightsuite.pravoce.io/metricas-ligacao-operador
        public function metricas_ligacao_operador(){
            $sqlLigacoesOperador = "select assessor, count(codCliente) total from aaspa_cliente c INNER JOIN user_account u ON c.assessor = u.nickname 
            WHERE perfil_acesso LIKE '%AASPA%' AND empresa = 'QUID' AND u.status = 'ATIVO' AND u.role = 'OPERADOR'
            AND c.last_update >= '" . date('Y-m-d') . " 00:00:01' AND c.last_update <= '" . date('Y-m-d') . " 23:00:01'
            GROUP by assessor 
            ORDER BY assessor limit 100;";

            $ligacoes = $this->dbMasterDefault->runQuery($sqlLigacoesOperador);

            $sendData = "☎️☎️☎️ LIGAÇÕES DE HOJE \n";
            $totalGeral = 0;
            if ($ligacoes['existRecord']){
                foreach ($ligacoes["result"]->getResult() as $row){
                    $assessor = $row->assessor;
                    $assessorShort = substr($assessor, 0, 17) . "...";
                    $total = $row->total;
                    $totalGeral = $total + $totalGeral;

                    $sendData .=  "- $assessorShort [$total] \n";
                }
            }
            $sendData .=  "\nTotal Geral: $totalGeral\n";

            $this->telegram->notifyTelegramGroup($sendData, telegramQuid);
        }


    
    
}
