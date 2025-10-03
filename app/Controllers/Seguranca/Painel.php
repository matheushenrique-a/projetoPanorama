<?php

namespace App\Controllers\Seguranca;

use App\Controllers\BaseController;
use App\Libraries\dbMaster;
use Config\Services;

class Painel extends BaseController
{
    protected $session;
    protected $my_security;

    public function listar_usuarios($page = 1)
    {
        $buscarProp = $this->getpost('buscarProp');
        $this->session = session();

        if (!empty($buscarProp)) {
            helper('cookie');
            $nickname   = $this->getpost('content', false);
            $role       = $this->getpost('role', false);
            $report_to  = $this->getpost('report_to', false);

            Services::response()->setCookie('nickname', $nickname);
            Services::response()->setCookie('role', $role);
            Services::response()->setCookie('report_to', $report_to);
        } else {
            $nickname   = $this->getpost('nickname', true);
            $role       = $this->getpost('role', true);
            $report_to  = $this->getpost('report_to', true);
        }

        $whereCheck = [];
        $likeCheck  = [];

        $whereCheck['empresa'] = EMPRESA;

        if (!$this->my_security->checkPermission("ADMIN")) {
            $likeCheck['report_to'] = $this->session->userId;
        }

        if (!empty($role)) $whereCheck['role'] = $role;
        if (!empty($nickname)) $likeCheck['nickname'] = $nickname;
        if (!empty($report_to)) $likeCheck['report_to'] = $report_to;

        $parametros = [];
        if (!empty($likeCheck)) $parametros['likeCheck'] = $likeCheck;

        // 🔹 define paginação
        $perPage = 10;
        $offset  = ($page - 1) * $perPage;

        $this->dbMaster->setLimitPage($perPage, $offset); // sua lib aceita limit/offset aqui
        $this->dbMaster->setOrderBy(['userId', 'DESC']);

        // 🔹 selectPage já traz os dados + count
        $usuarios = $this->dbMaster->selectPage('user_account', $whereCheck, $parametros);

        $countUsers = $this->dbMaster->countOnly('user_account', $whereCheck, $parametros);
        $totalPages = ceil($countUsers / $perPage);

        $totalPages = ceil($countUsers / $perPage);

        $dados = [
            'pageTitle'   => 'Painel de Usuários',
            'usuarios'    => $usuarios['result']->getResult(), // resultados da página
            'nickname'    => $nickname,
            'role'        => $role,
            'countUsers'  => $countUsers,        // total de registros
            'quantidade'  => $perPage,           // registros por página
            'currentPage' => $page,
            'totalPages'  => $totalPages
        ];

        return $this->loadpage('seguranca/painel', $dados);
    }


    public function criar_usuarios($userId, $action)
    {
        if ($action == "create") {
            $nome = $this->getpost('nickname');
            $email = $this->getpost('email');
            $senha = $this->getpost('password');
            $empresa = strtoupper(EMPRESA);
            $equipe = null;
            $cargo = $this->getpost('role');
            $supervisor = $this->getpost('report_to');

            $file = $this->request->getFile('profile_image');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();

                $file->move(FCPATH . 'uploads/profile_images', $newName);
                $imgPath = 'uploads/profile_images/' . $newName;
            }

            $permissions = [];

            if ($this->getpost('bmg')) {
                $permissions[] = "BMG";
            }

            if ($this->getpost('bradesco')) {
                $permissions[] = "BRADESCO";
            }

            if ($this->getpost('admin')) {
                $permissions[] = "ADMIN";
            }


            if ($cargo == "SUPERVISOR") {
                array_push($permissions, "SUPERVISOR", "QUID");
            } else if ($cargo == "AUDITOR") {
                array_push($permissions, "QUID", "FORMALIZACAO");
            } else {
                array_push($permissions, "QUID");
            }

            $status = 'ATIVO';

            if(!empty($file)){
                $dados['profile-image'] = $imgPath ?? "";
            }

            $dados = [
                'nickname' => $nome,
                'email' => $email,
                'password' => $senha,
                'empresa' => $empresa,
                'equipe' => $equipe,
                'role' => $cargo,
                'report_to' => $supervisor,
                'perfil_acesso' => json_encode($permissions),
                'status' => $status,
            ];

            if ($userId != 0) {
                $this->dbMaster->update('user_account', $dados, ['userId' => $userId]);
            } else {
                $this->dbMaster->insert('user_account', $dados);
            }

            return redirect()->to(urlInstitucional . 'painel/1');
        }

        $dados['pageTitle'] = "Cadastro";

        if ($action == 'edit') {
            $usuario = $this->dbMaster->select('user_account', ['userId' => $userId]);
            $usuarioDados = $usuario['firstRow'];

            $dados['pageTitle'] = "Edição";

            $dados['userId'] = $userId;
            $dados['nome'] = $usuarioDados->nickname;
            $dados['email'] = $usuarioDados->email;
            $dados['senha'] = $usuarioDados->password;
            $dados['cargo'] = $usuarioDados->role;
            $dados['supervisor'] = $usuarioDados->report_to;
            $dados['perfil_acesso'] = $usuarioDados->perfil_acesso;
            $dados['profile_image'] = $usuarioDados->profile_image;

            $perfilAcesso = json_decode($dados['perfil_acesso'], true);

            $permissions = [];

            foreach ($perfilAcesso as $permissao) {
                $permissions[] = $permissao;
            }

            if (in_array("BMG", $permissions)) {
                $dados['bmg'] = true;
            } else {
                $dados['bmg'] = false;
            }

            if (in_array("BRADESCO", $permissions)) {
                $dados['bradesco'] = true;
            } else {
                $dados['bradesco'] = false;
            }

            if (in_array("ADMIN", $permissions)) {
                $dados['admin'] = true;
            } else {
                $dados['admin'] = false;
            }

            $whereCheck['role'] = 'SUPERVISOR';

            $res = $this->dbMaster->select('user_account', $whereCheck);
            $dados['supervisorlist'] = $res['result']->getResultArray();

            $whereCheckGerente['role'] = 'GERENTE';

            $resger = $this->dbMaster->select('user_account', $whereCheckGerente);
            $dados['gerentelist'] = $resger['result']->getResultArray();

            return $this->loadpage('seguranca/editar', $dados);
        }

        if ($action == "remove") {
            $this->dbMaster->delete('user_account', ['userId' => $userId]);
            return redirect()->to(urlInstitucional . 'painel/1');
        }

        $whereCheck['role'] = 'SUPERVISOR';
        $whereCheck['empresa'] = EMPRESA;

        $res = $this->dbMaster->select('user_account', $whereCheck);
        $dados['supervisorlist'] = $res['result']->getResultArray();

        $whereCheckGerente['role'] = 'GERENTE';
        $whereCheckGerente['empresa'] = EMPRESA;

        $resger = $this->dbMaster->select('user_account', $whereCheckGerente);
        $dados['gerentelist'] = $resger['result']->getResultArray();

        $dados['cargoSelecionado'] = $this->request->getPost('role') ?? '';

        return $this->loadpage('seguranca/cadastro', $dados);
    }
}
