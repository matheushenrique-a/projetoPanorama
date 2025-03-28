<?php 
namespace App\Models;
require_once 'panther/vendor/autoload.php';


use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;
use Symfony\Component\Panther\Client;

class M_integraall extends Model {
    protected $dbMasterDefault;
    protected $my_session;
    protected $telegram;

    public function __construct(){
		$this->dbMasterDefault = new dbMaster();
        $this->my_session = session();
        $this->telegram =  new M_telegram();
        $this->m_http =  new M_http();
    }

    public function getHeader(){
		$headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        $token = $this->token();
        $headers[] = "Authorization: Bearer " . $token;
        return $headers; exit;
	}


    //http://localhost/InsightSuite/public/integraall-token
    public function token(){

        $tokens = $this->dbMasterDefault->select('bancos_servicos', ['Slug' => 'AASPA_PROD']);
        if ($tokens['existRecord']){
            $token =  trim($tokens['firstRow']->AccessToken);
            $updateTime =  $tokens['firstRow']->last_updated;

            $currentTime = new \DateTime();
            $lastUpdatedTime = new \DateTime($updateTime);
            $interval = $currentTime->diff($lastUpdatedTime);

            //token antigo ou vazio
            if (($interval->h + ($interval->days * 24) > 6) or (empty($token))) {
                $newToken = $this->tokenRenew();
                if ($newToken['sucesso']) {
                    $tokenDetalhes = json_decode($newToken['retorno'], true);

                    if (isset($tokenDetalhes['token'])){
                        $tokenGerado = $tokenDetalhes['token'];
                        $this->dbMasterDefault->update('bancos_servicos', ['AccessToken' => $tokenGerado], ['Slug' => 'AASPA_PROD'], ['last_updated' => 'current_timestamp()']);
                        return $tokenDetalhes['token'];
                    } else {
                        $this->telegram->notifyTelegramGroup('🚨🚨🚨 INTEGRAALL TOKEN ERROR ' . $token['retorno'], telegramQuid);
                        Echo "Não foi possível renovar o token. Entre em contato com o Administrador <br>" . $token['retorno'];
                        exit;
                    }
                } else {
                    $this->telegram->notifyTelegramGroup('🚨🚨🚨 INTEGRAALL TOKEN ERROR CURL ' . $token['retorno'], telegramQuid);
                    Echo "Não foi possível renovar o token. Entre em contato com o Administrador <br>" . $token['retorno'];
                    exit;
                }
            } else {
                return $token;
            }
        } else {
            $this->telegram->notifyTelegramGroup('🚨🚨🚨 INTEGRAALL AASPA SERVICE INEXISTENTE', telegramQuid);
        }
    }

    public function tokenRenew(){
		$headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        $url = API_Integraall . 'Login/validar';
        $token = '';

        $data = array();
        $data["login"] = API_User;
        $data["senha"] = API_Password;
        $result =  $this->m_http->http_request('POST', $url, $headers, $data);
        return $result;
    }

    public function loginCalculadora($data){
        $headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        $url = API_Calculadora . 'Login';

        return $this->m_http->http_request('POST', $url, $headers, $data);
    }

    public function tse($data){
        $headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        //$url = "http://localhost:3000/consultar-cpf";
        $url = "https://0cd0-177-73-197-2.ngrok-free.app/consultar-cpf";

        return $this->m_http->http_request('POST', $url, $headers, $data);
    }

    public function qualificaCalculadora($data){
        $headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        $url = API_Calculadora . 'Qualificacao/Consulta';

        return $this->m_http->http_request('POST', $url, $headers, $data);
    }

    public function criar_proposta_insight($data){
        
        //echo '14:12:37 - <h3>Dump 95 </h3> <br><br>' . var_dump($data); exit;					//<-------DEBUG

        $proposta = $this->dbMasterDefault->select('aaspa_propostas', ['cpf' => $data['cpf']]);

        if (!$proposta['existRecord']){
            $added = $this->dbMasterDefault->insert('aaspa_propostas',$data);
        } else {
            $updated = $this->dbMasterDefault->update('aaspa_propostas', $data, ['cpf' => $data['cpf']]);
        }

    }

    public function criar_proposta_integraall($data){
        
        $headers = $this->getHeader();
        $url = API_Integraall . 'proposta';
        

        //echo json_encode($data); exit;					//<-------DEBUG


        return $this->m_http->http_request('POST', $url, $headers, $data);
        echo "16:09:24 - Breakpoint 5"; exit;					//<-------DEBUG
    }

    public function cep($cep){
        $headers = $this->getHeader();
        $url = API_Integraall . 'Cep/' . $cep;

        return $this->m_http->http_request('GET', $url, $headers);
    }
    
    public function detalhesProposta($id){
        $headers = $this->getHeader();
        $url = API_Integraall . 'Proposta/' . $id;

        return $this->m_http->http_request('GET', $url, $headers);
    }

    public function buscarProposta($id){
        $headers = $this->getHeader();
        $url = API_Integraall . 'Proposta/' . $id;
        
        return $this->m_http->http_request('GET', $url, $headers);
    }

    public function listarPropostas($filters){
        $headers = $this->getHeader();
        $queryString = http_build_query($filters);
        $url = API_Integraall . 'Proposta/ListarPropostas/?' . $queryString;
        
        return $this->m_http->http_request('GET', $url, $headers);
    }


    // {
    //     "cadastros": [
    //       {
    //         "nomeCliente": "SANDRA MARIA DA CONCEICAO BARBOSA",
    //         "cpf": "00914447726",
    //         "estadoCivil": null,
    //         "sexo": "F",
    //         "nomeMae": null,
    //         "email": null,
    //         "telefone": null,
    //         "logradouro": "Rua Paraná",
    //         "bairro": "Araras",
    //         "cep": "25957247",
    //         "cidade": "Teresópolis",
    //         "uf": "RJ",
    //         "complemento": "até 1000 - lado par",
    //         "endNumero": null,
    //         "dataNascimento": "1964-02-28T00:00:00",
    //         "matricula": "1382806237",
    //         "instituidorMatricula": null,
    //         "orgao": null,
    //         "codigoOrgao": null,
    //         "docIdentidade": null,
    //         "docIdentidadeUf": null,
    //         "docIdentidadeOrgEmissor": null,
    //         "bloqueio": false
    //       }
    //     ],
    //     "proposta": null
    //   }
    public function validarCpf($filters){
        $headers = $this->getHeader();
        $queryString = http_build_query($filters);
        $url = API_Integraall . 'Cpf/BuscarDadosPorCpf?' . $queryString;
        //echo $url;exit;
        return $this->m_http->http_request('GET', $url, $headers);
    }

}


?>