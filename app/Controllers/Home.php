<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $this->checkSession();
        $dados['pageTitle'] = "Simplificando sua vida financeira";
        return $this->loadpage('headers/home-default', $dados);
    }

}
