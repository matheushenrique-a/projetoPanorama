<?php 
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class M_telegram extends Model {
    protected $dbMaster;

    public function __construct()
        {
			$this->dbMaster = new dbMaster();
        }

    function notifyTelegramGroup($messaggio, $chatID = telegramPraVoceGroup) {
    
        //Se a mudança foi feita pelo operador não envia telegram desnecessário
        if ((telegramAlerts)){

            //Mensagens com o texto FATAL ERROR são enviadas para um group telegram diferente só de erros críticos
            if (strpos($messaggio, "FATAL ERROR") !== false) $chatID = telegramPraVoceGroupLogErrors;

            $url = "https://api.telegram.org/bot" . telegramToken . "/sendMessage?chat_id=" . $chatID;
            $url = $url . "&parse_mode=html&text=" . urlencode($messaggio);
            //echo $url;exit;
            $ch = curl_init();
            $optArray = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true
            );
            curl_setopt_array($ch, $optArray);
            $result = curl_exec($ch);
            //$this->dbMaster->record_log(array('log' => "Telegram Enviado: " . $result));
            curl_close($ch);
            return $result;
        }
    }	

}
