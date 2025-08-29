<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_http;

class M_argus extends Model
{
    protected $dbMasterDefault;
    protected $telegram;
    protected $session;
    protected $m_http;

    public function __construct()
    {
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->m_http =  new M_http();
    }

    public function ultimaLigacao($parms)
    {
        $campo = array_key_first($parms);
        $valor = $parms[$campo];

        $sqlQuery = "SELECT * FROM aaspa_cliente where $campo = '$valor' ORDER BY data_criacao DESC LIMIT 1;";
        $cliente = $this->dbMasterDefault->runQuery($sqlQuery);

        return $cliente;
    }

    public function buscarClienteCRM($search)
    {
        $searchNumber = numberOnly($search);

        if ($search == "CRM") {
            $sql = "select * from aaspa_cliente order by data_criacao DESC LIMIT 30;";
        } else {
            $sql = "select * from aaspa_cliente where nome like '%$search%' ";

            if (!empty($searchNumber)) {
                $sql .= " or (celular like '%$searchNumber%' or cpf like '%$searchNumber%')";
            }
            $sql .= " order by data_criacao DESC LIMIT 30;";
        }

        return $this->dbMasterDefault->runQuery($sql);
    }

    public function ultimasLigacoes($limit = 6)
    {
        $sql = "select * from aaspa_cliente where assessor = '" . $this->session->nickname . "' ";
        $sql .= " order by data_criacao DESC LIMIT $limit;";
        return $this->dbMasterDefault->runQuery($sql);
    }

    public function countLigacoes()
    {
        $sql = "select count(*) from aaspa_cliente where assessor = '" . $this->session->nickname . "' ";
        $sql .= " AND DATE(data_criacao) = CURDATE();";
        return $this->dbMasterDefault->runQuery($sql)['countAll'];
    }

    public function buscarCliente($filters)
    {
        return $this->dbMasterDefault->select('aaspa_cliente', $filters);
    }

    public function tabulacoesSucesso()
    {
        $sql = "select count(*) AS total from argus_tabulacao where assessor = '" . $this->session->nickname . "' ";
        $sql .= "and dataInicioLigacao >= CURDATE() AND idTabulacao = 13;";

        $result = $this->dbMasterDefault->runQuery($sql);
        if (isset($result['firstRow']->total)) {
            return (int) $result['firstRow']->total;
        }

        return 0;
    }
}
