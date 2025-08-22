<?php

namespace App\Controllers\Insight;

use App\Models\M_insight;
use App\Models\M_bmg;


class Perfil extends \App\Controllers\BaseController
{

    protected $m_insight;
    protected $session;
    protected $m_bmg;

    public function index()
    {
        $this->m_bmg = new M_bmg();
        $this->checkSession();
        $this->session = session();

        $dados['pageTitle'] = 'Clientes';
        $dados['nickname'] = $this->session->nickname;
        $dados['email'] = $this->session->email;

        if ($this->session->role == "SUPERVISOR") {
            $dados['cargo'] = "Supervisor";
        } else if ($this->session->role == "OPERADOR") {
            $dados['cargo'] = "Operador";
        } else if ($this->session->role == "AUDITOR") {
            $dados['cargo'] = "Auditor";
        } else if ($this->session->role == "GERENTE") {
            $dados['cargo'] = "Gerente";
        }

        $dados['vendas'] = $this->m_bmg->barraProgressoAssessor();


        return $this->loadPage('seguranca/perfil', $dados);
    }
}
