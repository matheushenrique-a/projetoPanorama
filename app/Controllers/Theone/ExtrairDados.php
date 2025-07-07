<?php

namespace App\Controllers\Theone;

use App\Controllers\BaseController;

class ExtrairDados extends BaseController
{
    public function extrair()
    {
        $dados['pageTitle'] = 'Extrair dados';

        return $this->loadPage('theone/extração' ,$dados);
    }
}