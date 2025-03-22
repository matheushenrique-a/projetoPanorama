<?php 
//require_once 'aws/vendor/autoload.php';

namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;

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
        if ($token['sucesso']) {
            $integraall = json_decode($token['retorno'], true);

            if (isset($integraall['token'])){
                $headers[] = "Authorization: Bearer " . $integraall['token'];
                return $headers; exit;
            }
        }

        $this->telegram->notifyTelegramGroup('🚨🚨🚨 INTEGRAALL TOKEN ERROR ' . $token['retorno'], telegramQuid);
        throw new \Exception('INTEGRAALL TOKEN ERROR: ' . $token['retorno']);
	}

    //http://localhost/InsightSuite/public/integraall-token
    public function token(){
        //TOKEN GERADO 20/03 07:45
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IkZFUk5BTkRPIERBTlRBUyBTQU5UT1MgSlVOSU9SIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy91c2VyZGF0YSI6Ijk5MSIsIlVzZXJJZCI6Ijk5MSIsIlJldmVuZGVkb3JJZCI6IjE0NCIsIlBlcmZpbElkIjoiNSIsImlwIjoiMTc3LjczLjE5Ny4yIiwicm9sZSI6WyJjcmlhcl9wcm9wb3N0YSIsInZpc3VhbGl6YXJfcHJvcG9zdGEiLCJlZGl0YXJfcHJvcG9zdGEiLCJpbnNlcmlyX2RvY3VtZW50b3MiLCJjb3BpYXJfbGlua19wYWdhbWVudG8iLCJyZWVudmlhcl9saW5rX3BhZ2FtZW50byIsImNhbmNlbGFyX3Byb3Bvc3RhIiwicmVsYXRvcmlvX2NvbWlzc2lvbmFtZW50byIsImFjZXNzb190b3RhbCIsImxpc3Rhcl91c3VhcmlvIiwiY3JpYXJfcHJvcG9zdGEiLCJ2aXN1YWxpemFyX3Byb3Bvc3RhIiwiZWRpdGFyX3Byb3Bvc3RhIiwiaW5zZXJpcl9kb2N1bWVudG9zIiwiY29waWFyX2xpbmtfcGFnYW1lbnRvIiwicmVlbnZpYXJfbGlua19wYWdhbWVudG8iLCJjYW5jZWxhcl9wcm9wb3N0YSIsInJlbGF0b3Jpb19jb21pc3Npb25hbWVudG8iLCJhY2Vzc29fdG90YWwiLCJsaXN0YXJfdXN1YXJpbyJdLCJuYmYiOjE3NDI1ODEwMjEsImV4cCI6MTc0MjYzODYyMSwiaWF0IjoxNzQyNTgxMDIxfQ.BQGxnDt4FLgRJV7iCzU9yS0C8K18zRWxhFK9m58ATDM';
        return ['sucesso' => true, 'retorno' => json_encode(['token' => $token])];
    }

    public function tokenRenew(){
        $headers = $this->getHeader();
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

    public function qualificaCalculadora($data){
        $headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        $url = API_Calculadora . 'Qualificacao/Consulta';

        return $this->m_http->http_request('POST', $url, $headers, $data);
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