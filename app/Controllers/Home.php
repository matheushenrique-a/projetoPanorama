<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $dados['pageTitle'] = "Simplificando sua vida financeira";
        return $this->loadpage('headers/home-default', $dados);
    }

}
