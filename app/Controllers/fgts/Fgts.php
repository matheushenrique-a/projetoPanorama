<?php

namespace App\Controllers\Fgts;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;

class Fgts extends BaseController
{
    protected $dbMasterFGTS;
    protected $session;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        $this->checkSession();
        $this->dbMasterFGTS = new dbMaster(); // create an instance of Library class
        $this->session = session();
    }

    public function listarPropostas(){
        //echo "22:00:48 - <h3>Dump 36</h3> <br><br>" . var_dump($this->session->session_id); exit;					//<-------DEBUG
        $cpf = $this->getpost('txtCPF');
        $verificador = $this->getpost('verificador');
        $nome = $this->getpost('txtNome');
        $statusPropostaFiltro = $this->getpost('statusPropostaFiltro');
        $btnExport = $this->getpost('btnExport');

        $whereCheck = [];
        $likeCheck = [];
        if (!empty($cpf)) $whereCheck['cpf'] = $cpf;
        if (!empty($verificador)) $whereCheck['verificador'] = $verificador;
        if (!empty($statusPropostaFiltro)) $whereCheck['statusProposta'] = $statusPropostaFiltro;
        if (!empty($nome)) $likeCheck['nome'] = $nome;

        $propostas = $this->dbMasterFGTS->select('proposta_fgts', $whereCheck, $likeCheck);
       // echo "14:46:43 - <h3>Dump 92</h3> <br><br>" . var_dump($propostas); exit;					//<-------DEBUG

        $dados['pageTitle'] = "FGTS - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['verificador'] = $verificador;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        
        return $this->loadpage('fgts/listar_propostas', $dados);
    }

    public function atualizarStatusPropostaOperador($id_proposta){
        $where = array('id_proposta' => $id_proposta);
        $fields = array('OperadorCCenter' => $this->session->nickname);
        $fieldsDynamic = array('last_update' => 'current_timestamp()');
        $this->dbMasterFGTS->update('proposta_fgts', $fields, $where, $fieldsDynamic);

        return redirect()->to('fgts-listar-propostas');
    }

    public function atualizarStatusPropostaDisponivel($id_proposta){
        $status = "PASSO 08 - PROPOSTA DISPONÍVEL";
        $where = array('id_proposta' => $id_proposta);
        $fields = array('statusProposta' => $status);
        $fieldsDynamic = array('last_update' => 'current_timestamp()');
        $this->dbMasterFGTS->update('proposta_fgts', $fields, $where, $fieldsDynamic);

        return redirect()->to('fgts-listar-propostas');
    }

    public function atualizarStatusPropostaAdesao($id_proposta){
        $status = "PASSO 08 - PENDENTE ADESAO";
        $where = array('id_proposta' => $id_proposta);
        $fields = array('statusProposta' => $status);
        $fieldsDynamic = array('last_update' => 'current_timestamp()');
        $this->dbMasterFGTS->update('proposta_fgts', $fields, $where, $fieldsDynamic);

        return redirect()->to('fgts-listar-propostas');
    }

}
