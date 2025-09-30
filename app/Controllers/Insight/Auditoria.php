<?php

namespace App\Controllers\Insight;

use App\Models\M_insight;
use App\Libraries\dbMaster;
use App\Models\M_seguranca;

class Auditoria extends \App\Controllers\BaseController
{
    protected $session;
    protected $m_security;
    protected $m_insight;
    protected $dbMaster;
    protected $db;

    public function __construct()
    {
        $this->session = session();
        $this->m_insight = new M_insight();
        $this->dbMaster = new dbMaster();
        $this->db = \Config\Database::connect();
    }

    public function filaAuditoria()
    {
        $dados['pageTitle'] = "Auditoria";

        $auditores = $this->m_insight->getAllThat('user_account', [
            'role'   => 'AUDITOR'
        ]);

        $dados['auditores'] = $auditores;

        return $this->loadpage('insight/fila-auditoria', $dados);
    }

    public function mudarStatus($id)
    {
        $auditor = $this->dbMaster->select('user_account', ['userId' => $id])['firstRow'];

        $status = $auditor->status;

        if ($status == "ATIVO") {
            $this->dbMaster->update('user_account', ['status' => 'INATIVO'], ['userId' => $id]);
        } else {
            $this->dbMaster->update('user_account', ['status' => 'ATIVO'], ['userId' => $id]);
        }

        return redirect()->to(urlInstitucional . 'fila-auditoria');
    }

    public function notificacoes()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        $updated = $this->dbMaster->update(
            'quid_notificacoes',
            ['is_read' => 1],
            ['idquid_notificacoes' => $id]
        );

        return $this->response->setJSON(['success' => (bool)$updated]);
    }

    public function buscarNotificacoes($userId)
    {
        $builder = $this->db->table('quid_notificacoes');
        $builder->where('userId', $userId);
        $builder->where('is_read', 0);
        $builder->orderBy('created_at', 'DESC');
        $query = $builder->get();

        return $this->response->setJSON($query->getResult());
    }
}
