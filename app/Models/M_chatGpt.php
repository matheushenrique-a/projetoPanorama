<?php 
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\dbMaster;

class m_chatGpt extends Model {
    public function __construct(){
        //$this->load->database();
    }

    public function runQuery($query){
        $apiKey = API_KEY_CHATGPT;
        $url = API_URL_CHATGPT;  
    
        $headers = array(
            "Authorization: Bearer {$apiKey}",
            "OpenAI-Organization: " . API_ORG_CHATGPT, 
            "Content-Type: application/json"
        );
    
        // Define messages
        $messages = array();
        $message = array();
        $message["role"] = "user";
        $message["content"] = $query;
        $messages[] = $message;

        // Define data
        $data = array();
        //$data["model"] = "gpt-4";
        $data["model"] = "gpt-4o";
        $data["max_tokens"] = 4000;
        $data["temperature"] = 0.13;
        $data["messages"] = $messages;
        //$data["model"] = "text-davinci-003";
        //$data["model"] = "gpt-3.5-turbo";
        //$data["model"] = "gpt-3.5-turbo-1106";
        //$data["model"] = "text-davinci-003";
        //$data["model"] = "text-curie-001";
        //$data["prompt"] = $query;

        //echo json_encode($data);exit;

        // init curl
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);

        //echo '22:56:30 - <h3>Dump 44 </h3> <br><br>' . var_dump($response); exit;					//<-------DEBUG
        if (curl_errno($curl)) {
            $retorno = array('sucesso' => false, 'retorno' => curl_error($curl));
        } else {
            //$response = str_replace('\n', "<br>", $response);
            $retorno = array('sucesso' => true, 'retorno' => $response);
        }

        //echo '20:12:59 - <h3>Dump 3 </h3> <br><br>' . var_dump($retorno); exit;					//<-------DEBUG
        $returnData = array();
        $returnData["existResposta"] = true;
        $returnData["rawjson"] = "";
        
        if ($retorno['sucesso']){
            $result = json_decode($retorno['retorno'],true);

            //echo $result['choices'][0]['message']['content'];exit;

            if (isset($result['choices'][0]['message']['content'])){
                $returnData["conteudo"] = $result['choices'][0]['message']['content'];
                $returnData["rawjson"] = $retorno['retorno'];
            } else {
                $returnData["existResposta"] = false;
                $returnData["motivo"] = "[ERRO-API]";
                $returnData["rawjson"] = $retorno['retorno'];
            }			
        } else {
            $returnData["existResposta"] = false;
            $returnData["rawjson"] = $retorno['retorno'];
        }
    
        curl_close($curl);
        return $returnData;
    }

    public function TTS($query){
        $apiKey = API_KEY_CHATGPT;
        $url = API_URL_CHATGPT_TTS;  
    
        $headers = array(
            "Authorization: Bearer {$apiKey}",
            "OpenAI-Organization: " . API_ORG_CHATGPT, 
            "Content-Type: application/json"
        );
    
        // Define messages
        $data = array();
        $data["model"] = "tts-1";
        $data["input"] = $query;
        $data["voice"] = 'shimmer';
        //$data["voice"] = 'nova';

        //echo json_encode($data);exit;

        // init curl
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);

        //echo '22:56:30 - <h3>Dump 44 </h3> <br><br>' . var_dump($response); exit;					//<-------DEBUG
        if (curl_errno($curl)) {
            $retorno = array('sucesso' => false, 'retorno' => curl_error($curl));
        } else {
            //$response = str_replace('\n', "<br>", $response);
            $retorno = array('sucesso' => true, 'retorno' => $response);
        }

        curl_close($curl);
        return $retorno;
    }
}
?>