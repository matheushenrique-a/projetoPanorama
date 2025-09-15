<?php

namespace App\Libraries;

class dbMaster
{
	protected $db;
	protected $limit = null;
	protected $offset = null;
	protected $orderby = null;

	public function setOrderBy($value)
	{
		$this->orderby = $value;
	}
	public function getOrderBy()
	{
		return $this->orderby;
	}

	public function setLimit($value)
	{
		$this->limit = $value;
	}
	public function getLimit()
	{
		return $this->limit;
	}

	public function __construct($dbOption = null)
	{

		//Quando for necessário conectar em um banco diferente do padrão
		//Recebe o parametro com o nome do profile no Config/Database.php
		if (is_null($dbOption)) {
			$this->db = \Config\Database::connect();
		} else {
			$this->db = \Config\Database::connect($dbOption);
		}
	}

	public function listarNotificacoes($userId)
	{
		$builder = $this->db->table('quid_notificacoes');
		$builder->where('userId', $userId);
		$builder->orderBy('created_at', 'DESC');
		$query = $builder->get();

		return $query->getResult();
	}

	public function listarProdutos()
	{
		return $this->db->table('quid_produtos')
			->where('ativo', 1)
			->get()
			->getResult();
	}

	public function select($table, $whereCheck, $parameters = null)
	{
		$builder = $this->db->table($table);

		if (!is_null($this->orderby)) {
			$builder->orderBy($this->orderby[0], $this->orderby[1]);
		}

		if (!is_null($parameters)) {
			if (array_key_exists('whereNotIn', $parameters)) {
				$builder->whereNotIn($parameters['whereNotIn'][0], $parameters['whereNotIn'][1]);
			}
			if (array_key_exists('likeCheck', $parameters)) {
				//$builder->like($parameters['likeCheck'][0], $parameters['likeCheck'][1]);
				$builder->like($parameters['likeCheck']);
			}
			if (array_key_exists('whereIn', $parameters)) {
				$builder->whereIn($parameters['whereIn'][0], $parameters['whereIn'][1]);
			}

			if (array_key_exists('betweenCheck', $parameters)) {
				$campo = $parameters['betweenCheck'][0];
				$de = $parameters['betweenCheck'][1];
				$ate = $parameters['betweenCheck'][2];

				if (!empty($de)) {
					$builder->where($campo . ' >=', $de);
				}
				if (!empty($ate)) {
					$builder->where($campo . ' <=', $ate . ' 23:59:59');
				}
			}
		}

		if (!is_null($whereCheck)) $builder->where($whereCheck);
		$builder->limit($this->limit);
		return $this->resultfy($builder->get());
	}

	public function selectAll($table, $whereCheck = null, $parameters = null)
	{
		$builder = $this->db->table($table);

		if (!is_null($this->orderby)) {
			$builder->orderBy($this->orderby[0], $this->orderby[1]);
		}

		if (!is_null($parameters)) {
			if (array_key_exists('whereNotIn', $parameters)) {
				$builder->whereNotIn($parameters['whereNotIn'][0], $parameters['whereNotIn'][1]);
			}
			if (array_key_exists('likeCheck', $parameters)) {
				$builder->like($parameters['likeCheck']);
			}
			if (array_key_exists('whereIn', $parameters)) {
				$builder->whereIn($parameters['whereIn'][0], $parameters['whereIn'][1]);
			}
			if (array_key_exists('betweenCheck', $parameters)) {
				$campo = $parameters['betweenCheck'][0];
				$de = $parameters['betweenCheck'][1];
				$ate = $parameters['betweenCheck'][2];

				if (!empty($de)) {
					$builder->where($campo . ' >=', $de);
				}
				if (!empty($ate)) {
					$builder->where($campo . ' <=', $ate . ' 23:59:59');
				}
			}
		}

		if (!is_null($whereCheck)) {
			$builder->where($whereCheck);
		}

		// executa sem limitar
		$query = $builder->get();

		// retorna todos os registros como array de objetos
		return $query->getResult(); // ou getResultArray() se preferir arrays
	}


	public function selectPage($table, $whereCheck, $parameters = null)
	{
		$builder = $this->db->table($table);

		if (!is_null($this->orderby)) {
			$builder->orderBy($this->orderby[0], $this->orderby[1]);
		}

		if (!is_null($parameters)) {
			if (array_key_exists('whereNotIn', $parameters)) {
				$builder->whereNotIn($parameters['whereNotIn'][0], $parameters['whereNotIn'][1]);
			}
			if (array_key_exists('likeCheck', $parameters)) {
				$builder->like($parameters['likeCheck']);
			}
			if (array_key_exists('whereIn', $parameters)) {
				$builder->whereIn($parameters['whereIn'][0], $parameters['whereIn'][1]);
			}
		}

		if (!is_null($whereCheck)) {
			$builder->where($whereCheck);
		}

		if (!is_null($this->limit)) {
			$builder->limit($this->limit, $this->offset ?? 0);
		}

		return $this->resultfy($builder->get());
	}

	public function setLimitPage($limit, $offset = 0)
	{
		$this->limit  = $limit;
		$this->offset = $offset;
	}

	public function countOnly($table, $where = [], $parametros = [])
	{
		$builder = $this->db->table($table);

		if (!empty($where)) {
			$builder->where($where);
		}

		if (!empty($parametros['likeCheck'])) {
			foreach ($parametros['likeCheck'] as $campo => $valor) {
				$builder->like($campo, $valor);
			}
		}

		return $builder->countAllResults();
	}


	public function selectArquivos($id)
	{
		return $this->db->table('arquivos')
			->where('id_proposta', $id)
			->get()
			->getResult();
	}

	public function downloadArquivos($id)
	{
		return $this->db->table('arquivos')
			->where('id', $id)
			->get()
			->getRow();
	}

	public function buscarInfoMetas()
	{
		return $this->db
			->table('equipes')
			->select('idequipes, nome, supervisor, meta, meta_mensal, ativo')
			->get()
			->getResult();
	}

	public function selectExact($table, $whereCheck, $parameters = null)
	{
		$builder = $this->db->table($table);

		if (!is_null($this->orderby)) {
			$builder->orderBy($this->orderby[0], $this->orderby[1]);
		}

		if (!is_null($parameters)) {
			if (array_key_exists('whereNotIn', $parameters)) {
				$builder->whereNotIn($parameters['whereNotIn'][0], $parameters['whereNotIn'][1]);
			}
			if (array_key_exists('whereIn', $parameters)) {
				$builder->whereIn($parameters['whereIn'][0], $parameters['whereIn'][1]);
			}
		}

		if (!is_null($whereCheck)) {
			foreach ($whereCheck as $campo => $valor) {
				$builder->where($campo, $valor);
			}
		}

		$builder->limit($this->limit);

		return $this->resultfy($builder->get());
	}


	public function resultfy($result)
	{
		//echo '22:52:20 - <h3>Dump 33 da variável $this->db </h3> <br><br>' . var_dump($this->db); exit;					//<-------DEBUG
		$returnData = array();
		$returnData["num_rows"] = count($result->getResult());
		//$returnData["countAll"] = $this->db->table($table)->countAll();
		$returnData["countAll"] = $returnData["num_rows"];
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

	public function insertAndGetId($table, $data)
	{
		$builder = $this->db->table($table);

		$builder->insert($data);

		return $this->db->insertID();
	}


	public function insertIgnore($table, $data)
	{
		$builder = $this->db->table($table);
		$builder->ignore(true)->insert($data);

		$returnData = [];
		$returnData["insert_id"] = $this->db->insertID();
		$returnData["affected_rows"] = $this->db->affectedRows();

		return $returnData;
	}


	public function insertBatch($table, array $data)
	{
		if (empty($data)) {
			return false;
		}

		$builder = $this->db->table($table);
		$builder->insertBatch($data);

		return [
			'rowsInserted' => $this->db->affectedRows()
		];
	}


	public function update($table, $fieldUpdate, $whereArrayUpdt, $fielDynamicdUpdate = null)
	{
		$builder = $this->db->table($table);

		$builder->set($fieldUpdate);

		if (!empty($fielDynamicdUpdate)) {
			foreach ($fielDynamicdUpdate as $key => $value) {
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

	public function getDB()
	{
		return $this->db;
	}

	//Cria um identificador unico para um registro
	public function getMd5($table, $whereArray)
	{
		$md5 = trim($table) . '|';

		if (!is_null($whereArray)) {
			if (count($whereArray) != 0) {
				$md5 .= implode("|", $whereArray) . '|';
			}
		}
		return $md5;
	}

	public function UpdateControl($md5)
	{
		$this->delete('record_updates', array('md5' => $md5));
		$data = array('md5' => $md5);
		$this->insert('record_updates', $data);
	}

	public function runQuery($sql)
	{
		$builder = $this->db->query($sql);
		return $this->resultfy($builder);
	}

	public function runQueryGeneric($sql)
	{
		$builder = $this->db->query($sql);
		return $builder;
	}

	public function forceUpdate($table, $whereArray)
	{
		$md5 = $this->getMd5($table, $whereArray);
		$this->delete('record_updates', array('md5' => $md5));
	}

	public function exportCSV($table, $columns = [], $where = [])
	{
		if (empty($columns)) {
			$columns = ['*'];
		}

		$builder = $this->db->table($table);
		$builder->select($columns);

		if (!empty($where)) {
			$builder->where($where);
		}

		$query = $builder->get();
		$results = $query->getResultArray();

		if (empty($results)) {
			echo "Nenhum registro encontrado.";
			exit;
		}

		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename="export.csv"');

		echo "\xEF\xBB\xBF";

		$fp = fopen('php://output', 'w');

		$separator = ';';

		fputcsv($fp, array_keys($results[0]), $separator);

		foreach ($results as $row) {
			foreach ($row as $k => $v) {
				if ($v === null) $row[$k] = '';
			}
			fputcsv($fp, $row, $separator);
		}

		fclose($fp);
		exit;
	}
}
