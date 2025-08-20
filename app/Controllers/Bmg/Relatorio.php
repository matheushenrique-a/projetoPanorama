<?php

namespace App\Controllers\Bmg;

use App\Controllers\BaseController;
use App\Models\M_bmg;

class Relatorio extends BaseController
{
    protected $m_bmg;

    public function index()
    {
        $dados['pageTitle'] = 'Relatório';

        return $this->loadpage('bmg/relatório', $dados);
    }

    public function envioRelatorio()
    {
        $this->m_bmg = new M_bmg();

        $login = BMG_SEGURO_LOGIN;
        $senha = BMG_SEGURO_SENHA;

        $dataInicial = $this->getpost('dataInicial');
        $dataFinal = $this->getpost('dataFinal');

        $dataInicialFix = new \DateTime($dataInicial);
        $dataFinalFix = new \DateTime($dataFinal);

        $loginConsig = BMG_SEGURO_LOGIN_CONSIG;
        $senhaConsig = BMG_SEGURO_SENHA_CONSIG;

        $dados = [
            'listaAdes' => '',
            'login' => $login,
            'senha' => $senha,
            'dataInicial' => $dataInicialFix->format('Y-m-d\T00:00:00'), 
            'dataFinal' => $dataFinalFix->format('Y-m-d\T23:59:59'),     
            'loginConsig' => $loginConsig,
            'senhaConsig' => $senhaConsig
        ];

        $envio = $this->m_bmg->envioRelatorioBmg($dados);

        $lista = $envio->listaStatus ?? [];

        if (empty($lista)) {
            return "Nenhum dado encontrado no período informado.";
        }

        $filename = 'relatorio_' . date('Ymd_His') . '.csv';
        $filepath = WRITEPATH . "exports/$filename";

        $file = fopen($filepath, 'w');
        
        fwrite($file, "\xEF\xBB\xBF");

        $primeiro = (array) $lista[0];
        fputcsv($file, array_keys($primeiro), ";");

        foreach ($lista as $item) {
            fputcsv($file, (array) $item, ";");
        }

        fclose($file);

        return $this->response->download($filepath, null)->setFileName($filename);
    }
}
