<?php

namespace App\Controllers\DataLake;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class DataLake extends BaseController
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::initController($request, $response, $logger);
        
        //$this->checkSession();
    }

    public function vanguard_decript($cpf){
        $cpf = str_replace("c", "", $cpf);
        $cpf = str_replace("*", "", $cpf);
        $cpf = str_replace("G", "0", $cpf);
        $cpf = str_replace("J", "1", $cpf);
        $cpf = str_replace("D", "2", $cpf);
        $cpf = str_replace("W", "3", $cpf);
        $cpf = str_replace("Z", "4", $cpf);
        $cpf = str_replace("S", "5", $cpf);
        $cpf = str_replace("T", "6", $cpf);
        $cpf = str_replace("O", "7", $cpf);
        $cpf = str_replace("H", "8", $cpf);
        $cpf = str_replace("C", "9", $cpf);

        //echo "14:16:35 - <h3>Dump 58</h3> <br><br>" . var_dump($cpf); exit;					//<-------DEBUG
        return $cpf;

    }

    public function vanguardDecode(){
        $dados['pageTitle'] = "MegaBase - Vanguard Decode";
        $cpf = $this->getpost('txtCpfs');
        
        $dados['cpf'] = $cpf;
        $dados['cpfDecode'] = $this->vanguard_decript($cpf);
        return $this->loadpage('datalake/vanguard', $dados);
    }

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
        if (!empty($estado)) $whereCheck['uf'] = $estado;
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
    
    public function load_INSS_Batch(){
        $inifile = 46;
        $endfile = 48;

        for ($i = $inifile; $i <= $endfile; $i++) {
            $this->load_INSS("inss$i.csv");
        }
    }


    public function load_INSS($filename = '')
	{
        set_time_limit(7200);
        $descricao = "Importação INSS Maciça";
		$filename = '/Users/dantas/imports/'.$filename;

        $fields = array(
            'categoria_convenio' => 'INSS',
            'cpf' => 1,
            'matricula' => 0,
            'nome' => 2,
            'sexo' => 23,
            'data_nascimento' => 3,
            'email' => null,
            'especie' => 4,
            'salario' => 39,
            'inicio_beneficio' => null,
            'banco_recebimento' => 7,
            'banco_emprestimo' => 24,
            'meio_pagamento' => 12,
            'tipo_emprestimo' => 30,
            'cidade' => 15,
            'uf' => 16,
            'telelefone_01' => 47,
            'telelefone_02' => 48,
            'telelefone_03' => 49,
            'telelefone_04' => 50,
            'telelefone_hot_01' => 52,
            'telelefone_hot_02' => 54,
            'telelefone_hot_03' => 55,
            'telelefone_hot_04' => 56,
            'telelefone_hot_05' => 57,
        );

        $pars = array('title' => $descricao, 'start' => 0, 'finish' => 900000, 'fields' => $fields);
        $file = fopen($filename, "r");

        //Salva declaração da importação
        $data = array('descricao' => $pars['title'], 'filepath' => $filename);
		$id_importacao = $this->dbMaster->insert('dw_importacao', $data)["insert_id"];
		
		$count = 0;
		$countInseridos = 0;
		$countPulados = 0;
		$countExistentes = 0;
        $categoria_convenio = $pars['fields']['categoria_convenio'];
        
        $cpfAnterior = "";
        $startTime = time();
       
		//FILE LOOP
		while (($emapData = fgetcsv($file, 5000, ";")) !== FALSE)
		{
            //limita a carga aos registros iniciais e finais definidos
            //para a primeira linha salva o header do arquivo na tabela de importação para posterior uso com o campo raw
            if ($count==0){
                $whereArrayUpdt = array('id_importacao' => $id_importacao);
                $fieldUpdate = array('headers' => json_encode($emapData));
                $this->dbMaster->update('dw_importacao', $fieldUpdate, $whereArrayUpdt);
                $count++;
                continue;
			} else if($count<$pars['start']){
                $count++;
				continue;                                 
			} else if ($count>$pars['finish']){
				break;
			}
			
            
			$cpf = $emapData[$pars['fields']['cpf']];
			//$cpf = limparMascara($emapData[$pars['fields']['cpf']]);
			//echo $cpf;exit;

			if (is_numeric($cpf) and ($cpf != $cpfAnterior)){
                $cpfAnterior = $cpf;
                //Verifica se CPF já existe na base para o convênio
                //$whereCheck = array('cpf' => $cpf, 'categoria_convenio' => $categoria_convenio);
				//$result = $this->dbMaster->select('dw_clientes', $whereCheck);
                
                //if (!$result['existRecord']){
                if (1==1){
                    $matricula = $emapData[$pars['fields']['matricula']];
                    $nome = $emapData[$pars['fields']['nome']];
                    $sexo = is_null($pars['fields']['sexo']) ? null : $emapData[$pars['fields']['sexo']];
                    $data_nascimento = $emapData[$pars['fields']['data_nascimento']];
                    $email = is_null($pars['fields']['email']) ? null : $emapData[$pars['fields']['email']];
                    $especie = is_null($pars['fields']['especie']) ? null : $emapData[$pars['fields']['especie']];
                    $salario = is_null($pars['fields']['salario']) ? null : $emapData[$pars['fields']['salario']];
                    $inicio_beneficio = is_null($pars['fields']['inicio_beneficio']) ? null : $emapData[$pars['fields']['inicio_beneficio']];
                    $banco_recebimento = is_null($pars['fields']['banco_recebimento']) ? null : $emapData[$pars['fields']['banco_recebimento']];
                    $banco_emprestimo = is_null($pars['fields']['banco_emprestimo']) ? null : $emapData[$pars['fields']['banco_emprestimo']];
                    $meio_pagamento = is_null($pars['fields']['meio_pagamento']) ? null : $emapData[$pars['fields']['meio_pagamento']];
                    $tipo_emprestimo = is_null($pars['fields']['tipo_emprestimo']) ? null : $emapData[$pars['fields']['tipo_emprestimo']];
                    $cidade = is_null($pars['fields']['cidade']) ? null : $emapData[$pars['fields']['cidade']];
                    $uf = is_null($pars['fields']['uf']) ? null : $emapData[$pars['fields']['uf']];

                    //telefones e hots
                    $telelefone_01 = is_null($pars['fields']['telelefone_01']) ? null : $emapData[$pars['fields']['telelefone_01']];
                    $telelefone_02 = is_null($pars['fields']['telelefone_02']) ? null : $emapData[$pars['fields']['telelefone_02']];
                    $telelefone_03 = is_null($pars['fields']['telelefone_03']) ? null : $emapData[$pars['fields']['telelefone_03']];
                    $telelefone_04 = is_null($pars['fields']['telelefone_04']) ? null : $emapData[$pars['fields']['telelefone_04']];
                    $telelefone_hot_01 = is_null($pars['fields']['telelefone_hot_01']) ? null : $emapData[$pars['fields']['telelefone_hot_01']];
                    $telelefone_hot_02 = is_null($pars['fields']['telelefone_hot_02']) ? null : $emapData[$pars['fields']['telelefone_hot_02']];
                    $telelefone_hot_03 = is_null($pars['fields']['telelefone_hot_03']) ? null : $emapData[$pars['fields']['telelefone_hot_03']];
                    $telelefone_hot_04 = is_null($pars['fields']['telelefone_hot_04']) ? null : $emapData[$pars['fields']['telelefone_hot_04']];
                    $telelefone_hot_05 = is_null($pars['fields']['telelefone_hot_05']) ? null : $emapData[$pars['fields']['telelefone_hot_05']];
        
                    //persite o hot prioritariamente
                    $telelefone_01 = empty($telelefone_01) ? $telelefone_hot_01 : $telelefone_01;
                    $telelefone_02 = empty($telelefone_02) ? $telelefone_hot_02 : $telelefone_02;
                    $telelefone_03 = empty($telelefone_03) ? $telelefone_hot_03 : $telelefone_03;
                    $telelefone_04 = empty($telelefone_04) ? $telelefone_hot_04 : $telelefone_04;

                    $data = array(  
                                    'id_importacao' => $id_importacao,
                                    'categoria_convenio' => $categoria_convenio,
                                    'cpf' => $cpf,
                                    'matricula' => $matricula,
                                    'nome' => $nome,
                                    'sexo' => $sexo,
                                    'data_nascimento' => dataPtUsYY($data_nascimento),
                                    'email' => $email,
                                    'especie' => $especie,
                                    'salario' => currencyPt($salario),
                                    'inicio_beneficio' => $inicio_beneficio,
                                    'banco_recebimento' => $banco_recebimento,
                                    'banco_emprestimo' => $banco_emprestimo,
                                    'meio_pagamento' => $meio_pagamento,
                                    'tipo_emprestimo' => $tipo_emprestimo,
                                    'cidade' => $cidade,
                                    'uf' => $uf,
                                    'telelefone_01' => $telelefone_01,
                                    'telelefone_02' => $telelefone_02,
                                    'telelefone_03' => $telelefone_03,
                                    'telelefone_04' => $telelefone_04,
                                    'telelefone_05' => $telelefone_hot_05,
                                    'raw' => json_encode($emapData)
                                );

                    $this->dbMaster->insert('dw_clientes_staging', $data);
                    $countInseridos++;
                    //echo "11:02:52 - <h3>Dump 67</h3> <br><br>" . var_dump($data); exit;					//<-------DEBUG
				} else {
                    $countExistentes++;
                }
			} else {
                $countPulados++;
            }
			$count++;      
		} 
        fclose($file);
        $endTime = (time() - $startTime) / 60 % 60;
        echo "<br><h1> Importação concluída! </h1><br>
        <h2>
            - ID Importacao: $id_importacao <br>
            - Total registros: $count <br>
            - Total inseridos: $countInseridos <br>
            - Total não numéricos ou sequenciais: $countPulados <br>
            - Total já existente na base: $countExistentes<br>
            - Tempo processamento: $endTime minutos <br>
            - File name: $filename 
        </h2>";
	}

    public function load_INSS_PROD()
	{
        set_time_limit(7200);
        $descricao = "Importação INSS Maciça";
		$filename = '/Users/dantas/imports/inss2.csv';

        $fields = array(
            'categoria_convenio' => 'INSS',
            'cpf' => 1,
            'matricula' => 0,
            'nome' => 2,
            'sexo' => 23,
            'data_nascimento' => 3,
            'email' => null,
            'especie' => 4,
            'salario' => 39,
            'inicio_beneficio' => null,
            'banco_recebimento' => 7,
            'banco_emprestimo' => 24,
            'meio_pagamento' => 12,
            'tipo_emprestimo' => 30,
            'cidade' => 15,
            'uf' => 16,
            'telelefone_01' => 47,
            'telelefone_02' => 48,
            'telelefone_03' => 49,
            'telelefone_04' => 50,
            'telelefone_hot_01' => 52,
            'telelefone_hot_02' => 54,
            'telelefone_hot_03' => 55,
            'telelefone_hot_04' => 56,
            'telelefone_hot_05' => 57,
        );

        $pars = array('title' => $descricao, 'start' => 100000, 'finish' => 150000, 'fields' => $fields);
        $file = fopen($filename, "r");

        //Salva declaração da importação
        $data = array('descricao' => $pars['title'], 'filepath' => $filename);
		$id_importacao = $this->dbMaster->insert('dw_importacao', $data)["insert_id"];
		
		$count = 0;
		$countInseridos = 0;
		$countPulados = 0;
		$countExistentes = 0;
        $categoria_convenio = $pars['fields']['categoria_convenio'];
        
        $cpfAnterior = "";
        $startTime = time();
       
		//FILE LOOP
		while (($emapData = fgetcsv($file, 5000, ";")) !== FALSE)
		{
            //limita a carga aos registros iniciais e finais definidos
            //para a primeira linha salva o header do arquivo na tabela de importação para posterior uso com o campo raw
            if ($count==0){
                $whereArrayUpdt = array('id_importacao' => $id_importacao);
                $fieldUpdate = array('headers' => json_encode($emapData));
                $this->dbMaster->update('dw_importacao', $fieldUpdate, $whereArrayUpdt);
                $count++;
                continue;
			} else if($count<$pars['start']){
                $count++;
				continue;                                 
			} else if ($count>$pars['finish']){
				break;
			}
			
            
			$cpf = $emapData[$pars['fields']['cpf']];
			//$cpf = limparMascara($emapData[$pars['fields']['cpf']]);
			//echo $cpf;exit;

			if (is_numeric($cpf) and ($cpf != $cpfAnterior)){
                $cpfAnterior = $cpf;
                //Verifica se CPF já existe na base para o convênio
                $whereCheck = array('cpf' => $cpf, 'categoria_convenio' => $categoria_convenio);
				$result = $this->dbMaster->select('dw_clientes', $whereCheck);
                
                if (!$result['existRecord']){
                    $matricula = $emapData[$pars['fields']['matricula']];
                    $nome = $emapData[$pars['fields']['nome']];
                    $sexo = is_null($pars['fields']['sexo']) ? null : $emapData[$pars['fields']['sexo']];
                    $data_nascimento = $emapData[$pars['fields']['data_nascimento']];
                    $email = is_null($pars['fields']['email']) ? null : $emapData[$pars['fields']['email']];
                    $especie = is_null($pars['fields']['especie']) ? null : $emapData[$pars['fields']['especie']];
                    $salario = is_null($pars['fields']['salario']) ? null : $emapData[$pars['fields']['salario']];
                    $inicio_beneficio = is_null($pars['fields']['inicio_beneficio']) ? null : $emapData[$pars['fields']['inicio_beneficio']];
                    $banco_recebimento = is_null($pars['fields']['banco_recebimento']) ? null : $emapData[$pars['fields']['banco_recebimento']];
                    $banco_emprestimo = is_null($pars['fields']['banco_emprestimo']) ? null : $emapData[$pars['fields']['banco_emprestimo']];
                    $meio_pagamento = is_null($pars['fields']['meio_pagamento']) ? null : $emapData[$pars['fields']['meio_pagamento']];
                    $tipo_emprestimo = is_null($pars['fields']['tipo_emprestimo']) ? null : $emapData[$pars['fields']['tipo_emprestimo']];
                    $cidade = is_null($pars['fields']['cidade']) ? null : $emapData[$pars['fields']['cidade']];
                    $uf = is_null($pars['fields']['uf']) ? null : $emapData[$pars['fields']['uf']];

                    //telefones e hots
                    $telelefone_01 = is_null($pars['fields']['telelefone_01']) ? null : $emapData[$pars['fields']['telelefone_01']];
                    $telelefone_02 = is_null($pars['fields']['telelefone_02']) ? null : $emapData[$pars['fields']['telelefone_02']];
                    $telelefone_03 = is_null($pars['fields']['telelefone_03']) ? null : $emapData[$pars['fields']['telelefone_03']];
                    $telelefone_04 = is_null($pars['fields']['telelefone_04']) ? null : $emapData[$pars['fields']['telelefone_04']];
                    $telelefone_hot_01 = is_null($pars['fields']['telelefone_hot_01']) ? null : $emapData[$pars['fields']['telelefone_hot_01']];
                    $telelefone_hot_02 = is_null($pars['fields']['telelefone_hot_02']) ? null : $emapData[$pars['fields']['telelefone_hot_02']];
                    $telelefone_hot_03 = is_null($pars['fields']['telelefone_hot_03']) ? null : $emapData[$pars['fields']['telelefone_hot_03']];
                    $telelefone_hot_04 = is_null($pars['fields']['telelefone_hot_04']) ? null : $emapData[$pars['fields']['telelefone_hot_04']];
                    $telelefone_hot_05 = is_null($pars['fields']['telelefone_hot_05']) ? null : $emapData[$pars['fields']['telelefone_hot_05']];
        
                    //persite o hot prioritariamente
                    $telelefone_01 = empty($telelefone_01) ? $telelefone_hot_01 : $telelefone_01;
                    $telelefone_02 = empty($telelefone_02) ? $telelefone_hot_02 : $telelefone_02;
                    $telelefone_03 = empty($telelefone_03) ? $telelefone_hot_03 : $telelefone_03;
                    $telelefone_04 = empty($telelefone_04) ? $telelefone_hot_04 : $telelefone_04;

                    $data = array(  
                                    'id_importacao' => $id_importacao,
                                    'categoria_convenio' => $categoria_convenio,
                                    'cpf' => $cpf,
                                    'matricula' => $matricula,
                                    'nome' => $nome,
                                    'sexo' => $sexo,
                                    'data_nascimento' => dataPtUsYY($data_nascimento),
                                    'email' => $email,
                                    'especie' => $especie,
                                    'salario' => currencyPt($salario),
                                    'inicio_beneficio' => $inicio_beneficio,
                                    'banco_recebimento' => $banco_recebimento,
                                    'banco_emprestimo' => $banco_emprestimo,
                                    'meio_pagamento' => $meio_pagamento,
                                    'tipo_emprestimo' => $tipo_emprestimo,
                                    'cidade' => $cidade,
                                    'uf' => $uf,
                                    'telelefone_01' => $telelefone_01,
                                    'telelefone_02' => $telelefone_02,
                                    'telelefone_03' => $telelefone_03,
                                    'telelefone_04' => $telelefone_04,
                                    'telelefone_05' => $telelefone_hot_05,
                                    'raw' => json_encode($emapData)
                                );

                    $this->dbMaster->insert('dw_clientes', $data);
                    $countInseridos++;
                    //echo "11:02:52 - <h3>Dump 67</h3> <br><br>" . var_dump($data); exit;					//<-------DEBUG
				} else {
                    $countExistentes++;
                }
			} else {
                $countPulados++;
            }
			$count++;      
		} 
        fclose($file);
        $endTime = (time() - $startTime) / 60 % 60;
        echo "<h1> Importação concluída! </h1><br>
        <h2>
            - ID Importacao: $id_importacao <br>
            - Total registros: $count <br>
            - Total inseridos: $countInseridos <br>
            - Total não numéricos ou sequenciais: $countPulados <br>
            - Total já existente na base: $countExistentes<br>
            - Tempo processamento: $endTime minutos 
        </h2>";
	}   

	public function load_LOAS($filename, $pars)
	{		
        $descricao = "Importação BMG File 01";
		$filename = '/Users/dantas/imports/inss1.csv';
		$pos = array('pos'=> array(0, 1, 2, 4, 12, 13, 14, null));
      
		// $descricao = "Importação BMG File 04";
		// $filename = '/Users/dantas/imports/Pasta4.csv';
		// $pos = array('pos'=> array(0, 1, 2, 4, 23, 24, 25, 43)); 
				
		// $descricao = "Importação BMG File 03";
		// $filename = '/Users/dantas/imports/Pasta3.csv';
		// $pos = array('pos'=> array(0, 1, 2, 4, 12, 13, 14, null)); 

		// $descricao = "A base";
		// $filename = '/Users/dantas/imports/abase.csv';
		// $pos = array('pos'=> array(0, 1, 2, 4, null, null, null, null)); 

		// $descricao = "LOAS P1";
		// $filename = '/Users/dantas/imports/loasp1.csv';
		// $pos = array('pos'=> array(0, 1, 5, 7, null, 65, 64, null)); 

		// $descricao = "LOAS P2";
		// $filename = '/Users/dantas/imports/loasp2.csv';
		// $pos = array('pos'=> array(0, 1, 5, 7, null, 65, 64, null)); 

		// $descricao = "LOAS P3";
		// $filename = '/Users/dantas/imports/loasp3.csv';
		// $pos = array('pos'=> array(0, 1, 5, 7, null, 65, 64, null)); 

		// $descricao = "LOAS P4";
		// $filename = '/Users/dantas/imports/loasp4.csv';
		// $pos = array('pos'=> array(0, 1, 5, 7, null, 65, 64, null)); 

		// $descricao = "SMILE Geral";
		// $filename = '/Users/dantas/imports/smile.csv';
		// $pos = array('pos'=> array(1, 2, 11, 12, null, 8, 7, null)); 
		
		$basePars = array('title' => $descricao, 'start' => 0, 'finish' => 2);
		$pars = $basePars + $pos;
		$file = fopen($filename, "r");
		$data = array('descricao' => $pars['title'], 'filepath' => $filename);
		$id_importacao = $this->dbaccess->insert('dw_importacao', $data)["insert_id"];
		
		$count = 0;

		//FILE LOOP
		while (($emapData = fgetcsv($file, 5000, ";")) !== FALSE)
		{
			if($count<$pars['start']){
				continue;                                 // add this line
			} else if ($count>$pars['finish']){
				break;
			}
			
			$cpf = limparMascara($emapData[$pars['pos'][0]]);
			//echo $cpf;exit;
			if (is_numeric($cpf)){
				$nome = $emapData[$pars['pos'][1]];
				$data_nascimento = $emapData[$pars['pos'][2]];
				$matricula = $emapData[$pars['pos'][3]];
				$sexo = is_null($pars['pos'][4]) ? null : $emapData[$pars['pos'][4]];
				$uf = is_null($pars['pos'][5]) ? null : $emapData[$pars['pos'][5]];
				$cidade = is_null($pars['pos'][6]) ? null : $emapData[$pars['pos'][6]];
				$email = is_null($pars['pos'][7]) ? null : $emapData[$pars['pos'][7]];
	
				$data = array('cpf' => $cpf
							, 'nome' => $nome
							, 'id_importacao' => $id_importacao
							, 'data_nascimento' => dataPtUsYY($data_nascimento)
							, 'matricula' => $matricula
							, 'sexo' => $sexo
							, 'uf_residencia' => $uf
							, 'cidade' => $cidade
							, 'email' => $email
							);
				
				$whereCheck = array('cpf' => $cpf);
				$result = $this->dbaccess->select('dw_clientes', $whereCheck);
				$id_cliente = 0;

				if ($result['existRecord']){
					$id_cliente = $result['firstRow']->id_cliente;
				} else {
					$id_cliente = $this->dbaccess->insert('dw_clientes', $data)["insert_id"];
				}

				// if ($id_cliente!= 0){
				// 	$detalhes = array('cpf' => $cpf
				// 	, 'id_cliente' => $id_cliente
				// 	, 'id_importacao' => $id_importacao
				// 	, 'detalhes' => json_encode($emapData)
				// 	);

				// 	$this->dbaccess->insert('dw_clientes_detalhes', $detalhes);
				// }
			}

			$count++;      
		}
	}
}
