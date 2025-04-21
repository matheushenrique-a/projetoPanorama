<?php 
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class M_seguranca extends Model {
    protected $dbMaster;
    protected $my_session;

    public function __construct()
        {
			$this->dbMaster = new dbMaster();
            $this->my_session = session();
        }

    function auth($email, $password = ''){        
        $email = trim($email);
        $password = trim($password);

        if (empty($password)) {
            $whereCheck = array('email' => $email);
        } else {
            $whereCheck = array('email' => $email, 'password' => $password);
        }
 
        $login = $this->dbMaster->select('user_account', $whereCheck);
        
        if ($login['existRecord']) {
            $this->my_session->set('userId', $login['firstRow']->userId);
            $this->my_session->set('nickname', $login['firstRow']->nickname);
            $this->my_session->set('email', $login['firstRow']->email);
            $this->my_session->set('empresa', $login['firstRow']->empresa);
            $this->my_session->set('role', $login['firstRow']->role);
            $this->my_session->set('report_to', $login['firstRow']->report_to);
            $this->my_session->set('equipe', $login['firstRow']->equipe);
            $this->my_session->set('perfil', $login['firstRow']->perfil_acesso);
            $this->my_session->set('observacao', $login['firstRow']->observacao);
            $this->my_session->set('parameters', json_decode($login['firstRow']->parameters ?? "", true));
            
            helper('cookie');
            set_cookie('insight', $login['firstRow']->email, time()+60*60*24*7); //30 days 
            return true;
        } else {
            return false;
        }
    }

    public function DisplayMenu($modulo){
       $perfil = json_decode($this->my_session->perfil, true);
       
       echo (!in_array($modulo, $perfil)  ? 'display: none; visibility: hidden;' : 'display: block; visibility: visible;');
    }

}


?>