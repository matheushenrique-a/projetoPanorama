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

    function auth($email, $password){        
        $email = trim($email);
        $password = trim($password);
        $iam = new M_aws();

        $whereCheck = array('email' => $email, 'password' => $password);
        $login = $this->dbMaster->select('user_account', $whereCheck);
        
        if ($login['existRecord']) {
            $this->my_session->set('userId', $login['firstRow']->userId);
            $this->my_session->set('nickname', $login['firstRow']->nickname);
            $this->my_session->set('email', $login['firstRow']->email);
            //echo "22:02:26 - <h3>Dump 99</h3> <br><br>" . $this->session->session_id . "---". $this->session->nickname ; exit;					//<-------DEBUG
            return true;
        } else {
            return false;
        }
    }

}


?>