<?php

namespace App\Controllers\Bradesco;
use App\Controllers\BaseController;

class Bradesco extends BaseController
{
    public function index(){

        $dados['pageTitle'] = "Bradesco Receptivo";

        return $this->loadpage('bradesco/receptivo', $dados);
    }
    
}