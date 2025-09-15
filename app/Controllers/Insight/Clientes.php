<?php

namespace App\Controllers\Insight;

use App\Models\M_insight;

class Clientes extends \App\Controllers\BaseController
{
    protected $m_insight;

    public function index()
    {
        $dados['pageTitle'] = 'Clientes';
        $dados['clientes'] = null;

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

                $tem_dado = false;
                foreach ($row as $campo) {
                    if (strlen($campo) > 0) {
                        $tem_dado = true;
                        break;
                    }
                }
                if (!$tem_dado) {
                    $linha++;
                    continue;
                }

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
                    'email'       => $row[19],
                    'telefone1'   => $row[20],
                    'telefone2'   => $row[21],
                    'telefone3'   => $row[22],
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

    public function pesquisa()
    {
        $this->m_insight = new M_insight();
        $dados['pageTitle'] = 'Pesquisa Clientes';

        $cpf = $this->getpost('cpf');

        if ($cpf) {
            $dados['clientes'] = $this->m_insight->pesquisarClientesPorCpf($cpf);
        }

        return $this->loadPage('clientes/client_list', $dados);
    }

    public function update()
    {
        $this->m_insight = new M_insight();
        $dados['pageTitle'] = 'Atualizar Clientes';

        $idClientes = $this->getpost('idClientes');
        $cpf        = $this->getpost('cpf');
        $nome       = $this->getpost('nome');
        $nasc       = $this->getpost('nasc');
        $especie    = $this->getpost('especie');
        $salario    = $this->getpost('salario');
        $sexo       = $this->getpost('sexo');
        $nome_banco = $this->getpost('nomeBanco');
        $dib        = $this->getpost('dib');
        $banco      = $this->getpost('banco');
        $agencia    = $this->getpost('agencia');
        $cc         = $this->getpost('conta');
        $meio_pgto  = $this->getpost('meioPgto');
        $cidade     = $this->getpost('cidade');
        $uf         = $this->getpost('uf');
        $endereco   = $this->getpost('endereco');
        $bairro     = $this->getpost('bairro');
        $cep        = $this->getpost('cep');
        $celular1   = $this->getpost('celular1');
        $celular2   = $this->getpost('celular2');

        $resultado = $this->m_insight->updateCliente($idClientes, [
            'cpf'        => $cpf,
            'nome'       => $nome,
            'nasc'       => $nasc,
            'especie'    => $especie,
            'salario'    => $salario,
            'sexo'       => $sexo,
            'nome_banco' => $nome_banco,
            'dib'        => $dib,
            'banco'      => $banco,
            'agencia'    => $agencia,
            'cc'         => $cc,
            'meio_pgto'  => $meio_pgto,
            'cidade'     => $cidade,
            'uf'         => $uf,
            'endereco'   => $endereco,
            'bairro'     => $bairro,
            'cep'        => $cep,
            'telefone1'  => $celular1,
            'telefone2'  => $celular2
        ]);

        if ($resultado) {
            return redirect()
                ->to(urlInstitucional . 'clientes')
                ->with('success', 'Cliente atualizado com sucesso.');
        } else {
            return redirect()
                ->to(urlInstitucional . 'clientes')
                ->with('error', 'Erro ao atualizar cliente.');
        }
    }

    public function criar()
    {
        $this->m_insight = new M_insight();
        $dados['pageTitle'] = 'Criar Clientes';

        $cpf        = $this->getpost('cpf');
        $nome       = $this->getpost('nome');
        $nasc       = $this->getpost('nasc');
        $especie    = $this->getpost('especie');
        $salario    = $this->getpost('salario');
        $sexo       = $this->getpost('sexo');
        $nome_banco = $this->getpost('nomeBanco');
        $dib        = $this->getpost('dib');
        $banco      = $this->getpost('banco');
        $agencia    = $this->getpost('agencia');
        $cc         = $this->getpost('conta');
        $meio_pgto  = $this->getpost('meioPgto');
        $cidade     = $this->getpost('cidade');
        $uf         = $this->getpost('uf');
        $endereco   = $this->getpost('endereco');
        $bairro     = $this->getpost('bairro');
        $cep        = $this->getpost('cep');
        $celular1   = $this->getpost('celular1');
        $celular2   = $this->getpost('celular2');

        $this->m_insight->criarCliente($data = [
            'cpf'        => $cpf,
            'nome'       => $nome,
            'nasc'       => $nasc,
            'especie'    => $especie,
            'salario'    => $salario,
            'sexo'       => $sexo,
            'nome_banco' => $nome_banco,
            'dib'        => $dib,
            'banco'      => $banco,
            'agencia'    => $agencia,
            'cc'         => $cc,
            'meio_pgto'  => $meio_pgto,
            'cidade'     => $cidade,
            'uf'         => $uf,
            'endereco'   => $endereco,
            'bairro'     => $bairro,
            'cep'        => $cep,
            'telefone1'  => $celular1,
            'telefone2'  => $celular2
        ]);

        return redirect()
            ->to(urlInstitucional . 'clientes')
            ->with('success', 'Cliente criado com sucesso.');
    }
}
