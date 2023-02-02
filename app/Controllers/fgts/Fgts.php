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
