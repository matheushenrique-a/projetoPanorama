<?php

namespace App\Controllers\Seguranca;

use App\Controllers\BaseController;
use App\Libraries\dbMaster;
use Config\Services;

class Painel extends BaseController
{
    public function listar_usuarios()
    {
        $buscarProp = $this->getpost('buscarProp');

        if (!empty($buscarProp)) {
            helper('cookie');
            $nickname = $this->getpost('content', false);
            $role = $this->getpost('role', false);

            Services::response()->setCookie('nickname', $nickname);
            Services::response()->setCookie('role', $role);
        } else {
            $nickname = $this->getpost('nickname', true);
            $role = $this->getpost('role', true);
        }

        $whereCheck = [];
        $likeCheck = [];

        if (!empty($role)) $whereCheck['role'] = $role;
        if (!empty($nickname)) $likeCheck['nickname'] = $nickname;

        $parametros = [];
        if (!empty($likeCheck)) $parametros['likeCheck'] = $likeCheck;

        $this->dbMaster->setLimit(20);
        $this->dbMaster->setOrderBy(['userId', 'DESC']);

        $usuarios = $this->dbMaster->select('user_account', $whereCheck, $parametros);

        $dados = [
            'pageTitle' => 'Painel de Usuários',
            'usuarios' => $usuarios['result']->getResult(), 
            'nickname' => $nickname,
            'role' => $role,
        ];

        return $this->loadpage('seguranca/painel', $dados);
    }

    public function criar_usuarios($userId, $action)
    {
        if ($action == "create") {
            $nome = $this->getpost('nickname');
            $email = $this->getpost('email');
            $senha = $this->getpost('password');
            $empresa = "QUID";
            $equipe = null;
            $cargo = $this->getpost('role');

            // configurar permissões
            $permissions = [];

            if ($cargo == "SUPERVISOR") {
                $supervisor = 1;
                array_push($permissions, "ADMIN","BMG");
            } else {
                $supervisor = 164815;
                array_push($permissions, "BMG");
            }

            // configurar parametros
            $parameters = json_encode([
                "integraallId" => 1107,
                "google-meeting" => "https://meet.google.com/nni-mqwn-xxj"
            ]);

            $status = 'ATIVO';

            $dados = [
                'nickname' => $nome,
                'email' => $email,
                'password' => $senha,
                'empresa' => $empresa,
                'equipe' => $equipe,
                'role' => $cargo,
                'report_to' => $supervisor,
                'perfil_acesso' => json_encode($permissions),
                'parameters' => $parameters,
                'status' => $status
            ];

            if ($userId != 0) {
                $this->dbMaster->update('user_account', $dados, ['userId' => $userId]);
            } else {
                $this->dbMaster->insert('user_account', $dados);
            }

            return redirect()->to('seguranca/painel');
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
            return redirect()->to('seguranca/painel');
        }

        $whereCheck['role'] = 'SUPERVISOR';

        $res = $this->dbMaster->select('user_account', $whereCheck);
        $dados['supervisorlist'] = $res['result']->getResultArray();

        $whereCheckGerente['role'] = 'GERENTE';

        $resger = $this->dbMaster->select('user_account', $whereCheckGerente);
        $dados['gerentelist'] = $resger['result']->getResultArray();

        $dados['cargoSelecionado'] = $this->request->getPost('role') ?? '';

        return $this->loadpage('seguranca/cadastro', $dados);
    }
}
