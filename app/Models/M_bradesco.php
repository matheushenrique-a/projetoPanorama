<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;
use Symfony\Component\Panther\Client;

class M_bradesco extends Model {
    protected $dbMasterDefault;
    protected $session;
    protected $telegram;
    protected $m_http;

    public function __construct(){
		$this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->m_http =  new M_http();
    }


    public function salvarDados($params) {


        // $xxxx = $this->dbMasterDefault->select('cliente', ['id' => 123]);
        // if ($xxxx['existRecord']){
        //     $xxxx['firstRow']->id_user;
        // }

        // $added = $this->dbMasterDefault->insert('cliente',['nome' => 'victor', 'idade' => 23]);
        // if ($added["insert_id"] > 0) {
        //     echo "Sucesso";
        // }
        // $data = []; // Replace with actual data fetching logic
        // return $data;
    }
    

}


?>