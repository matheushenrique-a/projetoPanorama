<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_seguranca extends Model {

    function auth($email, $password){        
        $email = trim($email);
        $password = trim($password);
        
        // $sql = "select * from user_account u left join user_wallets w on u.userId = w.userId
        //         where w.default_wallet = 1 
        //         and email='$email' AND password='$password' AND email!= '' AND password!=''";
        // $query = $this->db->query($sql);
        
        // if ($query->num_rows()==0) {
        //     return false;
        // } else {
        //     $walletId = $query->row(0)->walletId;
            
        //     $userId = $query->row(0)->userId;
        //     $this->session->set_userdata('userId', $userId);
        //     $this->session->set_userdata('walletId',$walletId);
        //     $this->session->set_userdata('name',$query->row(0)->name);
        //     $this->session->set_userdata('nickname', $query->row(0)->nickname);
        //     $this->session->set_userdata('email', $query->row(0)->email);
        //     $this->session->set_userdata('publicKey', $query->row(0)->publicKey);
        //     $this->session->set_userdata('privateKey', $query->row(0)->privateKey);
        //     $this->session->set_userdata('passphrase', $query->row(0)->passphrase);
        //     $this->session->set_userdata('exchange', strtoupper($query->row(0)->exchange));
        //     $this->load->helper('cookie');
    
        //     set_cookie('beppig',$walletId,'13600'); 
        //     return true;
        // }

        return true;
    }

}


?>