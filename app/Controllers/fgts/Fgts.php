<?php

namespace App\Controllers\Fgts;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;

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

    public function clienteDetalhes($id_proposta){
        $data['pageTitle'] = "FGTS - Detalhes Cliente";

        //OCORRENCIAS
        $ocorrencias = $this->getpost('ocorrencias');
        $txtMensagemDireta = $this->getpost('txtMensagemDireta');
        $btnSalvar = $this->getpost('btnSalvar');

        //PROPOSTA GRAVADA
        $txtNumeroProposta = $this->getpost('txtNumeroProposta');
        $txtValorPago = $this->getpost('txtValorPago');
        $txtURLCliente = $this->getpost('txtURLCliente');
        $txtErroIntegracao = $this->getpost('txtErroIntegracao');
        $btnSalvarProposta = $this->getpost('btnSalvarProposta');
        $btnMensagemDireta = $this->getpost('btnMensagemDireta');
        $btnCidadesListar = $this->getpost('btnCidadesListar');
        $btnGravarFacta = $this->getpost('btnGravarFacta');

        if (!empty($btnSalvar)){
            $where = array('id_proposta' => $id_proposta);
            $fields = array('ocorrencias' => $ocorrencias);
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
            $fields = array('id_proposta' => $id_proposta, 'json' => $json, 'numeroPropostaGerada' => $txtNumeroProposta, 'valor_pago' => $valorClean, 'linkCliente' => $txtURLCliente, 'MotivoIntegracao' => $txtErroIntegracao);
            $this->dbMaster->insert('proposta_fgts_gravacao_json', $fields);
        }


        $whereCheck = array('id_proposta' => $id_proposta);
        $jsonGravacao = $this->dbMaster->select('proposta_fgts_gravacao_json', $whereCheck);
        $simulacoes = $this->dbMaster->select('proposta_fgts_simulacao_json', $whereCheck);

        if ($jsonGravacao['existRecord']){
            $txtNumeroProposta = $jsonGravacao['firstRow']->numeroPropostaGerada;
            $txtValorPago = SimpleRound($jsonGravacao['firstRow']->valor_pago);
            $txtURLCliente = $jsonGravacao['firstRow']->linkCliente;
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
			$data['dtaNascimento'] = $cliente['firstRow']->data_nascimento;
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
			
            $data['txtNumeroProposta'] = $txtNumeroProposta;
            $data['txtValorPago'] = $txtValorPago;
            $data['txtURLCliente'] = $txtURLCliente;
            $data['txtErroIntegracao'] = $txtErroIntegracao;
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

    public function listarPropostas(){
        $fases = $this->fasesProposta();
        $users = $this->listaOPeradores();
        //echo "22:00:48 - <h3>Dump 36</h3> <br><br>" . var_dump($this->session->session_id); exit;					//<-------DEBUG
        $cpf = $this->getpost('txtCPF');
        $verificador = $this->getpost('verificador');
        $celular = $this->getpost('celular');
        $nome = $this->getpost('txtNome');
        $email = $this->getpost('email');
        $statusPropostaFiltro = $this->getpost('statusPropostaFiltro');
        $offlineMode = $this->getpost('offlineMode');
        $operadorFiltro = $this->getpost('operadorFiltro');

        $flag = $this->getpost('flag',true);
        $flag = (empty($flag) ? 'ACAO' : $flag);
        
        $whereCheck = [];
        $likeCheck = [];
        $whereNotIn = [];
        $whereIn = [];
        
        if (!empty($cpf)) $likeCheck['cpf'] = $cpf;
        if (!empty($offlineMode)) $whereCheck['offlineMode'] = $offlineMode;
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
            } else if ($flag == "OCULTAS"){
                $fasesAdd = getFasesCategory('fim');
                $whereIn = array("whereIn" => array('statusProposta', $fasesAdd)); 
                // $fasesRemove = [lookupFases('CAN')['faseName'], lookupFases('FIM')['faseName']];
                // $whereNotIn = array("whereNotIn" => array('statusProposta', $fasesRemove));        
            }
        }
        
        //foreach($fasesAdd as $item){echo "'" . $item . "', ";}exit;

        $likeCheck = array("likeCheck" => $likeCheck);

        $this->dbMaster->setOrderBy(array('id_proposta', 'DESC'));
        $propostas = $this->dbMaster->select('proposta_fgts', $whereCheck, $whereNotIn + $likeCheck + $whereIn);

        //INDICADORES
        $dados['indicadores'] = $this->indicadores();

        $dados['pageTitle'] = "FGTS - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['offlineMode'] = $offlineMode;
        $dados['verificador'] = $verificador;
        $dados['celular'] = $celular;
        $dados['email'] = $email;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        $dados['operadorFiltro'] = $operadorFiltro;
        $dados['fases'] = $fases;
        $dados['users'] = $users;
        $dados['flag'] = $flag;
        
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

}
