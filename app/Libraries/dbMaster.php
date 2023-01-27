<?php

namespace App\Libraries;

class dbMaster {
	protected $db;

	public function __construct($dbOption = null){

		//Quando for necessário conectar em um banco diferente do padrão
		//Recebe o parametro com o nome do profile no Config/Database.php
		if (is_null($dbOption)){
			$this->db = \Config\Database::connect();
		}else {
			$this->db = \Config\Database::connect($dbOption);
		}	
	}

	public function select($table, $whereCheck, $likeCheck = null)
	{
		$builder = $this->db->table($table);

		if (!is_null($likeCheck)){
			if (count($likeCheck) > 0){
				$builder->like($likeCheck);
			}
		}
		
		if (!is_null($whereCheck)) $builder->where($whereCheck);
		$builder->limit(100);
		//echo $builder->getCompiledSelect();
		$result = $builder->get();
		//echo "14:20:50 - <h3>Dump 21</h3> <br><br>" . var_dump($result->getResult()); exit;					//<-------DEBUG
		$returnData = array();
		$returnData["num_rows"] = count($result->getResult());
		$returnData["countAll"] = $this->db->table($table)->countAll();
		$returnData["existRecord"] = $returnData["num_rows"] > 0 ? true : false;
		$returnData["firstRow"] = isset($result->getResult()[0]) ? $result->getResult()[0] : null;
		$returnData["result"] = $result;

		return $returnData;
	}

	public function insert($table, $data)
	{
		$builder = $this->db->table($table);
		$builder->insert($data);
		$returnData["insert_id"] = $this->db->insertID();
		return $returnData;
	}

	public function update($table, $fieldUpdate, $whereArrayUpdt, $fielDynamicdUpdate = null)
	{
		$builder = $this->db->table($table);

		$builder->set($fieldUpdate);

		if (!empty($fielDynamicdUpdate)){
			foreach($fielDynamicdUpdate as $key=>$value)
			{
				$builder->set($key, $value, FALSE);
			}
		}

		$builder->where($whereArrayUpdt);
		//echo $builder->getCompiledUpdate();exit;
		$builder->update();

		$returnData["affected_rows"] = $this->db->affectedRows();
		$returnData["updated"] = $this->db->affectedRows() > 0 ? true : false;
		
		return $returnData;
	}	

	public function delete($table, $whereCheck)
	{
		$builder = $this->db->table($table);
		$builder->delete($whereCheck);
	}



	//Evita consulta a uma tabela que foi recenemente consultada
	public function IsDataUpdated($table, $whereArray = null){
		//default interval check
		$minutes = integration_delay_bancos[$table];
		//echo "13:18:37 - <h3>Dump 2</h3> <br><br>" . var_dump($table); exit;					//<-------DEBUG
		$md5 = $this->getMd5($table, $whereArray);

		$builder = $this->db->table('record_updates');
		$builder->limit(1);
		$builder->where(' TIMESTAMPDIFF(minute,last_updated,now())  <', $minutes);
		$builder->where('md5', $md5);
		$result = $builder->get();
		$total_rows = $this->db->affectedRows();
		
		//echo "13:17:40 - <h3>Dump 78</h3> <br><br>" . var_dump($total_rows); exit;					//<-------DEBUG 
		if ($total_rows==1){
			//se encontrou algum registro é porque existem linhas 
			//com menos de X minutos na tabela, logo o dado está atualizado / existente
			return true;
		}else {
			$this->UpdateControl($md5);
			return false;
		}
	}

	public function getDB()
	{
		return $this->db;
	}

	//Cria um identificador unico para um registro
	public function getMd5($table, $whereArray){
		$md5 = trim($table) . '|';
		
		if (!is_null($whereArray)) {
			if (count($whereArray)!=0) {
				$md5 .= implode("|",$whereArray). '|';
			}
		}
		return $md5;
	}
		
	public function UpdateControl($md5){
			$this->delete('record_updates', array('md5' => $md5));
			$data = array('md5' => $md5);
			$this->insert('record_updates', $data);

	}

	public function forceUpdate($table, $whereArray)
	{
		$md5 = $this->getMd5($table, $whereArray);
		$this->delete('record_updates', array('md5' => $md5));
	}	
}	