<?php

namespace App\Controllers\Aaspa;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_twilio;
use Config\Services;
use App\Models\M_integraall;
use App\Models\M_argus;

class Aaspa extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $m_integraall;
    protected $m_argus;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->twilio =  new M_twilio();
        $this->m_integraall =  new M_integraall();
        $this->m_argus =  new M_argus();
    }



    public function argus_atendimento_webhook(){
        echo "13:32:22 - Breakpoint 9"; exit;					//<-------DEBUG
        

    }


    public function zapsms(){
        //$this->twilio->users();exit;
        $data['pageTitle'] = "AASPA - Enviar SMS e WhatsApp";

        //DADOS PESSOAIS
        $nomeCompleto = strtoupper($this->getpost('nomeCompleto'));
        $celular = $this->getpost('celular');
        $celularWaId = celularToWaId($celular);
        $fname = firstName($nomeCompleto);

        //$cpf = numberOnly($this->getpost('cpf'));
        $sms = strtoupper($this->getpost('sms'));
        $tipoMensagem = strtoupper($this->getpost('tipoMensagem'));
        $linkAaspa = strtoupper($this->getpost('linkAaspa'));
        $btnSalvar = $this->getpost('btnSalvar');
        $btnConsultar = $this->getpost('btnConsultar');

        $returnData["status"] = false;
		$returnData["mensagem"] = "";

        if (!empty($btnSalvar)){
            if ((strlen($celularWaId) != 13)){
                $returnData["mensagem"] = "O telefone deve conter 11 números. Exemplo 31-99999-9999";
            } else {

                $this->dbMasterDefault->insert('record_log',['log' => "ZAPSMS " . $nomeCompleto . " - " . $celular . " - " . $sms . " - " . $tipoMensagem . " - " . $linkAaspa . " - " . $this->session->nickname]);

                // $cliente = $this->dbMasterDefault->select('aaspa_cliente', ['cpf' => $cpf]);
                // if ($cliente['existRecord']){
                //     $this->dbMasterDefault->update('aaspa_cliente', ['celular' => $celularWaId, 'nome' => $nomeCompleto, 'assessor' => $this->session->email], ['cpf' => $cpf], ['last_update' => 'current_timestamp()']);
                // } else {
                //     $added = $this->dbMasterDefault->insert('aaspa_cliente',['nome' => $nomeCompleto, 'cpf' => $cpf, 'celular' => $celularWaId, 'assessor' => $this->session->email]);
                // }
    
                if ($tipoMensagem == "WPP"){
                    //$this->twilio->sendWhatsApp("Olá 👋🏻! Somos da *PRA VOCE* e observamos que recentemente você utilizou nosso site ou WhatsApp. Caso tenha ficado alguma dúvida, responda a essa mensagem para falar com nosso time de atendimento. Desde já agradecemos pela atenção e interesse 🙏🏻!", $celularWaId);
                    $returnData =  $this->twilio->sendWhatsAppTemplate("HX813435d38d3962826c91ae0736608191", $celularWaId); //HX813435d38d3962826c91ae0736608191 = Olá, tudo bem? Vamos prosseguir com seu atendimento telefônico por aqui. Para continuar, responda SIM abaixo.
                } 
    
                if ($tipoMensagem == "SMS-GOOGLE"){
                    $linkGoogle = $this->dbMasterDefault->select('user_account', ['nickname' => $this->session->nickname])['firstRow']->observacao;
                    $returnData =  $this->twilio->sendSMS($celularWaId, "Ola $fname, por favor acessar o endereco $linkGoogle", $this->session->nickname);
                } else if ($tipoMensagem == "SMS-AASPA"){
                    if ($linkAaspa == ""){
                        $returnData["mensagem"] = "Informe o link do AASPA";
                    } else {
                        $returnData =  $this->twilio->sendSMS( $celularWaId, "Ola $fname, por favor acessar o endereco $linkAaspa", $this->session->nickname);
                    }
                }   
            }
        } else if (!empty($btnConsultar)){

        } else {
            //PEGA ULTIMA LIGACAO DO ASSESSOR
            $ultimaLigacao = $this->m_argus->ultimaLigacao(['cpf' => $cpf]);
            if ($ultimaLigacao['existRecord']){
                $nomeCompleto = $ultimaLigacao['firstRow']->nomeCliente;
                $celular = $ultimaLigacao['firstRow']->telefone;
                $celularWaId = celularToWaId($celular);
            }
        }


        $chat = null;
        if ((!empty($celular))){
            $db =  $this->dbMasterDefault->getDB();
            $builder = $db->table('whatsapp_log');
            $builder->Like('whatsapp_log.To', $celularWaId); //bug do número 9 no whatsapp
            $builder->orLike('whatsapp_log.From', $celularWaId);
            $builder->orderBy('id', 'DESC');
            $builder->select('*');
            //echo $builder->getCompiledSelect();exit;
            $chat = $this->dbMasterDefault->resultfy($builder->get());
        }
        $data['chat'] = $chat;

        $db =  $this->dbMasterDefault->getDB();
        $builder = $db->table('customer_journey');
        $builder->Where('verificador', $celularWaId);
        $builder->orderBy('id_interaction', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$journey = $this->dbMasterDefault->resultfy($builder->get());
        $data['journey'] = $journey;


        $data['nomeCompleto'] = $nomeCompleto;
        $data['celular'] = $celular;
        $data['linkAaspa'] = $linkAaspa;
        $data['tipoMensagem'] = $tipoMensagem;
        $data['returnData'] = $returnData;
        $data['twilio'] = $this->twilio;

        return $this->loadpage('aaspa/zapsms', $data);
    }


    //http://localhost/InsightSuite/public/aaspa-receptivo
    public function receptivo($cpf = null){
        $data['pageTitle'] = "AASPA - Receptivo";

        $btnSalvar = $this->getpost('btnSalvar');
        $btnConsultar = $this->getpost('btnConsultar');
        
        $cpf = numberOnly($cpf);
        if (empty($cpf)){
            $cpf = numberOnly($this->getpost('cpf'));
        }

        $nomeCliente = strtoupper($this->getpost('nomeCliente'));
        $estadoCivil = strtoupper($this->getpost('estadoCivil'));
        $sexo = strtoupper($this->getpost('sexo'));
        $nomeMae = strtoupper($this->getpost('nomeMae'));
        $email = strtoupper($this->getpost('email'));
        $telefone = strtoupper($this->getpost('telefone'));
        $telefoneWaId = celularToWaId($telefone);
        $logradouro = strtoupper($this->getpost('logradouro'));
        $bairro = strtoupper($this->getpost('bairro'));
        $cep = strtoupper($this->getpost('cep'));
        $cidade = strtoupper($this->getpost('cidade'));
        $uf = strtoupper($this->getpost('uf'));
        $complemento = strtoupper($this->getpost('complemento'));
        $endNumero = strtoupper($this->getpost('endNumero'));
        $dataNascimento = strtoupper($this->getpost('dataNascimento'));
        $matricula = strtoupper($this->getpost('matricula'));
        $instituidorMatricula = strtoupper($this->getpost('instituidorMatricula'));
        $orgao = strtoupper($this->getpost('orgao'));
        $codigoOrgao = strtoupper($this->getpost('codigoOrgao'));
        $docIdentidade = strtoupper($this->getpost('docIdentidade'));
        $docIdentidadeUf = strtoupper($this->getpost('docIdentidadeUf'));
        $docIdentidadeOrgEmissor = strtoupper($this->getpost('docIdentidadeOrgEmissor'));
        $bloqueio = strtoupper($this->getpost('bloqueio'));

        $returnData["status"] = false;
		$returnData["mensagem"] = "";
        $nomeCompletoUltima = "";
        $celularUltima = "";

        if (!empty($btnSalvar)){
            if ((strlen($nomeCliente) < 3)){
                $returnData["mensagem"] = "O nome deve ser preenchido.";
            } else {
                $dataProposta = [
                    "nomeCliente" => $nomeCliente,
                    "cpf" => $cpf,
                    "estadoCivil" => (int)$estadoCivil,
                    "sexo" => (int)$sexo,
                    "nomeMae" => $nomeMae,
                    "emailPessoal" => $email,
                    "telefonePessoal" => $telefone,
                    "logradouro" => $logradouro,
                    "bairro" => $bairro,
                    "cep" => $cep,
                    "cidade" => $cidade,
                    "uf" => $uf,
                    "complemento" => $complemento,
                    "endNumero" => $endNumero,
                    "dataNascimento" => str_replace(' ', 'T', dataPtUs($dataNascimento)),
                    "matricula" => $matricula,
                    "docIdentidade" => $docIdentidade,
                    "produtoId" => 6,
                    "revendedorId" => 144,
                    "vendedorUsuarioId" => 991, //dantas
                    //"vendedorUsuarioId" => 1030, //maria
                ];

                $dataPropostaInsight = [
                    "assessor" => $this->session->nickname,
                    "assessorId" => $this->session->user_id,
                    "aaspaCheck" => true,
                    "inssCheck" => (int)$sexo,
                    "tseCheck" => $nomeMae,
                ];
                    
                    

                //echo '10:27:27 - <h3>Dump 49 </h3> <br><br>' . var_dump($dataProposta); exit;					//<-------DEBUG
                
                $propostaAdded = $this->m_integraall->criar_proposta_insight($dataProposta + $dataPropostaInsight);
                
                $result = $this->m_integraall->criar_proposta_integraall($dataProposta);

                if ($result['sucesso']){
                    $detalhesGravacao = json_decode($result['retorno'], true);
                    if (isset($detalhesGravacao['title'])){
                        $type = $detalhesGravacao['type'];
                        $title = $detalhesGravacao['title'];
                        $status = $detalhesGravacao['status'];
                        $traceId = $detalhesGravacao['traceId'];

                        echo "RESULTADO: <br>Type: $type <br> Titulo: $title <br>Status: $status <br>Tracert: $traceId<br><br>";

                        // Verifica se há erros
                        if (isset($detalhesGravacao['errors']) && is_array($detalhesGravacao['errors'])) {
                            echo "Erros encontrados:<br><br>";

                            foreach ($detalhesGravacao['errors'] as $campo => $mensagens) {
                                echo "Campo: {$campo}<br>";
                                foreach ($mensagens as $mensagem) {
                                    echo "- {$mensagem}<br>";
                                }
                                echo "<br>";
                            }
                        } else {
                            echo "Nenhum erro encontrado.<br>";
                        }
                    }
                }

                echo '10:33:24 - <h3>Dump 45 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG

            }
        } else if (!empty($btnConsultar)){

        } else {
            //PEGA ULTIMA LIGACAO DO ASSESSOR
            $ultimaLigacao = $this->m_argus->ultimaLigacao(['cpf' => $cpf]);
            if ($ultimaLigacao['existRecord']){
                $nomeCompletoUltima = $ultimaLigacao['firstRow']->nome;
                $celularUltima = $ultimaLigacao['firstRow']->celular;
            }
        }


        //CHAT
        $chat = null;
        if ((!empty($celular))){
            $db =  $this->dbMasterDefault->getDB();
            $builder = $db->table('whatsapp_log');
            $builder->Like('whatsapp_log.To', $telefoneWaId); //bug do número 9 no whatsapp
            $builder->orLike('whatsapp_log.From', $telefoneWaId);
            $builder->orderBy('id', 'DESC');
            $builder->select('*');
            //echo $builder->getCompiledSelect();exit;
            $chat = $this->dbMasterDefault->resultfy($builder->get());
        }
        $data['chat'] = $chat;

        //JOURNEY
        $db =  $this->dbMasterDefault->getDB();
        $builder = $db->table('customer_journey');
        $builder->Where('verificador', $telefoneWaId);
        $builder->orderBy('id_interaction', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$journey = $this->dbMasterDefault->resultfy($builder->get());
        $data['journey'] = $journey;

        $data['cpf'] = $cpf;
        $data['nomeCliente'] = $nomeCliente;
        $data['estadoCivil'] = $estadoCivil;
        $data['sexo'] = $sexo;
        $data['nomeMae'] = $nomeMae;
        $data['email'] = $email;
        $data['telefone'] = $telefone;
        $data['logradouro'] = $logradouro;
        $data['bairro'] = $bairro;
        $data['cep'] = $cep;
        $data['cidade'] = $cidade;
        $data['uf'] = $uf;
        $data['complemento'] = $complemento;
        $data['endNumero'] = $endNumero;
        $data['dataNascimento'] = $dataNascimento;
        $data['matricula'] = $matricula;
        $data['instituidorMatricula'] = $instituidorMatricula;
        $data['orgao'] = $orgao;
        $data['codigoOrgao'] = $codigoOrgao;
        $data['docIdentidade'] = $docIdentidade;
        $data['docIdentidadeUf'] = $docIdentidadeUf;
        $data['docIdentidadeOrgEmissor'] = $docIdentidadeOrgEmissor;
        $data['bloqueio'] = $bloqueio;

        $data['nomeCompletoUltima'] = $nomeCompletoUltima;
        $data['celularUltima'] = $celularUltima;

        $data['returnData'] = $returnData;

        return $this->loadpage('aaspa/receptivo', $data);
    }

    
}
