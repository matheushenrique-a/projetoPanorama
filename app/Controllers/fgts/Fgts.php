<?php

namespace App\Controllers\Fgts;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Fgts extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        
        //$this->checkSession();
    }

    public function listarPropostas()
    {
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

        $propostas = $this->dbMaster->select('proposta_fgts', $whereCheck, $likeCheck);
       // echo "14:46:43 - <h3>Dump 92</h3> <br><br>" . var_dump($propostas); exit;					//<-------DEBUG

        $dados['pageTitle'] = "FGTS - Listar propostas";
        $dados['propostas'] = $propostas;
        $dados['cpf'] = $cpf;
        $dados['nome'] = $nome;
        $dados['verificador'] = $verificador;
        $dados['statusPropostaFiltro'] = $statusPropostaFiltro;
        
        return $this->loadpage('fgts/listar_propostas', $dados);

    }

}
