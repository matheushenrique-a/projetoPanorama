<?php

namespace App\Controllers\Fgts;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use Config\Services;

class Fgts extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("fgtsDB"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
    }

    //retorna dados da proposta gravada
    public function proposta_buscar($id_proposta){
        return $this->dbMaster->select('proposta_fgts', array('id_proposta' => $id_proposta));
    }

    public function proposta_gravacao_buscar($id_proposta){
        return $this->dbMaster->select('proposta_fgts_gravacao_json', array('id_proposta' => $id_proposta));
    }

    public function adm_simulacao($action, $id_proposta, $id_json){
        if ($action == "D") {
            $whereCheck = array('id_json' => $id_json, 'id_proposta' => $id_proposta);
            $this->dbMaster->delete('proposta_fgts_simulacao_json', $whereCheck);
        } else if ($action == "A") {
    		//sincroniza parcela / valor do json com a proposta
	    	//usando quando o cliente escolhe a proposta no modo offline
            $whereCheck = array('id_json' => $id_json);
            $simulacao = $this->dbMaster->select('proposta_fgts_simulacao_json', $whereCheck);
            
            $id_proposta = $simulacao["firstRow"]->id_proposta;
            $parcelas = $simulacao["firstRow"]->parcelas;
            $valorSolicitado = $simulacao["firstRow"]->valor;

            //Atualiza a proposta e faz sincronismo
            $whereArrayUpdt = array('id_proposta' => $id_proposta);
            $fieldUpdate = array('parcelas' => $parcelas, 'valorSolicitado' =>$valorSolicitado, 'id_simulacao' =>$id_json);
            $fielDynamicdUpdate = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_fgts', $fieldUpdate, $whereArrayUpdt, $fielDynamicdUpdate);
        }

        return redirect()->to('fgts-cliente-detalhes/' . $id_proposta);
    }

    public function clienteDetalhes($id_proposta){
        $data['pageTitle'] = "FGTS - Detalhes Cliente";

        //OCORRENCIAS
        $ocorrencias = $this->getpost('ocorrencias');
        $txtMensagemDireta = $this->getpost('txtMensagemDireta');
        $btnSalvar = $this->getpost('btnSalvar');

        //PROPOSTA GRAVADA
        $txtNumeroProposta = $this->getpost('txtNumeroProposta');
        $txtBanco = $this->getpost('txtBanco');
        $txtValorPago = $this->getpost('txtValorPago');
        $txtURLCliente = $this->getpost('txtURLCliente');
        $txtErroIntegracao = $this->getpost('txtErroIntegracao');
        $btnSalvarProposta = $this->getpost('btnSalvarProposta');
        $btnMensagemDireta = $this->getpost('btnMensagemDireta');
        $btnCidadesListar = $this->getpost('btnCidadesListar');
        $btnGravarFacta = $this->getpost('btnGravarFacta');
        
        //DADOS PESSOAIS
        $txtnomeCompleto = $this->getpost('txtnomeCompleto');
        $txtnomeMae = $this->getpost('txtnomeMae');
        $txtDataNascimento = $this->getpost('txtDataNascimento');
        $txtnomePai = $this->getpost('txtnomePai');
        $txtnumBanco = $this->getpost('txtnumBanco');
        $rdTipoConta = $this->getpost('rdTipoConta');
        $txtagencia = $this->getpost('txtagencia');
        $txtnumDigitoAgencia = $this->getpost('txtnumDigitoAgencia');
        $txtnumConta = $this->getpost('txtnumConta');
        $txtnumDigito = $this->getpost('txtnumDigito');
        $txtnumeroCep = $this->getpost('txtnumeroCep');
        $txtnomeCompleto = $this->getpost('txtnomeCompleto');
        $celular_alertas = (empty($this->getpost('celular_alertas')) ? 'N' : 'Y');
        $celular_failed = (empty($this->getpost('celular_failed')) ? 'N' : 'Y');

        if (!empty($btnSalvar)){
            $where = array('id_proposta' => $id_proposta);
            
            $fields = array('ocorrencias' => $ocorrencias
                            , 'mae' => $txtnomeMae
                            , 'pai' => $txtnomePai
                            , 'data_nascimento' => dataPtUs($txtDataNascimento)
                            , 'banco_numero' => $txtnumBanco
                            , 'forma_credito' => $rdTipoConta
                            , 'agencia_numero' => $txtagencia
                            , 'agencia_digito' => $txtnumDigitoAgencia
                            , 'conta_numero' => $txtnumConta
                            , 'conta_digito' => $txtnumDigito
                            , 'cep' => $txtnumeroCep
                            , 'nome' => $txtnomeCompleto
                            , 'celular_alertas' => $celular_alertas
                            , 'celular_failed' => $celular_failed
                            );

            //echo '13:46:16 - <h3>Dump 54 </h3> <br><br>' . var_dump($fields); exit;					//<-------DEBUG

            $fieldsDynamic = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_fgts', $fields, $where, $fieldsDynamic);
        } else if (!empty($btnMensagemDireta)){
            $where = array('id_proposta' => $id_proposta);
            $fields = array('mensagem_direta' => $txtMensagemDireta);
            $fieldsDynamic = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_fgts', $fields, $where, $fieldsDynamic);
        } else if (!empty($btnSalvarProposta)){
            $where = array('id_proposta' => $id_proposta);
            $this->dbMaster->delete('proposta_fgts_gravacao_json', $where);
            $valorClean = str_replace(".", "", $txtValorPago);
            $valorClean = str_replace(",", ".", $valorClean);

            $json = '[{"numero_proposta": "' . $txtNumeroProposta . '","id_rastreamento_externo": null}]';
            $fields = array('id_proposta' => $id_proposta, 'json' => $json, 'banco' => $txtBanco, 'numeroPropostaGerada' => $txtNumeroProposta, 'valor_pago' => $valorClean, 'linkCliente' => $txtURLCliente, 'MotivoIntegracao' => $txtErroIntegracao);
            $this->dbMaster->insert('proposta_fgts_gravacao_json', $fields);
        }


        $whereCheck = array('id_proposta' => $id_proposta);
        $jsonGravacao = $this->dbMaster->select('proposta_fgts_gravacao_json', $whereCheck);
        $simulacoes = $this->dbMaster->select('proposta_fgts_simulacao_json', $whereCheck);

        if ($jsonGravacao['existRecord']){
            $txtNumeroProposta = $jsonGravacao['firstRow']->numeroPropostaGerada;
            $txtValorPago = SimpleRound($jsonGravacao['firstRow']->valor_pago);
            $txtURLCliente = $jsonGravacao['firstRow']->linkCliente;
            $txtBanco = $jsonGravacao['firstRow']->banco;
            $txtErroIntegracao = $jsonGravacao['firstRow']->MotivoIntegracao;
        }

        $cliente = $this->proposta_buscar($id_proposta);
        $ddd = $cliente['firstRow']->ddd;
		$celular = $cliente['firstRow']->celular;
        $to = limparMascaraTelefone("55".$ddd . substr($celular, 1));
       
        if ($cliente['existRecord']){
			$data['id_proposta'] = $id_proposta;	
			$data['verificador'] = $cliente['firstRow']->verificador;
			$data['cpf']  = $cliente['firstRow']->cpf;
			$data['dtaNascimento'] = dataUsPt($cliente['firstRow']->data_nascimento, true);
			$data['email'] = $cliente['firstRow']->email;
			$data['ocorrencias'] = $cliente['firstRow']->ocorrencias;
			$data['txtMensagemDireta'] = $cliente['firstRow']->mensagem_direta;

			$data['rdSexo'] = $cliente['firstRow']->sexo;
			$data['nomeCompleto'] = $cliente['firstRow']->nome;
			$data['nomeMae'] = $cliente['firstRow']->mae;
			$data['documento_identificacao'] = $cliente['firstRow']->documento_identificacao;
			$data['numero_documento'] = $cliente['firstRow']->numero_documento;
			$data['uf_documento'] = $cliente['firstRow']->uf_documento;
			$data['orgaoEmissor'] = $cliente['firstRow']->orgao_emissor;
			$data['uf_nascimento'] = $cliente['firstRow']->uf_nascimento;
			$data['cidade_nascimento'] = $cliente['firstRow']->cidade_nascimento;

			$data['numeroCep'] = $cliente['firstRow']->cep;
			$data['enderecoResidencia'] = $cliente['firstRow']->logradouro;
			$data['numeroEndereco'] = $cliente['firstRow']->numero;
			$data['complemento'] = $cliente['firstRow']->completo;
			$data['bairroResidencia'] = $cliente['firstRow']->bairro;
			$data['estadoResidencia'] = $cliente['firstRow']->uf_residencia;
			$data['nomeCidadeResidencia'] = $cliente['firstRow']->cidade;

			$data['rdTipoConta'] = $cliente['firstRow']->forma_credito;
			$data['numBanco'] = $cliente['firstRow']->banco_numero;
			$data['agencia'] = $cliente['firstRow']->agencia_numero;
			$data['numDigitoAgencia'] = $cliente['firstRow']->agencia_digito;
			$data['numConta'] = $cliente['firstRow']->conta_numero;
			$data['numDigito'] = $cliente['firstRow']->conta_digito;

			$data['ddd'] = $cliente['firstRow']->ddd;
			$data['celular'] = $cliente['firstRow']->celular;
			$data['celular_alertas'] = $cliente['firstRow']->celular_alertas;
			$data['celular_failed'] = $cliente['firstRow']->celular_failed;
			$data['nomePai'] = $cliente['firstRow']->pai;
			$data['dataEmissao'] = $cliente['firstRow']->data_emissao;
			$data['estadoCivil'] = $cliente['firstRow']->estado_civil;
			$data['nomeConjuge'] = $cliente['firstRow']->conjuge;
			$data['orgaoEmissor'] = $cliente['firstRow']->orgao_emissor;
			$data['estadoEmissor'] = $cliente['firstRow']->uf_documento;
			$data['parcelas'] = $cliente['firstRow']->parcelas;
			$data['valorSolicitado'] = $cliente['firstRow']->valorSolicitado;
			$data['seguroFGTS'] = $cliente['firstRow']->seguroFGTS;
			$data['data_criacao'] = $cliente['firstRow']->data_criacao;
			$data['statusPropostaBanco'] = $cliente['firstRow']->statusPropostaBanco;
			
            $data['txtNumeroProposta'] = $txtNumeroProposta;
            $data['txtBanco'] = $txtBanco;
            $data['txtValorPago'] = $txtValorPago;
            $data['txtURLCliente'] = $txtURLCliente;
            $data['txtErroIntegracao'] = $txtErroIntegracao;
            foreach ($simulacoes['result']->getResult() as $row) {
                if ($row->banco == "PAN"){
                    $row->json = $this->pan_json_simulacao_translator_advanced($row->json);
                } else if ($row->banco == "FACTA"){
                    $row->json = $this->facta_json_simulacao_translator_advanced($row->json);
                }
            }
    
            $data['simulacoes'] = $simulacoes;
            $data['id_simulacao'] = $cliente['firstRow']->id_simulacao;

			$statusProposta = $cliente['firstRow']->statusProposta;
			$data['statusProposta'] = $statusProposta;
			$offlineMode = $cliente['firstRow']->offlineMode;
			$data['offlineMode'] = $offlineMode;
			$data['header'] = $cliente['firstRow']->header;
			$data['data_emissao'] = $cliente['firstRow']->data_emissao;
			$data['data_criacao'] = $cliente['firstRow']->data_criacao;

            if (!empty($btnCidadesListar)){
                $this->dbMaster->setOrderBy(array("nome", "ASC"));
                $this->dbMaster->setLimit(2000);
                $whereCheck = array('estado' =>  $cliente['firstRow']->uf_residencia);
                $listaCidadesResidencia = $this->dbMaster->select('estado_cidade', $whereCheck);
                $data['listaCidadesResidencia'] = $listaCidadesResidencia;
                
                if ($cliente['firstRow']->uf_residencia != $cliente['firstRow']->uf_nascimento){
                    $whereCheck = array('estado' =>  $cliente['firstRow']->uf_nascimento);
                    $listaCidadesNascimento = $this->dbMaster->select('estado_cidade', $whereCheck);
                    $data['listaCidadesNascimento'] = $listaCidadesNascimento;
                } else {
                    $data['listaCidadesNascimento'] = $data['listaCidadesResidencia'];
                }
                $this->dbMaster->setLimit(500);
            }
        }

        $db =  $this->dbMaster->getDB();
        $builder = $db->table('whatsapp_log');
        $builder->Like('whatsapp_log.To', substr($to,-8)); //bug do número 9 no whatsapp
        $builder->orLike('whatsapp_log.From', substr($to,-8));
        $builder->orderBy('id', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$chat = $this->dbMaster->resultfy($builder->get());
        $data['chat'] = $chat;


        $db =  $this->dbMaster->getDB();
        $builder = $db->table('customer_journey');
        $builder->Where('verificador', $cliente['firstRow']->verificador);
        $builder->orWhere('id_proposta', $cliente['firstRow']->id_proposta);
        $builder->orWhere('email', $cliente['firstRow']->email);
        $builder->orWhere('cpf', $cliente['firstRow']->cpf);
        $builder->orderBy('id_interaction', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$journey = $this->dbMaster->resultfy($builder->get());
        $data['journey'] = $journey;


        return $this->loadpage('fgts/cliente_detalhes', $data);
    }


    public function indicadores(){
        $indicadores = [];
        $indicadores['clicks_campanha'] = $this->dbMaster->runQuery("select count(*) total from campanha_click_count where DATE(last_updated) = CURDATE();")['firstRow']->total;
        $indicadores['clicks_campanha_inbound'] = $this->dbMaster->runQuery("select slug, count(*) total from campanha_click_count where DATE(last_updated) = CURDATE() group by slug order by total desc;")['firstRow'];
        $indicadores['clicks_campanha_ontem'] = $this->dbMaster->runQuery("select count(*) total from campanha_click_count where DATE(last_updated) = DATE_SUB(CURDATE(), INTERVAL 1 DAY);")['firstRow']->total;
        $indicadores['propostas_cadastradas'] = $this->dbMaster->runQuery("select count(*) total from proposta_fgts where DATE(data_criacao) = CURDATE();")['firstRow']->total;
        $indicadores['propostas_cadastradas_ontem'] = $this->dbMaster->runQuery("select count(*) total from proposta_fgts where DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY);")['firstRow']->total;
        $indicadores['top_indicacao'] = $this->dbMaster->runQuery("select chave_origem, count(*) total from proposta_fgts where DATE(data_criacao) = CURDATE() and chave_origem is not null group by chave_origem order by total desc")['firstRow'];

        return $indicadores;
    }

    public function listarEventos(){
        $whereCheck['fonte'] = 'telegram';
        $this->dbMaster->setOrderBy(array('last_update', 'DESC'));
        $this->dbMaster->setLimit(100);
        $eventos = $this->dbMaster->select('log_eventos', $whereCheck);
        return $eventos;
    }


    public function listarPropostas(){
        $fases = $this->fasesProposta();
        $users = $this->listaOPeradores();
        $buscarProp = $this->getpost('buscarProp');

        $eventos = $this->listarEventos();

        if (!empty($buscarProp)){
            helper('cookie');
            $cpf = $this->getpost('txtCPF', false);
            $verificador = $this->getpost('verificador', false);
            $celular = $this->getpost('celular', false);
            $nome = $this->getpost('txtNome', false);
            $email = $this->getpost('email', false);
            //echo '22:16:13 - <h3>Dump 87 </h3> <br><br>' . var_dump($email); exit;					//<-------DEBUG
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', false);
            $paginas = $this->getpost('paginas', false);
            $operadorFiltro = $this->getpost('operadorFiltro', false);
            $flag = $this->getpost('flag',false);
               
            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('verificador', $verificador);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('email', $email);
            Services::response()->setCookie('statusPropostaFiltro', $statusPropostaFiltro);
            Services::response()->setCookie('paginas', $paginas);
            Services::response()->setCookie('operadorFiltro', $operadorFiltro);
            Services::response()->setCookie('flag', $flag);

            //$aux = Services::request()->getCookie($valor);	
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $verificador = $this->getpost('verificador', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $email = $this->getpost('email', true);
            //echo '22:16:13 - <h3>Dump 22 </h3> <br><br>' . var_dump($email); exit;					//<-------DEBUG
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
        if (!empty($verificador)) $likeCheck['verificador'] = $verificador;
        if (!empty($celular)) $likeCheck['celular'] = $celular;
        if (!empty($statusPropostaFiltro)) $whereCheck['statusProposta'] = $statusPropostaFiltro;
        if (!empty($nome)) $likeCheck['nome'] = $nome;
        if (!empty($email)) $likeCheck['email'] = $email;

        if ((count($likeCheck) == 0) and (count($whereCheck) == 0)){
            if ($flag == "ADESAO"){
                $fasesAdd = getFasesCategory('funil');
                $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
            } else if ($flag == "ACAO"){
                $fasesAdd = getFasesCategory('acao');
                $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
            } else if ($flag == "ACOMPANHAR"){
                $fasesAdd = getFasesCategory('acompanhar');
                $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
            } else if ($flag == "OCULTAS"){
                $fasesAdd = getFasesCategory('fim');
                $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
                // $fasesRemove = [lookupFases('CAN')['faseName'], lookupFases('FIM')['faseName']];
                // $whereNotIn = array("whereNotIn" => array('statusProposta', $fasesRemove));        
            }
        }
        
        //foreach($fasesAdd as $item){echo "'" . $item . "', ";}exit;

        $likeCheck = array("likeCheck" => $likeCheck);

        $paginas = (empty($paginas)  ? 10 : $paginas); 
        $this->dbMaster->setLimit($paginas);
        $this->dbMaster->setOrderBy(array('id_proposta', 'DESC'));
        $propostas = $this->dbMaster->select('proposta_fgts', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

        foreach ($propostas['result']->getResult() as $row) {
            $simulacao_detalhes = null;

            if (exibir_valores_proposta){
                $simulacao_detalhes = $this->json_proposta_any($row->id_proposta);
            }
            $row->id_simulacao =  $simulacao_detalhes;
            // if (!is_null($row->id_simulacao)){
            //     echo $row->id_simulacao['banco'] . " - " . simpleRound($row->id_simulacao['valor_liquido']);exit;
            // }
        }
        //INDICADORES
        $dados['indicadores'] = $this->indicadores();

        $dados['pageTitle'] = "FGTS - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['paginas'] = $paginas;
        $dados['verificador'] = $verificador;
        $dados['celular'] = $celular;
        $dados['email'] = $email;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        $dados['operadorFiltro'] = $operadorFiltro;
        $dados['fases'] = $fases;
        $dados['users'] = $users;
        $dados['flag'] = $flag;
        
        $dados['eventos'] = $eventos;

        return $this->loadpage('fgts/listar_propostas', $dados);
    }

    public function atualizarStatusPropostaOperador($id_proposta){
        $where = array('id_proposta' => $id_proposta);
        $fields = array('OperadorCCenter' => $this->session->nickname);
        $fieldsDynamic = array('last_update' => 'current_timestamp()');
        $this->dbMaster->update('proposta_fgts', $fields, $where, $fieldsDynamic);

        return redirect()->to('fgts-listar-propostas');
    }

    public function atualizarStatusProposta($id_proposta, $idFase){
        $status = lookupFases($idFase)['faseName'];
        $where = array('id_proposta' => $id_proposta);
        $fields = array('statusProposta' => $status);
        $fieldsDynamic = array('last_update' => 'current_timestamp()');
        $this->dbMaster->update('proposta_fgts', $fields, $where, $fieldsDynamic);

        $cliente = $this->proposta_buscar($id_proposta);
        $verificador = strtoupper($cliente['firstRow']->verificador);
        $email = $cliente['firstRow']->email;

        $faseSimples = propostaFaseFormatSimples($status);

        if ($status == "PASSO 09 - PROPOSTA FINALIZADA"){
            $jsonGravacao = $this->proposta_gravacao_buscar($id_proposta);
            if ($jsonGravacao['existRecord']){
                $txtValorPago = SimpleRound($jsonGravacao['firstRow']->valor_pago);
                if ($jsonGravacao['firstRow']->valor_pago > 0) {
                    $output = $this->telegram->notifyTelegramGroup("⭐️⭐️⭐️ FASE - $verificador - <b>PROPOSTA PAGA [$txtValorPago]</b>");
                } else {
                    $output = $this->telegram->notifyTelegramGroup("⭐️⭐️⭐️ FASE - $verificador - <b>PROPOSTA PAGA</b>");
                }
            }
        } else {
            $output = $this->telegram->notifyTelegramGroup("👾👾👾 FASE $verificador - " . $faseSimples);
        }

        $result = $this->dbMaster->insert('customer_journey', array("verificador" => $verificador, "descricao" => "FASE: $faseSimples", "slug" => 'PRP', "direction" => "SAIDA", "channel" => "INSIGHT", "type" => "PROPOSTA"));

        return redirect()->to('fgts-listar-propostas');
    }

    public function fasesProposta(){
        $db =  $this->dbMaster->getDB();
        $builder = $db->table('proposta_fgts');
        $builder->orderBy('statusProposta', 'ASC');
        $builder->distinct();
        $builder->select('statusProposta');
		//echo $builder->getCompiledSelect();exit;
		return $builder->get();
    }

    public function listaOPeradores(){
        $users = $this->dbMasterDefault->select('user_account', null);
		return $users;
    }    


    //json de qualquer simulação existente
    public function json_proposta_any($id_proposta){
        $proposta = $this->proposta_buscar($id_proposta);

        //recupera json da proposta aceita
        $whereCheck = array('id_proposta' => $id_proposta);
        $response = $this->dbMaster->select('proposta_fgts_simulacao_json', $whereCheck);
        if (!$response['existRecord']){
            return null;
        }

        //TODO: caso json nao exista??
        $json = $response["firstRow"]->json;
        $prefixo = $response["firstRow"]->banco;

        if ($prefixo == "PAN"){
            return $this->pan_json_simulacao_translator_advanced($json);
        } else if ($prefixo == "FACTA"){
            return $this->facta_json_simulacao_translator_advanced($json);						
        }
    }

    ////NAO EDITAR
    public function facta_json_simulacao_translator_advanced($simulacao_record){
        $result = json_decode($simulacao_record,true);

        //{"permitido":"SIM","simulacao_fgts":"4757999","valor_liquido":"1.183,50","iof":47.12,"taxa":"2.04","parcelas_selecionadas":12,"tabela":"39640 - FGTS GOLD RB","data_solicitacao":"11\/03\/2023 00:10:40"}
        $returnData = array();
        $returnData["existProposta"] = false;
        $returnData["rawjson"] = $simulacao_record;
        $returnData["motivo"] = "";
        $returnData["banco"] = "FACTA";


        //SEM RETORNO DA API(NULL) OU ENTAO MENSAGEM DE ERRO
        if (is_null($result) or (isset($result['codigo']))) {
            $returnData["existProposta"] = false;
            $returnData["motivo"] = "[ERROAPI]";
            $returnData["detalhes"] = $result['msg'];
        } else if (isset($result['permitido'])){
            //UNICA PROPOSTA É SEM SALDO
            if (strtolower($result['permitido']) == 'sim'){

                $valor = str_replace(".", "", $result['valor_liquido']);
                $valor = str_replace(",", ".", $result['valor_liquido']);

                $returnData["existProposta"] = true;
                $returnData["motivo"] = "[PROPOSTA]";
                $returnData["simulacao_fgts"] = $result['simulacao_fgts'];
                $returnData["valor_liquido"] = $valor;
                $returnData["valor_iof"] = $result['iof'];
                $returnData["juros_mensal"] = $result['taxa'];
                $returnData["parcelas_selecionadas"] = $result['parcelas_selecionadas'];
                $returnData["tabela"] = $result['tabela'];
                $returnData["seguro"] = 'Não contratado';
                $returnData["seguroValor"] = "N/A";
            } else {
                $returnData["existProposta"] = false;
                $returnData["motivo"] = "[NAOPERMITIDO]";
            }
        }
        //echo '23:21:56 - <h3>Dump 41 </h3> <br><br>' . var_dump($returnData); exit;					//<-------DEBUG
        return $returnData;
    }	

    public function pan_json_simulacao_translator_advanced($simulacao_record){
        $result = json_decode($simulacao_record,true);

        $returnData = array();
        $returnData["existProposta"] = false;
        $returnData["rawjson"] = $simulacao_record;
        $returnData["motivo"] = "";
        $returnData["taxaCadastro"] = 'Não cobrada';
        $returnData["taxaCadastroValor"] = 0;
        $returnData["seguro"] = 'Não contratado';
        $returnData["seguroValor"] = 0;
        $returnData["juros_mensal_inicial"] = "2.49";
        $returnData["valor_liquido_extra"] = 0;
        $returnData["banco"] = "PAN";

        //SEM RETORNO DA API(NULL) OU ENTAO MENSAGEM DE ERRO
        if (is_null($result) or (isset($result['codigo']))) {
            $returnData["existProposta"] = false;
            $returnData["motivo"] = "[ERROAPI]";
            $returnData["detalhes"] = $this->translateMessage(isset($result['detalhes'][0]) ? $result['detalhes'][0] : "gateway timeout");
        } else if (isset($result['condicoes_credito'])){
            //UNICA PROPOSTA É SEM SALDO
            if ($result['condicoes_credito'][0]['sucesso'] == false){
                $returnData["existProposta"] = false;
                $returnData["motivo"] = "[SALDO]";
                $returnData["detalhes"] = $this->translateMessage($result['condicoes_credito'][0]['mensagem_erro']);
            //PROPOSTA NORMAL
            } else if ($result['condicoes_credito'][0]['sucesso'] == true){
                $returnData["existProposta"] = true;
                $returnData["motivo"] = "[PROPOSTA]";
                //$returnData["juros_mensal_inicial"] = $result['condicoes_credito'][0]['taxa_referencia_mensal'];
                $returnData["valor_liquido_extra"] = $result['condicoes_credito'][0]['valor_liquido'];

                //BUSCA MELHOR PROPOSTA/TAXA DE JUROS
                $numPropostas = count($result['condicoes_credito']);
                $melhorProposta = 0;
                for ($propId = 0; $propId <= $numPropostas-1; $propId++){
                    if ($result['condicoes_credito'][$propId]['sucesso']){
                        $melhorProposta = $propId;
                    }
                }
                //echo "<br>A melhor proposta é:<br>" . $melhorProposta . "-" . $result['condicoes_credito'][$melhorProposta]['valor_liquido'] .  "<br>"; exit;
                
                //EXTRAI VALOR SEGURO E TAXA DE CADASTRO SE EXISTIREM
                for ($desp = 0; $desp <= count($result['condicoes_credito'][$melhorProposta]['despesas'])-1; $desp++){
                    if (($result['condicoes_credito'][$melhorProposta]['despesas'][$desp]['grupo'] == "CADASTRO") and ($result['condicoes_credito'][$melhorProposta]['despesas'][$desp]['inclusa'] == true) and ($returnData["taxaCadastro"] == 'Não cobrada')){
                        $returnData["taxaCadastro"] = 'Inclusa';
                        $returnData["taxaCadastroValor"] = simpleRound($result['condicoes_credito'][$melhorProposta]['despesas'][$desp]['valor_calculado']);
                    } else if (($result['condicoes_credito'][$melhorProposta]['despesas'][$desp]['grupo'] == "SEGURO") and ($result['condicoes_credito'][$melhorProposta]['despesas'][$desp]['inclusa'] == true)  and ($returnData["seguro"] == 'Não contratado')){
                        $returnData["seguro"] = 'Contratado';
                        $returnData["seguroValor"] = simpleRound($result['condicoes_credito'][$melhorProposta]['despesas'][$desp]['valor_calculado']);
                    }
                }

                //GRAVA DEMAIS DADOS DA PROPOSTA
                $returnData["json"] = $result['condicoes_credito'][$melhorProposta];
                $returnData["mensagem"] = $result['condicoes_credito'][$melhorProposta]['mensagem_erro'];
                $returnData["valor_liquido"] = $result['condicoes_credito'][$melhorProposta]['valor_liquido'];
                $returnData["valor_bruto"] = $result['condicoes_credito'][$melhorProposta]['valor_bruto'];
                $returnData["valor_iof"] = $result['condicoes_credito'][$melhorProposta]['valor_iof'];
                $returnData["juros_mensal"] = $result['condicoes_credito'][$melhorProposta]['taxa_referencia_mensal'];
                $returnData["numero_parcelas"] = count($result['condicoes_credito'][$melhorProposta]['parcelas']);
                $returnData["parcelas"] = $result['condicoes_credito'][$melhorProposta]['parcelas'];
                $returnData["valor_liquido_extra"] = $returnData["valor_liquido"] - $returnData["valor_liquido_extra"];

            }
        }

        return $returnData;
    }

    		//Converte explicação retornada pela API do banco em algo mais claro.
		function translateMessage($message) {
			//$message = str_replace("xxx", "", $message);
			$title = "";
			$message_id = "";
			$rawMessageAPI = $message;
			$acaoCliente = false;

			if (findText($message, ["não possui adesão"])) {
				$message = "Para prosseguir com a antecipação do Saque Aniversário você deve aderir a essa modalidade através do App FGTS. <br /><br />Você pode fazer isso pela internet seguindo o passo-a-passo do vídeo abaixo.";
				$title = "Adesão Saque-Aniversário";
				$message_id = "[ADESAO]";
				$acaoCliente = true;
			} else if (findText($message, ["Instituição Fiduciária não possui"])) {
				$message = "Você precisa autorizar o BANCO PAN S.A. a consultar seu saldo FGTS através do App FGTS. Assim poderemos apresentar uma proposta personalizada através do nosso parceiro financeiro. <br/> <br/> Veja como é fácil seguindo os passsos do vídeo abaixo.";
				$title = "Permissão de consulta FGTS";
				$message_id = "[LIBERACAO]";
				$acaoCliente = true;
			} else if (findText($message, ["Operação não permitida antes"])) {
				$message = "Período de aniversário próximo, aguarde prazo de carência da Caixa Econômica. <br /> <br />Motivo: <br />" .  $message;
				$title = "Proximidade de aniversário";
				$message_id = "[ANIVERSARIO]";
				$acaoCliente = true;
			} else if (findText($message, ["Erro ao realizar a consulta. HTTPStatus: 404", "Erro ao realizar a consulta. HTTPStatus: 524", "Entre em contato com o setor de FGTS", "informar o saldo", "não pode ser menor", "Fiduciária em andamento", "não possui contas", "parcela inválido", "NÃO possui saldo disponível", "cpf_cliente não pode ser nulo", "cpf_cliente não é válido", "maior que o limite", "Valor da Operação não pode ser menor"])) {
				$message = "Você não possui saldo liberado para antecipação do FGTS no momento.";
				$title = "Saldo indisponível";
				$message_id = "[SALDO]";	
				$acaoCliente = true;
			} else if (findText($message, ["One or more errors occurred", "simulacaoFGTS timed-out", "Não foi possível realizar", "exige cadastramento", "Erro ao realizar", "gateway timeout", "estamos com indisponibilidade", "Ocorreu um erro na chamada", "Tempo máximo excedido", "Tempo maximo", "Force OfflineMode On"])) {
				$message = "No momento o serviço de consulta da instituição bancária está fora do ar. Tente novamente após alguns minutos.";
				$title = "Falha de conexão";
				$message_id = "[ERROAPI]";	
				$acaoCliente = false;
			} else if (findText($message, ["Falha na geração do token", "exige cadastramento"])) {
				$message = "No momento o serviço de consulta da instituição bancária está fora do ar. Tente novamente após alguns minutos.";
				$title = "Falha de conexão";
				$message_id = "[ABRIR-CHAMADO]";	
				$acaoCliente = false;
			} else {
				$message = "Não foi possível consultar seu saldo FGTS.  <br /> <br />Motivo: <br />" .  $message;
				$title = "Ocorreu um erro";
				$message_id = "[FALHA-INESPERADA]";
				$acaoCliente = true;
				$this->m_telegram->notifyTelegramGroup("FATAL ERROR: [FALHA-INESPERADA]: " . $message);
			}

			return array('descricao' => $message, 'titulo' => $title, 'codigo' => $message_id, 'acaoCliente' => $acaoCliente, 'rawMessageAPI' => $rawMessageAPI); 
		}
}
