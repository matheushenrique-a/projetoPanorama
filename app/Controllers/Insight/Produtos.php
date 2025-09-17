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

        $dados['pendencias'] = $this->m_insight->getPendencias();
        $dados['cancelamentos'] = $this->m_insight->getCancelamentos();

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
                'motivosPendencia' => json_encode($this->request->getPost('motivos_pendencia') ?? []),
                'motivosCancelamento' => json_encode($this->request->getPost('motivos_cancelamento') ?? []),
                'ativo' => $this->getpost('ativo') ? 1 : 0,
                'valorSeguro' => $this->getpost('valorSeguro') ?? '',
                'temValorSeguro' => $this->getpost('temSeguro') ? 1 : 0,
                'modalidadeSeguro' => $this->getpost('modalidadeSeguro') ?? '',
                'temValorPrimario' => $this->getpost('valorPrimario') ? 1 : 0,

            ];

            $this->m_insight->insertProduto($data);

            return redirect()->to('/');
        }

        return $this->loadPage('produtos/registrar-produtos', $dados);
    }

    public function registrarPendencia($action)
    {
        $dados['pageTitle'] = 'Registrar Pendência';
        $dados['status'] = ['Pendente', 'Cancelada', 'Aprovada', 'Análise', 'Auditoria'];

        if ($action == 'add') {
            $this->m_insight = new M_insight();

            $data = [
                'nome_pendencia' => $this->getPost('nomePendência'),
                'status_link' => $this->getPost('status'),
            ];

            $this->m_insight->insertPendencia($data);

            return redirect()->to(urlInstitucional . 'registrar-pendencia/0');
        }

        return $this->loadPage('produtos/registrar-pendencias', $dados);
    }

    public function pendenciasEdit($action)
    {
        $this->m_insight = new M_insight();
        $dados['pageTitle'] = 'Editar Pendência';

        $dados['pendencias'] = $this->m_insight->getAll('quid_pendencias');

        return $this->loadPage('produtos/pendencias-edit', $dados);
    }

    public function produtosEdit($action)
    {
        $this->m_insight = new M_insight();
        $dados['pageTitle'] = 'Editar Produto';

        $dados['produtos'] = $this->m_insight->getAll('quid_produtos');

        return $this->loadPage('produtos/produtos-edit', $dados);
    }

    public function excluirPendencia($id)
    {
        $this->m_insight = new M_insight();
        $this->m_insight->deletePendencia($id);

        return redirect()->to(urlInstitucional . 'pendencias-edit/0');
    }

    public function excluirProduto($id)
    {
        $this->m_insight = new M_insight();
        $this->m_insight->deleteProduto($id);

        return redirect()->to(urlInstitucional . 'produtos-edit/0');
    }

    public function editarProduto($action, $idProduto)
    {
        $dados['pageTitle'] = 'Editar Produto';
        $this->m_insight = new M_insight();
        $dados['produto'] = $this->m_insight->getProdutoById($idProduto);

        $dados['pendencias'] = $this->m_insight->getPendencias();
        $dados['cancelamentos'] = $this->m_insight->getCancelamentos();

        $dados['produto']->motivosPendencia = json_decode($dados['produto']->motivosPendencia ?? '[]', true);
        $dados['produto']->motivosCancelamento = json_decode($dados['produto']->motivosCancelamento ?? '[]', true);


        if ($action == "edit") {
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
                'motivosPendencia' => json_encode($this->request->getPost('motivos_pendencia') ?? []),
                'motivosCancelamento' => json_encode($this->request->getPost('motivos_cancelamento') ?? []),
                'ativo' => $this->getpost('ativo') ? 1 : 0
            ];

            $this->m_insight->updateProduto($idProduto, $data);

            return redirect()->to(urlInstitucional . 'editar-produto/0/' . $idProduto);
        }

        return $this->loadPage('produtos/editar-produto', $dados);
    }
}
