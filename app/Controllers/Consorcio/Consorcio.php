<?php

namespace App\Controllers\Consorcio;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use Config\Services;
use CodeIgniter\Files\File;

class Consorcio extends BaseController
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

    // public function index(){
    //     $fileUploadModel = new FileUploadModel();
    //     return view('file-upload', ['fileUploads' => $fileUploadModel->orderBy('created_at', 'asc')->findAll()]);
    // }
 
    //retorna dados da proposta gravada
    public function proposta_buscar($whereCheck){
        return $this->dbMaster->select('proposta_consorcio', $whereCheck);
    }

    public function clienteDetalhes($id_proposta){
        $data['pageTitle'] = "FGTS - Detalhes Cliente";

        //OCORRENCIAS
        $ocorrencias = $this->getpost('ocorrencias');
        $txtMensagemDireta = $this->getpost('txtMensagemDireta');
        $btnSalvar = $this->getpost('btnSalvar');
        $btnSalvarProposta = $this->getpost('btnSalvarProposta');
        $btnSalvarArquivos = $this->getpost('btnSalvarArquivos');
        
        //PROPOSTA CONSORCIO ADD
        $txtGrupo = $this->getpost('txtGrupo');
        $txtValorCarta = $this->getpost('txtValorCarta');
        $txtTaxaAdm = $this->getpost('txtTaxaAdm');
        $txtParcelas = $this->getpost('txtParcelas');
        $txtPrazoOrinal = $this->getpost('txtPrazoOrinal');
        $txtVagas = $this->getpost('txtVagas');
        $txtParticipantes = $this->getpost('txtParticipantes');
        $txtValorParcela = $this->getpost('txtValorParcela');
        $txtVencimento = $this->getpost('txtVencimento');
        $txtProxAssembleia = $this->getpost('txtProxAssembleia');
        $txtLanceMedio = $this->getpost('txtLanceMedio');
        
        //DADOS PESSOAIS
        $txtnomeCompleto = $this->getpost('txtnomeCompleto');
        $txtnomeMae = $this->getpost('txtnomeMae');
        $txtDataNascimento = $this->getpost('txtDataNascimento');
        $txtnomePai = $this->getpost('txtnomePai');
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
                            , 'cep' => $txtnumeroCep
                            , 'nome' => $txtnomeCompleto
                            , 'celular_alertas' => $celular_alertas
                            , 'celular_failed' => $celular_failed
                            );

            //echo '13:46:16 - <h3>Dump 54 </h3> <br><br>' . var_dump($fields); exit;					//<-------DEBUG

            $fieldsDynamic = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_consorcio', $fields, $where, $fieldsDynamic);
        } else if (!empty($btnMensagemDireta)){
            $where = array('id_proposta' => $id_proposta);
            $fields = array('mensagem_direta' => $txtMensagemDireta);
            $fieldsDynamic = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_consorcio', $fields, $where, $fieldsDynamic);
        } else if (!empty($btnSalvarArquivos)){
            echo $this->fileupdate($id_proposta);
        } else if (!empty($btnSalvarProposta)){
            //Normaliza decimais PT/US
            $txtValorCarta = str_replace(".", "", $txtValorCarta);
            $txtValorCarta = str_replace(",", ".", $txtValorCarta);
            $txtValorParcela = str_replace(".", "", $txtValorParcela);
            $txtValorParcela = str_replace(",", ".", $txtValorParcela);

            $fieldsInsert = array('grupo' => $txtGrupo
                                , 'carta_valor' => $txtValorCarta
                                , 'taxa_adm' => $txtTaxaAdm
                                , 'parcelas' => $txtParcelas
                                , 'prazo_original' => $txtPrazoOrinal
                                , 'vagas' => $txtVagas
                                , 'participantes' => $txtParticipantes
                                , 'valor_parcela' => $txtValorParcela
                                , 'vencimento' => dataPtUs($txtVencimento)
                                , 'proxima_assembleia' => dataPtUs($txtProxAssembleia)
                                , 'lance_medio' => $txtLanceMedio
                                , 'id_proposta' => $id_proposta
            );

            //echo '11:54:44 - <h3>Dump 79 </h3> <br><br>' . var_dump( $fieldsInsert); exit;					//<-------DEBUG

            $this->dbMaster->insert('proposta_consorcio_simulacao', $fieldsInsert);
        }

        $whereCheck = array('id_proposta' => $id_proposta);
        //$jsonGravacao = $this->dbMaster->select('proposta_consorcio_gravacao_json', $whereCheck);
        $simulacoes = $this->dbMaster->select('proposta_consorcio_simulacao', $whereCheck);

        $cliente = $this->proposta_buscar($whereCheck);
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
			$data['categoria'] = $cliente['firstRow']->categoria;
			$data['numero_parcelas'] = $cliente['firstRow']->numero_parcelas;
			$data['parcela_valor'] = $cliente['firstRow']->parcela_valor;
			$data['carta_valor'] = $cliente['firstRow']->carta_valor;
			$data['data_criacao'] = $cliente['firstRow']->data_criacao;
			$data['boleto_bar'] = $cliente['firstRow']->boleto_bar;
			
            foreach ($simulacoes['result']->getResult() as $row) {
                // if ($row->banco == "PAN"){
                //     $row->json = $this->pan_json_simulacao_translator_advanced($row->json);
                // } else if ($row->banco == "FACTA"){
                //     $row->json = $this->facta_json_simulacao_translator_advanced($row->json);
                // }
            }
    
            $data['simulacoes'] = $simulacoes;
            //$data['id_simulacao'] = $cliente['firstRow']->id_simulacao;

			$statusProposta = $cliente['firstRow']->statusProposta;
			$data['statusProposta'] = $statusProposta;
			$data['header'] = $cliente['firstRow']->header;
			$data['data_emissao'] = $cliente['firstRow']->data_emissao;
			$data['data_criacao'] = $cliente['firstRow']->data_criacao;
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


        return $this->loadpage('consorcio/cliente_detalhes', $data);
    }

    public function adm_simulacao($action, $id_proposta, $id_simulacao){
        if ($action == "D") {
            $whereCheck = array('id_simulacao' => $id_simulacao, 'id_proposta' => $id_proposta);
            $this->dbMaster->delete('proposta_consorcio_simulacao', $whereCheck);
        } else if ($action == "A") {
            //limpa aprovações anteriores
            $whereArrayUpdt = array('id_proposta' => $id_proposta);
            $fieldUpdate = array('aprovada' => 'N');
            $fielDynamicdUpdate = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_consorcio_simulacao', $fieldUpdate, $whereArrayUpdt, $fielDynamicdUpdate);

            //grava aprovacao
            $whereArrayUpdt = array('id_proposta' => $id_proposta, "id_simulacao" => $id_simulacao);
            $fieldUpdate = array('aprovada' => 'Y');
            $fielDynamicdUpdate = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_consorcio_simulacao', $fieldUpdate, $whereArrayUpdt, $fielDynamicdUpdate);
        }

        return redirect()->to('consorcio-cliente-detalhes/' . $id_proposta);
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
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', false);
            $operadorFiltro = $this->getpost('operadorFiltro', false);
            $flag = $this->getpost('flag',false);
               
            Services::response()->setCookie('cpf', $cpf);
            Services::response()->setCookie('verificador', $verificador);
            Services::response()->setCookie('celular', $celular);
            Services::response()->setCookie('nome', $nome);
            Services::response()->setCookie('email', $email);
            Services::response()->setCookie('statusPropostaFiltro', $statusPropostaFiltro);
            Services::response()->setCookie('operadorFiltro', $operadorFiltro);
            Services::response()->setCookie('flag', $flag);

            //$aux = Services::request()->getCookie($valor);	
        } else {
            $cpf = $this->getpost('txtCPF', true);
            $verificador = $this->getpost('verificador', true);
            $celular = $this->getpost('celular', true);
            $nome = $this->getpost('txtNome', true);
            $email = $this->getpost('email', true);
            $statusPropostaFiltro = $this->getpost('statusPropostaFiltro', true);
            $operadorFiltro = $this->getpost('operadorFiltro', true);
            $flag = $this->getpost('flag',true);
        }

        $flag = (empty($flag) ? 'ACAO' : $flag);
        
        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];
        
        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        if (!empty($verificador)) $likeCheck['verificador'] = $verificador;
        if (!empty($celular)) $likeCheck['celular'] = $celular;
        if (!empty($statusPropostaFiltro)) $whereCheck['statusProposta'] = $statusPropostaFiltro;
        if (!empty($nome)) $likeCheck['nome'] = $nome;
        if (!empty($email)) $likeCheck['email'] = $email;

        if ((count($likeCheck) == 0) and (count($whereCheck) == 0)){
            if ($flag == "ACAO"){
                $fasesAdd = getFasesCategoryConsorcio('acao');
                $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
            } else if ($flag == "OCULTAS"){
                $fasesAdd = getFasesCategoryConsorcio('fim');
                $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
            }
        }

        $likeCheck = array("likeCheck" => $likeCheck);

        $this->dbMaster->setLimit(500);
        $this->dbMaster->setOrderBy(array('id_proposta', 'DESC'));
        $propostas = $this->dbMaster->select('proposta_consorcio', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

        //INDICADORES
        $dados['indicadores'] = $this->indicadores();

        $dados['pageTitle'] = "Consórcio - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['verificador'] = $verificador;
        $dados['celular'] = $celular;
        $dados['email'] = $email;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        $dados['operadorFiltro'] = $operadorFiltro;
        $dados['fases'] = $fases;
        $dados['users'] = $users;
        $dados['flag'] = $flag;
        
        $dados['eventos'] = $eventos;

        return $this->loadpage('consorcio/listar_propostas', $dados);
    }

    public function indicadores(){
        $indicadores = [];
        $indicadores['clicks_campanha'] = $this->dbMaster->runQuery("select count(*) total from campanha_click_count where DATE(last_updated) = CURDATE();")['firstRow']->total;
        $indicadores['clicks_campanha_inbound'] = $this->dbMaster->runQuery("select slug, count(*) total from campanha_click_count where DATE(last_updated) = CURDATE() group by slug order by total desc;")['firstRow'];
        $indicadores['clicks_campanha_ontem'] = $this->dbMaster->runQuery("select count(*) total from campanha_click_count where DATE(last_updated) = DATE_SUB(CURDATE(), INTERVAL 1 DAY);")['firstRow']->total;
        $indicadores['propostas_cadastradas'] = $this->dbMaster->runQuery("select count(*) total from proposta_consorcio where DATE(data_criacao) = CURDATE();")['firstRow']->total;
        $indicadores['propostas_cadastradas_ontem'] = $this->dbMaster->runQuery("select count(*) total from proposta_consorcio where DATE(data_criacao) = DATE_SUB(CURDATE(), INTERVAL 1 DAY);")['firstRow']->total;
        $indicadores['top_indicacao'] = $this->dbMaster->runQuery("select chave_origem, count(*) total from proposta_consorcio where DATE(data_criacao) = CURDATE() and chave_origem is not null group by chave_origem order by total desc")['firstRow'];

        return $indicadores;
    }

    public function atualizarStatusPropostaOperador($id_proposta){

        $where = array('id_proposta' => $id_proposta);
        $fields = array('OperadorCCenter' => $this->session->nickname);
        $fieldsDynamic = array('last_update' => 'current_timestamp()');
        $this->dbMaster->update('proposta_consorcio', $fields, $where, $fieldsDynamic);

        return redirect()->to('consorcio-listar-propostas');
    }

    public function consorcio_atualizar_proposta($id_proposta, $idFase){
        $status = lookupFasesConsorcio($idFase)['faseName'];
        $where = array('id_proposta' => $id_proposta);
        $fields = array('statusProposta' => $status);
        $fieldsDynamic = array('last_update' => 'current_timestamp()');
        $this->dbMaster->update('proposta_consorcio', $fields, $where, $fieldsDynamic);

        $whereCheck = array('id_proposta' => $id_proposta);
        $cliente = $this->proposta_buscar($whereCheck);
        $verificador = strtoupper($cliente['firstRow']->verificador);
        $faseSimples = propostaFaseFormatSimplesConsorcio($status);

        $output = $this->telegram->notifyTelegramGroup("👾👾👾 FASE <b>[C]</b>$verificador - " . $faseSimples);

        $result = $this->dbMaster->insert('customer_journey', array("verificador" => $verificador, "descricao" => "FASE CONSÓRCIO: $faseSimples", "slug" => 'PRP', "direction" => "SAIDA", "channel" => "INSIGHT", "type" => "PROPOSTA"));

        return redirect()->to('consorcio-listar-propostas');
    }

    public function fasesProposta(){
        $db =  $this->dbMaster->getDB();
        $builder = $db->table('proposta_consorcio');
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

    public function fileupdate($id_proposta){

        $_boleto = "";
        $_contrato = "";

        if (!empty($_FILES['flBoleto']['tmp_name'])) $_boleto = file_get_contents($_FILES['flBoleto']['tmp_name']);
        if (!empty($_FILES['flContrato']['tmp_name'])) $_contrato = file_get_contents($_FILES['flContrato']['tmp_name']);
        $txtCodigoBarras = $this->getpost('txtCodigoBarras');
       
        $where = array('id_proposta' => $id_proposta);

        if (!empty($_boleto)){
            $fields = array('boleto_bin' => $_boleto);
            $fieldsDynamic = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_consorcio', $fields, $where, $fieldsDynamic);
        }
        if (!empty($_contrato)){
            $fields = array('contrato_bin' => $_contrato);
            $fieldsDynamic = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_consorcio', $fields, $where, $fieldsDynamic);
        }
        if (!empty($txtCodigoBarras)){
            $fields = array("boleto_bar" => $txtCodigoBarras);
            $fieldsDynamic = array('last_update' => 'current_timestamp()');
            $this->dbMaster->update('proposta_consorcio', $fields, $where, $fieldsDynamic);
        }
    }
}
