<?php

namespace App\Controllers\Seguranca;

use App\Controllers\BaseController;
use App\Libraries\dbMaster;
use Config\Services;

class Mainling extends BaseController
{
    public function index()
    {
        $dados['pageTitle'] = 'Mainling';

        return $this->loadpage('seguranca/mainling', $dados);
    }
}