<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;
use Symfony\Component\Panther\Client;

class M_argus extends Model {
    protected $dbMasterDefault;
    protected $my_session;
    protected $telegram;
    protected $m_http;

    public function __construct(){
		$this->dbMasterDefault = new dbMaster();
        $this->my_session = session();
        $this->telegram =  new M_telegram();
        $this->m_http =  new M_http();
    }

    public function ultimaLigacao($parms){
        $campo = array_key_first($parms);
        $valor = $parms[$campo];
        
        $sqlQuery = "SELECT * FROM aaspa_cliente where $campo = '$valor' ORDER BY data_criacao DESC LIMIT 1;";		
        $cliente = $this->dbMasterDefault->runQuery($sqlQuery);

        return $cliente;
    }

}
