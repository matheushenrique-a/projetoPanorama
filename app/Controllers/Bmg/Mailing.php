<?php

namespace App\Controllers\Bmg;

use App\Controllers\BaseController;
use App\Libraries\dbMaster;
use Config\Services;

class Mailing extends BaseController
{
    public function index()
    {
        $dados['pageTitle'] = 'Mainling';

        return $this->loadpage('bmg/mailing', $dados);
    }
}