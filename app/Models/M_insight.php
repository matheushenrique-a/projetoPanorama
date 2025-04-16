<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;
use Symfony\Component\Panther\Client;

class M_insight extends Model {
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

    public function load_notifications(){
        $userId = $this->session->userId;
        $role = $this->session->role;
        $notificacoes = null;

        if ($role == "OPERADOR") {
            $sqlQuery = 'SELECT * from insight_notificacoes where userId = ' . $userId .  ' or 1=1 and notifica_user = TRUE order by id DESC LIMIT 7;';
            $notificacoes = $this->dbMasterDefault->runQuery($sqlQuery);		
        } else if ($role == "SUPERVISOR") {
            $notificacoes = $this->dbMasterDefault->select('insight_notificacoes', ['notifica_supervisor' => true]);
        } else if ($role == "GERENTE") {
            $notificacoes = $this->dbMasterDefault->select('insight_notificacoes', ['notifica_manager' => true]);
        }
        return $notificacoes;
	}


    
}


?>