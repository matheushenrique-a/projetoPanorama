<?php

namespace App\Controllers\Bmg;
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
use App\Models\M_seguranca;
use App\Models\M_insight;
use App\Models\M_bmg;

class Bmg extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $twilio;
    protected $m_integraall;
    protected $m_argus;
    protected $m_security;
    protected $m_insight;
    protected $m_bmg;

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
        $this->m_security = new M_seguranca();
        $this->m_insight = new M_insight();
        $this->m_bmg = new M_bmg();
    }

    //http://localhost/InsightSuite/public/bmg_receptivo
    public function bmg_receptivo($cpf = null){
        $data['pageTitle'] = "BMG - Receptivo Seguros";

		$this->m_bmg->obterCartoesDisponiveis($cpf);
		exit;

        $btnSalvar = $this->getpost('btnSalvar');
        $btnConsultar = $this->getpost('btnConsultar');
        $nomeCliente = strtoupper($this->getpost('nomeCliente'));
        $estadoCivil = strtoupper($this->getpost('estadoCivil'));
        $sexo = strtoupper($this->getpost('sexo'));
        $nomeMae = strtoupper($this->getpost('nomeMae'));
        $email = strtoupper($this->getpost('email'));
        $telefone = numberOnly(strtoupper($this->getpost('telefone')));
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
        $cpfINSS = strtoupper($this->getpost('cpfINSS'));

        $returnData["status"] = false;
		$returnData["mensagem"] = "";
        $nomeCompletoUltima = "";
        $celularUltima = "";
        $nomeStatus = "";
        $statusId = "";
        $statusAdicional = "";
        $statusAdicionalId = "";
        $linkKompletoCliente = "";
        $assessor = "";
        $assessorId = "";
        $aaspaCheck = "";
        $inssCheck = "";
        $tseCheck = "";
        $last_update = "";
        $cpfINSS = "";
        $cliente = null;
        
        $cpf = numberOnly($cpf);
        if ((empty($cpf)) or ($cpf == "0")) { $cpf = numberOnly($this->getpost('cpf'));}

        
        //CENÁRIO 01: SALVAR PROPOSTA
        if (!empty($btnSalvar)){
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
                "produtoId" => API_Produto,
                "revendedorId" => API_Revendedor,
                "vendedorUsuarioId" => $this->session->parameters["integraallId"], //dantas
            ];

            $dataPropostaInsight = [
                "assessor" => $this->session->nickname,
                "assessorId" => $this->session->user_id,
            ];

            $returnData = $this->m_integraall->criar_proposta_integraall($dataProposta);

            //Grava proposta no Insight se gravada com sucesso no Integrall
            if ($returnData['status']) {
                $propostaInsight = $dataProposta + $dataPropostaInsight + $returnData['integraall'];
                
                //Integraall está retornando o código do Kompleto e não do Integraall. Como alternativa busca todas as propostas do CPF e pega a última ate a API ser melhorada.
                $lastIntegraallId = $this->m_integraall->buscaUltimaProposta(['TermoDaBusca' => $cpf]);
                if ($lastIntegraallId != 0) {
                    $returnData['integraall']['integraallId'] = $lastIntegraallId;
                }

                $propostaAdded = $this->m_integraall->criar_proposta_insight($dataProposta + $dataPropostaInsight + $returnData['integraall']);
                
                $integraallId = $returnData['integraall']['integraallId'];
                $nomeStatus = $returnData['integraall']['nomeStatus'];
                $statusId = $returnData['integraall']['statusId'];

                return redirect()->to('aaspa-receptivo/0/' . $lastIntegraallId);exit;
            }
        
        //CENÁRIO 02: BUSCAR CPF
        } else if (!empty($cpf)){
            if ((strlen($cpf) != 11)){
                $returnData["mensagem"] = "O CPF deve ser preenchido.";
            } else {
                //VERIFICA HISTÓRICO DE PROPOSTAS NO INTEGRAALL PARA ESSE CPF. 
                //Para seguir, a ultima proposta deve estar cancelada ou não pode existir nenhuma
                $cliente = $this->m_integraall->ultima_proposta($cpf);

                //existe histórico de propostas
                if ($cliente['existRecord']){
                    $statusAdicional = strtoupper($cliente['firstRow']->statusAdicional);
                    $nomeStatus = strtoupper($cliente['firstRow']->nomeStatus);
                    $integraallIdHistorico = strtoupper($cliente['firstRow']->integraallId);
                    
                    //para seguir, a última proposta precisa pelo menos de um status cancelamento, ambos falsos = proposta ativa
                    if ((strpos($statusAdicional,'CANCELA') === false) and (strpos($nomeStatus,'CANCELA') === false)) {
                        $returnData["mensagem"] = "Existe uma proposta em aberto no Integraall [$integraallIdHistorico].<br>Para prosseguir cancele a proposta primeiro.";
                    }
                }
            }

        //CENÁRIO 03: EXIBIR PROPOSTA POR INTEGRAAL ID
        } else if (!empty($integraallId)) {
            $cliente = $this->m_integraall->proposta_integraall($integraallId, true);

            if ($cliente['existRecord']){
                $cpfINSS = $cliente['firstRow']->cpf;
                $nomeCliente = $cliente['firstRow']->nomeCliente;
                $estadoCivil = $cliente['firstRow']->estadoCivil;
                $sexo = $cliente['firstRow']->sexo;
                $nomeMae = $cliente['firstRow']->nomeMae;
                $email = $cliente['firstRow']->emailPessoal;
                $telefone = $cliente['firstRow']->telefonepessoal;
                $logradouro = $cliente['firstRow']->logradouro;
                $bairro = $cliente['firstRow']->bairro;
                $cep = $cliente['firstRow']->cep;
                $cidade = $cliente['firstRow']->cidade;
                $uf = $cliente['firstRow']->uf;
                $complemento = $cliente['firstRow']->complemento;
                $endNumero = $cliente['firstRow']->endNumero;
                $dataNascimento = dataUsPt($cliente['firstRow']->datanascimento);
                $last_update = $cliente['firstRow']->last_update;
                $matricula = $cliente['firstRow']->matricula;
                $docIdentidade = $cliente['firstRow']->docIdentidade;

                $statusId = $cliente['firstRow']->statusId;
                $nomeStatus = $cliente['firstRow']->nomeStatus;

                $statusAdicionalId = $cliente['firstRow']->statusAdicionalId;
                $statusAdicional = $cliente['firstRow']->statusAdicional;

                $integraallId = $cliente['firstRow']->integraallId;
                $linkKompletoCliente = $cliente['firstRow']->linkKompletoCliente;
                $assessor = $cliente['firstRow']->assessor;
                $assessorId = $cliente['firstRow']->assessorId;
                $aaspaCheck = $cliente['firstRow']->aaspaCheck;
                $inssCheck = $cliente['firstRow']->inssCheck;
                $tseCheck = $cliente['firstRow']->tseCheck;
            } else {
                $returnData["mensagem"] = "A proposta $integraallId não foi localizada no Insight";
            }
        }
        
        //CENÁRIO 05: FETCH - BOTÃO ASSPA OU INSS CHECK CHAMADOS VIA PAGELOAD OU CLICK BOTÃO
            //Realizar check no calculadora ou INSS sem gravar draft de proposta


        $telefone = "31995781355";
        $data['chat'] = $this->m_insight->getChat(celularToWaId($telefone));
        $data['journey'] = $this->m_insight->getJourney(celularToWaId($telefone));

        $data['cpf'] = $cpf;
        $data['cpfINSS'] = $cpfINSS;
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
        $data['session'] = $this->session;

        $data['integraallId'] = null;
        
        $data['statusId'] = $statusId;
        $data['nomeStatus'] = $nomeStatus;
        $data['statusAdicionalId'] = $statusAdicionalId;
        $data['statusAdicional'] = $statusAdicional;
        
        $data['linkKompletoCliente'] = $linkKompletoCliente;

        $data['assessor'] = $assessor;
        $data['assessorId'] = $assessorId;
        $data['aaspaCheck'] = $aaspaCheck;
        $data['inssCheck'] = $inssCheck;
        $data['tseCheck'] = $tseCheck;
        $data['last_update'] = $last_update;

        $data['nomeCompletoUltima'] = $nomeCompletoUltima;
        $data['celularUltima'] = $celularUltima;

        $data['returnData'] = $returnData;

        return $this->loadpage('bmg/receptivo', $data);
    }

    //http://localhost/InsightSuite/public/sign-in
    public function listarPropostas(){
        $buscarProp = $this->getpost('buscarProp');

        if (!empty($buscarProp)){
            helper('cookie');
            $cpf = $this->getpost('txtCPF', false);
            $integraallId = $this->getpost('integraallId', false);
            $celular = $this->getpost('celular', false);
            $nome = $this->getpost('txtNome', false);
            $emailPessoal = $this->getpost('emailPessoal', false);
            //echo '22:16:13 - <h3>Dump 87 </h3> <br><br>' . var_dump($emailPessoal); exit;					//<-------DEBUG
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', false);
            $paginas = $this->getpost('paginas', false);
            $operadorFiltro = $this->getpost('operadorFiltro', false);
            $flag = $this->getpost('flag',false);
               
            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('integraallId', $integraallId);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('emailPessoal', $emailPessoal);
            Services::response()->setCookie('statusPropostaFiltro', $statusPropostaFiltro);
            Services::response()->setCookie('paginas', $paginas);
            Services::response()->setCookie('operadorFiltro', $operadorFiltro);
            Services::response()->setCookie('flag', $flag);

            //$aux = Services::request()->getCookie($valor);	
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $integraallId = $this->getpost('integraallId', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $emailPessoal = $this->getpost('emailPessoal', true);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', true);
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
        if (!empty($integraallId)) $likeCheck['integraallId'] = $integraallId;
        if (!empty($celular)) $likeCheck['telefonepessoal'] = $celular;
        if (!empty($statusPropostaFiltro)) $whereCheck['statusProposta'] = $statusPropostaFiltro;
        $whereCheck['vendedorUsuarioId'] = $this->session->parameters["integraallId"];
        if (!empty($nome)) $likeCheck['nomeCliente'] = $nome;
        if (!empty($emailPessoal)) $likeCheck['emailPessoal'] = $emailPessoal;
        if ($flag == "OPTIN") $whereCheck['Optin_pan'] = "V";

        // if ((count($likeCheck) == 0) and (count($whereCheck) == 0)){
        //     if ($flag == "ADESAO"){
        //         $fasesAdd = getFasesCategory('funil');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     } else if ($flag == "ACAO"){
        //         $fasesAdd = getFasesCategory('acao');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     } else if ($flag == "ACOMPANHAR"){
        //         $fasesAdd = getFasesCategory('acompanhar');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     } else if ($flag == "OCULTAS"){
        //         $fasesAdd = getFasesCategory('fim');
        //         $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
        //     }
        // }
        
        //foreach($fasesAdd as $item){echo "'" . $item . "', ";}exit;

        $likeCheck = array("likeCheck" => $likeCheck);

        $paginas = (empty($paginas)  ? 10 : $paginas); 
        $this->dbMasterDefault->setLimit($paginas);
        $this->dbMasterDefault->setOrderBy(array('id_proposta', 'DESC'));
        $propostas = $this->dbMasterDefault->select('aaspa_propostas', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

        //INDICADORES
        $dados['indicadores'] = $this->indicadores();

        $dados['pageTitle'] = "AASPA - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['paginas'] = $paginas;
        $dados['integraallId'] = $integraallId;
        $dados['celular'] = $celular;
        $dados['emailPessoal'] = $emailPessoal;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        $dados['operadorFiltro'] = $operadorFiltro;
        $dados['session'] = $this->session;

        return $this->loadpage('aaspa/listar_propostas', $dados);
    }

    public function indicadores(){
        $indicadores = [];
        $indicadores['propostas_hoje'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE() AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_ontem'] = $this->dbMaster->runQuery("select count(*) total from aaspa_propostas where DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_7dias'] = $this->dbMaster->runQuery("SELECT COUNT(*) AS total FROM aaspa_propostas WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        $indicadores['propostas_30dias'] = $this->dbMaster->runQuery("SELECT COUNT(*) AS total FROM aaspa_propostas WHERE DATE(data_criacao) BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()  AND vendedorUsuarioId = " . $this->session->parameters["integraallId"] . ";")['firstRow']->total;
        //$indicadores['top_indicacao'] = $this->dbMaster->runQuery("select chave_origem, count(*) total from aaspa_propostas where DATE(data_criacao) = CURDATE() and chave_origem is not null group by chave_origem order by total desc")['firstRow'];

        return $indicadores;
    }
    
}
