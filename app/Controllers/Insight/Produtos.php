<?php

namespace App\Controllers\Insight;

use App\Models\M_insight;
use App\Libraries\dbMaster;

class Produtos extends \App\Controllers\BaseController
{
    protected $m_insight;
    protected $dbMaster;

    public function index()
    {
        $this->dbMaster = new dbMaster();
        $dados['pageTitle'] = 'Produtos';

        $listarProdutos = $this->dbMaster->listarProdutos();
        $dados['listarProdutos'] = $listarProdutos;

        return $this->loadPage('produtos/listar-produtos', $dados);
    }

    public function registrarProduto($action)
    {
        $this->m_insight = new M_insight();

        $dados['pageTitle'] = 'Registrar Produto';

        if ($action == 'add') {
            $data = [
                'nomeProduto' => $this->request->getPost('nomeProduto'),
                'valor' => $this->request->getPost('valor'),
                'valorFixo' => $this->request->getPost('valorFixo') ? 1 : 0,
                'iconSvg' => $this->request->getPost('iconSvg'),
                'parceiroComercial' => $this->request->getPost('parceiroComercial'),
                'modalidades' => $this->request->getPost('modalidades'),
                'dadosBancarios' => $this->request->getPost('dadosBancarios') ? 1 : 0,
                'endereco' => $this->request->getPost('endereco') ? 1 : 0,
                'inss' => $this->request->getPost('inss') ? 1 : 0,
                'temValor' => $this->request->getPost('temValor') ? 1 : 0, 
            ];

            $this->m_insight->insertProduto($data);

            return redirect()->to('/');
        }

        return $this->loadPage('produtos/registrar-produtos', $dados);
    }
}
