<?php

namespace App\Controllers\DataLake;
use App\Controllers\BaseController;

class DataLake extends BaseController
{
    public function buscarCliente()
    {
        $cpf = $this->getpost('txtCPF');
        $cidade = $this->getpost('txtCidade');
        $nome = $this->getpost('txtNome');
        $estado = $this->getpost('estado');
        $matricula = $this->getpost('txtMatricula');
        $sexo = $this->getpost('sexo');

        $btnExport = $this->getpost('btnExport');

        $whereCheck = [];
        $likeCheck = [];
        if (!empty($cpf)) $whereCheck['cpf'] = $cpf;
        if (!empty($cidade)) $whereCheck['cidade'] = $cidade;
        if (!empty($nome)) $likeCheck['nome'] = $nome;
        if (!empty($estado)) $whereCheck['uf_residencia'] = $estado;
        if (!empty($matricula)) $whereCheck['matricula'] = $matricula;
        if (!empty($sexo)) $whereCheck['sexo'] = $sexo;

        //echo "21:08:31 - <h3>Dump 19</h3> <br><br>" . var_dump($whereCheck); exit;					//<-------DEBUG

        $clientes = $this->dbMaster->select('dw_clientes', $whereCheck, $likeCheck);
        
        
        $dados['pageTitle'] = "DataLake - Buscar CPF";
        $dados['clientes'] = $clientes;
        $dados['cpf'] = $cpf;
        $dados['cidade'] = $cidade;
        $dados['nome'] = $nome;
        $dados['estado'] = $estado;
        $dados['matricula'] = $matricula;
        $dados['sexo'] = $sexo;

        
        if (!empty($btnExport)){
            $this->exportCSV2($clientes['result']->getResultArray());
        } else {
            return $this->loadpage('datalake/buscar', $dados);
        }
    }

    function exportCSV($array, $filename = "export.csv", $delimiter=";") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://memory', 'w');
        // loop over the input array
        foreach ($array as $line) { 
            fputcsv($f, $line, $delimiter); 
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: text/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
        exit;
    }

    function exportCSV2( $array, $filename = "export-data.csv", $delimiter=";" ){
        header( 'Content-Type: application/csv' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '";' );

        // clean output buffer
        ob_end_clean();
        
        $handle = fopen( 'php://output', 'w' );

        // use keys as column titles
        fputcsv( $handle, array_keys( $array['0'] ), $delimiter );

        foreach ( $array as $value ) {
            fputcsv( $handle, $value, $delimiter );
        }

        fclose( $handle );

        // flush buffer
        ob_flush();
        
        // use exit to get rid of unexpected output afterward
        exit();
    }
    

}
