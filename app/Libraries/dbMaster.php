<?php

namespace App\Libraries;

class dbMaster {
	protected $db;

	public function __construct(){
		//$this->db = db_connect();
		$this->db = \Config\Database::connect();
	}

	public function test(){
		echo "test"; exit;
	}

	public function select($table, $whereCheck, $likeCheck = null)
	{
		$builder = $this->db->table($table);

		if (!is_null($likeCheck)){
			if (count($likeCheck) > 0){
				$builder->like($likeCheck);
			}
		}
		
		$builder->where($whereCheck);
		$builder->limit(100);
		//echo $builder->getCompiledSelect(false);
		$result = $builder->get();
		$returnData = array();
		$returnData["num_rows"] = $this->db->affectedRows();
		$returnData["countAll"] = $this->db->table($table)->countAll();
		$returnData["existRecord"] = $this->db->affectedRows() > 0 ? true : false;
		$returnData["firstRow"] = isset($result->getResult()[0]) ? $result->getResult()[0] : null;
		$returnData["result"] = $result;

		return $returnData;
	}

	public function insert($table, $data)
	{
		$this->db->insert($table, $data);
		$returnData["insert_id"] = $this->db->insert_id();
		return $returnData;
	}

	public function update($table, $fieldUpdate, $whereArrayUpdt, $fielDynamicdUpdate = null)
	{
		$this->db->set($fieldUpdate);

		if (!empty($fielDynamicdUpdate)){
			foreach($fielDynamicdUpdate as $key=>$value)
			{
				$this->db->set($key, $value, FALSE);
			}
		}

		$this->db->where($whereArrayUpdt);
		//echo $this->db->get_compiled_update($table);exit;
		$this->db->update($table);

		$returnData["affected_rows"] = $this->db->affected_rows();
		$returnData["updated"] = $this->db->affected_rows() > 0 ? true : false;
		
		return $returnData;
	}	

	public function delete($table, $whereCheck)
	{
		$this->db->delete($table, $whereCheck);
	}

	//Evita consulta a uma tabela que foi recenemente consultada
	public function IsDataUpdated($table, $whereArray = null){
		//default interval check
		$minutes = integration_delay_bancos[$table];

		$md5 = $this->getMd5($table, $whereArray);

		$this->db->limit(1);
		$this->db->where(' TIMESTAMPDIFF(minute,last_updated,now())  <', $minutes);
		$this->db->where('md5', $md5);
		$total_rows = $this->db->get('record_updates')->num_rows();

		if ($total_rows==1){
			//se encontrou algum registro é porque existem linhas 
			//com menos de X minutos na tabela, logo o dado está atualizado / existente
			return true;
		}else {
			$this->UpdateControl($md5);
			return false;
		}
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
			$this->db->insert('record_updates', $data);

	}

	public function forceUpdate($table, $whereArray)
	{
		$md5 = $this->getMd5($table, $whereArray);
		$this->delete('record_updates', array('md5' => $md5));
	}	
}	