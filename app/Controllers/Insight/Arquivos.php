<?php

namespace App\Controllers\Insight;

use App\Models\M_insight;
use App\Libraries\dbMaster;

class Arquivos extends \App\Controllers\BaseController
{
    protected $m_insight;
    protected $dbMasterDefault;

    public function uploadPropostas()
    {
        $dados['pageTitle'] = 'Upload de Propostas';

        return $this->loadpage('insight/insight_upload_propostas', $dados);
    }

    public function exportPropostas($action)
    {
        $this->dbMasterDefault = new dbMaster();
        $dados['pageTitle'] = 'Exportação';

        if ($action == '1') {
            $dataInicio = $this->getpost('dataInicial');
            $dataFim = $this->getpost('dataFinal');
            $status = $this->getpost('status');
            $report_to = $this->getpost('report_to');
            $produto = $this->getpost('produto');
            $assessor = $this->getpost('assessor');

            $columns = $this->getPostArray('columns') ?? [];

            $where = [];

            if (!empty($dataInicio) && !empty($dataFim)) {
                $where['DATE(data_criacao) >='] = $dataInicio;
                $where['DATE(data_criacao) <='] = $dataFim;
            }

            if (!empty($status)) {
                $where['status'] = $status;
            }

            if (!empty($report_to)) {
                $where['report_to'] = $report_to;
            }

            if (!empty($produto)) {
                $where['produto'] = $produto;
            }

            if (!empty($assessor)) {
                $where['assessor'] = $assessor;
            }

            $this->dbMasterDefault->exportCSV('quid_propostas', $columns, $where);
        }

        return $this->loadpage('insight/insight_export_propostas', $dados);
    }

    public function anexarArquivos($idProposta)
    {

        $this->m_insight = new M_insight();
        $file = $this->request->getFile('arquivo');

        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();

            $uploadPath = WRITEPATH . 'uploads/' . $idProposta;

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $file->move($uploadPath, $newName);

            $nome_original = $file->getClientName();
            $caminho = 'writable/uploads/' . $idProposta . '/' . $newName;

            $data = [
                'id_proposta' => $idProposta,
                'nome_original' => $nome_original,
                'nome_armazenado' => $newName,
                'caminho' => $caminho
            ];

            $this->m_insight->anexarArquivoProposta($data);

            return redirect()->to(urlInstitucional . 'insight-proposta/' . $idProposta);
        }

        return redirect()->to(urlInstitucional . 'insight-proposta/' . $idProposta);
    }

    public function download($id, $idProposta)
    {
        $this->dbMasterDefault = new dbMaster();
        $arquivo = $this->dbMasterDefault->downloadArquivos($id);

        if (!$arquivo) {
            return redirect()->to(urlInstitucional . 'insight-listar-propostas/0/0');
        }

        $caminho = WRITEPATH . 'uploads/' . $arquivo->id_proposta . '/' . $arquivo->nome_armazenado;

        if (!file_exists($caminho)) {
            return redirect()->to(urlInstitucional . 'insight-listar-propostas/0/0');
        }

        return $this->response->download($caminho, null, true)
            ->setFileName($arquivo->nome_original);
    }

    public function excluir($id, $idProposta)
    {
        $this->dbMasterDefault = new dbMaster();
        $arquivo = $this->dbMasterDefault->downloadArquivos($id);

        if (!$arquivo) {
            return redirect()->to(urlInstitucional . 'insight-proposta/' . $idProposta);
        }

        $caminho = WRITEPATH . 'uploads/' . $arquivo->id_proposta . '/' . $arquivo->nome_armazenado;

        if (file_exists($caminho)) {
            unlink($caminho);
        }

        $this->dbMasterDefault->delete('arquivos', ['id' => $id]);

        return redirect()->to(urlInstitucional . 'insight-proposta/' . $idProposta);
    }
}
