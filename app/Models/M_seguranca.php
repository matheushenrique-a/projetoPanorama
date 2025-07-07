<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;

class M_seguranca extends Model
{
    protected $dbMasterDefault;
    protected $my_session;

    public function __construct()
    {
        $this->dbMasterDefault = new dbMaster();
        $this->my_session = session();
    }

    function auth($email, $password = '')
    {
        $email = trim($email);
        $password = trim($password);

        if (empty($password)) {
            $whereCheck = array('email' => $email);
        } else {
            $whereCheck = array('email' => $email, 'password' => $password);
        }

        $login = $this->dbMasterDefault->select('user_account', $whereCheck);

        if ($login['existRecord']) {
            $user_empresa = $login['firstRow']->empresa;

            if (is_string($user_empresa) && str_starts_with($user_empresa, '[')) {
                $user_empresa = json_decode($user_empresa, true);
            }

            if (is_array($user_empresa)) {
                if (!in_array(strtoupper(EMPRESA), array_map('strtoupper', $user_empresa))) {
                    return;
                }
            } else {
                if (strtoupper($user_empresa) != strtoupper(EMPRESA)) {
                    return;
                }
            }

            $this->my_session->set('userId', $login['firstRow']->userId);
            $this->my_session->set('nickname', $login['firstRow']->nickname);
            $this->my_session->set('email', $login['firstRow']->email);
            $this->my_session->set('empresa', $login['firstRow']->empresa);
            $this->my_session->set('role', $login['firstRow']->role);
            $this->my_session->set('report_to', $login['firstRow']->report_to);
            $this->my_session->set('equipe', $login['firstRow']->equipe);
            $this->my_session->set('perfil', $login['firstRow']->perfil_acesso);
            $this->my_session->set('observacao', $login['firstRow']->observacao);
            $this->my_session->set('parameters', json_decode($login['firstRow']->parameters ?? "", true));

            helper('cookie');
            set_cookie('insight', $login['firstRow']->email, time() + 60 * 60 * 24 * 7); //30 days 
            return true;
        } else {
            return false;
        }
    }

    // echo '14:59:41 - <h3>Dump 36 </h3> <br><br>' . var_dump($this->my_session->perfil); exit;					//<-------DEBUG
    public function DisplayMenu($modulos)
    {
        $perfil = json_decode($this->my_session->perfil, true);

        if (!is_array($modulos)) {
            $modulos = [$modulos];
        }

        $temPermissao = false;

        foreach ($modulos as $modulo) {
            if (in_array($modulo, $perfil)) {
                $temPermissao = true;
                break;
            }
        }

        echo ($temPermissao
            ? 'display: block; visibility: visible;'
            : 'display: none; visibility: hidden;');
    }

    public function HasPermission($modulos, $empresa)
    {
        $perfil = json_decode($this->my_session->perfil, true);

        if (!is_array($modulos)) {
            $modulos = [$modulos];
        }

        if (!is_array($empresa)) {
            $empresa = [$empresa];
        }

        if (in_array(EMPRESA, $empresa) || in_array('all', $empresa)) {
            foreach ($modulos as $modulo) {
                if (in_array($modulo, $perfil)) {
                    return true;
                }
            }
        }

        return false;
    }



    public function buscarUsuarios($search)
    {
        if ($search == "WORK") {
            $sql = "SELECT * from user_account where status='ATIVO' order by nickname LIMIT 30;";
        } else {
            $sql = "SELECT * from user_account where status='ATIVO' AND nickname like '%$search%' order by nickname LIMIT 30;";
        }

        return $this->dbMasterDefault->runQuery($sql);
    }

    public function buscarUsuario($filters)
    {
        return $this->dbMasterDefault->select('user_account', $filters);
    }

    public function cadastrarUsuario($dados)
    {
        return $this->dbMasterDefault->insert('user_account', $dados);
    }
}
