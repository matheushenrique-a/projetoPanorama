<?php

namespace App\Controllers\Insight;

use App\Models\M_insight;

class Clientes extends \App\Controllers\BaseController
{

    protected $m_insight;

    public function index()
    {
        $dados['pageTitle'] = 'Clientes';

        return $this->loadPage('clientes/client_list', $dados);
    }

    public function upload($action)
    {
        $dados['pageTitle'] = 'Upload Clientes';

        if ($action == "Add") {
            $arquivo = $this->request->getFile('arquivo');

            if ($arquivo->getError() != 0) {
                return "Nenhum arquivo foi enviado.";
            }

            if (!$arquivo->isValid()) {
                return "Erro no upload: " . $arquivo->getErrorString();
            }

            $caminho = WRITEPATH . 'uploads/' . $arquivo->getRandomName();
            $arquivo->move(WRITEPATH . 'uploads', basename($caminho));

            // Processar o CSV em lotes
            $this->lerCSVemLotes($caminho, 500); // 500 registros por vez
        }

        return $this->loadPage('clientes/client_upload', $dados);
    }

    private function lerCSVemLotes($caminho, $tamanhoLote = 500)
    {
        $this->m_insight = new M_insight();

        if (($handle = fopen($caminho, 'r')) !== false) {
            $linha = 0;
            $lote = [];

            while (($row = fgetcsv($handle, 0, ";")) !== false) {
                
                if ($linha == 0) {
                    $linha++;
                    continue;
                }

                foreach ($row as &$campo) {
                    $campo = mb_convert_encoding($campo, 'UTF-8', 'ISO-8859-1, Windows-1252, UTF-8');
                    $campo = trim($campo);
                }
                unset($campo);

                $lote[] = [
                    'nb'          => $row[0],
                    'nome'        => $row[1],
                    'nasc'        => $row[2],
                    'cpf'         => $row[3],
                    'especie'     => $row[4],
                    'salario'     => $row[5],
                    'sexo'        => $row[6],
                    'margem'      => $row[7],
                    'nome_banco'  => $row[8],
                    'dib'         => $row[9],
                    'banco'       => $row[10],
                    'agencia'     => $row[11],
                    'cc'          => $row[12],
                    'meio_pgto'   => $row[13],
                    'cidade'      => $row[14],
                    'uf'          => $row[15],
                    'endereco'    => $row[16],
                    'bairro'      => $row[17],
                    'cep'         => $row[18],
                    'email'       => null,
                    'telefone1'   => null,
                    'telefone2'   => null,
                    'telefone3'   => null,
                    'telefone4'   => null,
                    'telefone5'   => null,
                    'telefone6'   => null,
                    'telefone7'   => null,
                    'telefone8'   => null,
                    'telefone9'   => null,
                    'telefone10'  => null
                ];

                if (count($lote) >= $tamanhoLote) {
                    $this->m_insight->importarClientesEmMassa($lote);
                    $lote = [];
                }

                $linha++;
            }

            if (!empty($lote)) {
                $this->m_insight->importarClientesEmMassa($lote);
            }

            fclose($handle);
        }
    }
}
