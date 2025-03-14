<?php 
//require_once 'aws/vendor/autoload.php';

namespace App\Models;
require 'aws/aws-autoloader.php';
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class M_aws extends Model {
    protected $dbMaster;
    protected $my_session;

    public function __construct()
        {
			$this->dbMaster = new dbMaster();
            $this->my_session = session();
        }

    function imagem_content($url, $type){
        //return ["match" => true, "labels" =>null];
        $client = new Aws\Rekognition\RekognitionClient (['version' => 'latest', 'region' => 'us-east-1', 'credentials' => ['key' => 'AKIAZDBFKEQJ7WKPZ2EV','secret' => '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',]]);

        //$file = "/Applications/XAMPP/xamppfiles/htdocs/aws/input.jpg";
        $result = $client->detectLabels (['Image' => ['Bytes' => file_get_contents ($url),],"MaxLabels" => 20, "MinConfidence" => 50,]);
        
        //echo '12:18:00 - <h3>Dump 57 </h3> <br><br>' . var_dump($result['Labels']); exit;					//<-------DEBUG
        $saida = [];
        foreach ($result['Labels'] as $key => $value) {
            if (strtolower($result['Labels'][$key]['Name']) == strtolower($type)){
                $saida = ["match" => true, "labels" => $result['Labels']];
                return $saida;
            }
            //echo $result['Labels'][$key]['Name'] . "--" . $result['Labels'][$key]['Confidence'] .  "<br>";
        }  
        $saida = ["match" => false, "labels" => $result['Labels']];
        return $saida;
    }
    
    function auth($email, $password){        
        $email = trim($email);
        $password = trim($password);

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