<?php

namespace App\Controllers\Fgts;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;

class Fgts extends BaseController
{
    protected $session;
    protected $dbMasterDefault;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("fgtsDB"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
    }

    //retorna dados da proposta gravada
    public function proposta_buscar($id_proposta)
    {
        return $this->dbMaster->select('proposta_fgts', array('id_proposta' => $id_proposta));
    }

    public function clienteDetalhes($id_proposta){
        $data['pageTitle'] = "FGTS - Detalhes Cliente";
        
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
			
			$statusProposta = $cliente['firstRow']->statusProposta;
			$data['statusProposta'] = $statusProposta;
			$offlineMode = $cliente['firstRow']->offlineMode;
			$data['offlineMode'] = $offlineMode;

        }

        

        $db =  $this->dbMaster->getDB();
        $builder = $db->table('whatsapp_log');
        $builder->Like('whatsapp_log.To', substr($to,-8)); //bug do número 9 no whatsapp
        $builder->orLike('whatsapp_log.From', substr($to,-8));
        $builder->orderBy('id', 'DESC');
        $builder->select('*');
		//echo $builder->getCompiledSelect();exit;
		$chat = $this->dbMaster->resultfy($builder->get());
        //echo '22:51:12 - <h3>Dump 91 da variável $chat </h3> <br><br>' . var_dump($chat); exit;					//<-------DEBUG
        $data['chat'] = $chat;
        return $this->loadpage('fgts/cliente_detalhes', $data);
    }

    public function listarPropostas(){

        $fases = $this->fasesProposta();
        $users = $this->listaOPeradores();
        //echo "22:00:48 - <h3>Dump 36</h3> <br><br>" . var_dump($this->session->session_id); exit;					//<-------DEBUG
        $cpf = $this->getpost('txtCPF');
        $verificador = $this->getpost('verificador');
        $nome = $this->getpost('txtNome');
        $statusPropostaFiltro = $this->getpost('statusPropostaFiltro');
        $offlineMode = $this->getpost('offlineMode');
        $operadorFiltro = $this->getpost('operadorFiltro');

        $whereCheck = [];
        $likeCheck = [];
        if (!empty($cpf)) $whereCheck['cpf'] = $cpf;
        if (!empty($offlineMode)) $whereCheck['offlineMode'] = $offlineMode;
        if (!empty($verificador)) $likeCheck['verificador'] = $verificador;
        if (!empty($statusPropostaFiltro)) $whereCheck['statusProposta'] = $statusPropostaFiltro;
        if (!empty($nome)) $likeCheck['nome'] = $nome;

        $fasesRemove = [lookupFases('CAN')['faseName'], lookupFases('FIM')['faseName']];
        $whereNotIn = array("whereNotIn" => array('statusProposta', $fasesRemove));
        $likeCheck = array("likeCheck" => $likeCheck);

        //TODO: ajustar WhereNotIn
        $whereCheck['statusProposta <>'] = lookupFases('CAN')['faseName'];
        $whereCheck['statusProposta !='] = lookupFases('FIM')['faseName'];

        $propostas = $this->dbMaster->select('proposta_fgts', $whereCheck, $whereNotIn + $likeCheck);

        $dados['pageTitle'] = "FGTS - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['offlineMode'] = $offlineMode;
        $dados['verificador'] = $verificador;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        $dados['operadorFiltro'] = $operadorFiltro;
        $dados['fases'] = $fases;
        $dados['users'] = $users;
        
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
