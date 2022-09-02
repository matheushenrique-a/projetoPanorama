<?php 
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class M_seguranca extends Model {
    protected $dbMaster;
    protected $session;

    public function __construct()
        {
			$this->dbMaster = new dbMaster();
            $this->session = session();
        }

    function auth($email, $password){        
        $email = trim($email);
        $password = trim($password);

        $whereCheck = array('email' => $email, 'password' => $password);
        $login = $this->dbMaster->select('user_account', $whereCheck);
        
        if ($login['existRecord']) {
            $this->session->set('userId', $login['firstRow']->userId);
            $this->session->set('nickname', $login['firstRow']->nickname);
            $this->session->set('email', $login['firstRow']->email);
            return true;
        } else {
            return false;
        }
    }

}


?>