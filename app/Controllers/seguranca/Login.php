<?php

namespace App\Controllers\Seguranca;
use App\Controllers\BaseController;
use App\Models\M_seguranca;

class Login extends BaseController
{
    public function autenticar()
    {
        $email = $this->getpost('email');
        $password = $this->getpost('password');
        $btnSignin = $this->getpost('btnSignin');

        $dados['pageTitle'] = "Seja bem-vindo";
        $dados['email'] = $email;
        $dados['password'] = $password;

        $security = new M_seguranca();

        if (empty($email) or empty($password)){
            return $this->loadSinglePage('seguranca/login', $dados);
        } else if ($security->auth($email, $password)){
            return redirect()->to(urlInstitucional);
        } else {
            $dados['error'] = 'Usuário e senha inválidos.';
            return $this->loadSinglePage('seguranca/login', $dados);
        }
    
    }

}
