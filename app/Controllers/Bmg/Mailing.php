<?php

namespace App\Controllers\Bmg;

use App\Controllers\BaseController;
use App\Models\M_bmg;

class Mailing extends BaseController
{
    protected $m_bmg;

    public function index()
    {
        $dados['pageTitle'] = 'Mainling';

        return $this->loadpage('bmg/mailing', $dados);
    }

    public function generate()
    {
        $this->m_bmg = new M_bmg();

        $produto = $this->getpost('produto');
        $valorMinimo = $this->getpost('valorMinimo') ?? "";
        $valorMaximo = $this->getpost('valorMaximo') ?? "";
        $entidade = $this->getpost('entidade');

        $file = $this->request->getFile('file');

        if (!$file->isValid()) {
            return $this->response->setJSON(['erro' => 'Arquivo inválido']);
        }

        $tempPath = $file->getTempName();

        $handle = fopen($tempPath, 'r');
        if (!$handle) {
            return $this->response->setJSON(['erro' => 'Erro ao ler o arquivo']);
        }

        $cpfs = [];

        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            $cpf = trim($data[0] ?? '');
            if (!empty($cpf) && strtolower($cpf) !== 'cpf') {
                $cpfs[] = $cpf;
            }
        }

        fclose($handle);

        $dados = [
            'produto' => $produto,
            'valorMinimo' => $valorMinimo,
            'valorMaximo' => $valorMaximo,
            'entidade' => $entidade,
            'cpfs' => $cpfs
        ];

        if ($produto == "seguro") {
            return print_r($this->m_bmg->gerarMailingSeguro($dados));
        }

        if ($produto == "saque") {
            return $this->m_bmg->gerarMailingSaque($dados);
        }

        return $this->response->setJSON(['erro' => 'Produto inválido']);
    }
}
