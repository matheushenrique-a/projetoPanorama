<?php 
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;
use Symfony\Component\Panther\Client;

class M_integraall extends Model {
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

    public function getHeader(){
		$headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        $token = $this->token();
        $headers[] = "Authorization: Bearer " . $token;
        return $headers;
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

    public function ultima_proposta($cpf){
        $query = "select * from aaspa_propostas where cpf = '$cpf' order by data_criacao desc LIMIT 1";
        $result = $this->dbMasterDefault->runQuery($query);
        return $result;
    }

    public function proposta_integraall($integraallId){
        $this->buscar_propostas($integraallId);
        $query = "select * from aaspa_propostas where integraallId = '$integraallId'";
        $result = $this->dbMasterDefault->runQuery($query);
        return $result;
    }

    public function ultimasPropostas($limit = 6){
        $sql = "select * from aaspa_propostas where vendedorUsuarioId = '" . $this->session->parameters["integraallId"] . "' or 1=1 ";
        $sql .= " order by data_criacao DESC LIMIT $limit;"; 
        
        return $this->dbMasterDefault->runQuery($sql);
    }

    public function countPropostas(){
        $sql = "select count(*) from aaspa_propostas where vendedorUsuarioId = '" . $this->session->parameters["integraallId"] . "' ";
        $sql .= " AND DATE(data_criacao) = CURDATE();"; 
        return $this->dbMasterDefault->runQuery($sql)['countAll'];
    }

    public function graficoAvebacoes(){
        $sql = "SELECT
                    CONCAT('\"', GROUP_CONCAT(DATE_FORMAT(data_venda, '%d/%m') ORDER BY data_venda ASC SEPARATOR '\", \"'), '\"') AS Datas,
                    CONCAT('', GROUP_CONCAT(averbadas ORDER BY data_venda ASC SEPARATOR ', ')) AS Averbacoes
                FROM (
                    SELECT DATE(data_criacao) AS data_venda, COUNT(*) AS averbadas
                    FROM aaspa_propostas
                    WHERE data_ativacao IS NOT NULL
                        AND data_criacao >= CURDATE() - INTERVAL 14 DAY
                        AND (vendedorUsuarioId = '" . $this->session->parameters["integraallId"] . "' OR 1=1)
                    GROUP BY DATE(data_criacao)
                ) AS sub;";
            
        return $this->dbMasterDefault->runQuery($sql);
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

    public function criar_proposta_insight($data, $key){
        
        //echo '14:12:37 - <h3>Dump 95 </h3> <br><br>' . var_dump($data); exit;					//<-------DEBUG

        $proposta = $this->dbMasterDefault->select('aaspa_propostas', $key);

        if (!$proposta['existRecord']){
            $added = $this->dbMasterDefault->insert('aaspa_propostas',$data);
        } else {
            $updated = $this->dbMasterDefault->update('aaspa_propostas', $data, $key);
        }

    }

    public function criar_proposta_integraall($data){
        $headers = $this->getHeader();
        $url = API_Integraall . 'proposta';
        return $this->m_http->http_request('POST', $url, $headers, $data);
    }

    public function cep($cep){
        $headers = $this->getHeader();
        $url = API_Integraall . 'Cep/' . $cep;

        return $this->m_http->http_request('GET', $url, $headers);
    }

    public function listarStatusPorProdutoId($produto){
        $headers = $this->getHeader();
        $url = API_Integraall . 'Proposta/ListarStatus';

        return $this->m_http->http_request('GET', $url, $headers);
    }
    
    public function detalhesProposta($id){
        $headers = $this->getHeader();
        $url = API_Integraall . 'Proposta/' . $id;

        return $this->m_http->http_request('GET', $url, $headers);
    }

    ///http://localhost/InsightSuite/public/integraall-buscar-propostas/1/24458
    public function buscar_propostas($integraallId){
        $result = $this->buscarProposta($integraallId);

        $returnData["linkKompletoCliente"] = "";
        $returnData["vendedorUsuarioId"] = "";
        $returnData["nomeStatus"] = "";
        $returnData["statusAdicionalId"] = "";
        $returnData["color"] = "#008001";
        $returnData["last_update"] = time_elapsed_string(date('Y-m-d H:i:s'));
        
        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);

            if (isset($retorno['id'])){
                $returnData["linkKompletoCliente"] = $retorno['linkKompletoCliente'];
                $returnData["vendedorUsuarioId"] = $retorno['vendedorUsuarioId'];
                $returnData["nomeStatus"] = strtoupper($retorno['nomeStatus']  ?? "");
                $returnData["statusAdicionalId"] = $retorno['statusAdicionalId'];
                $returnData["nomeCliente"] = strtoupper($retorno['nomeCliente']  ?? "");
                $returnData["estadoCivil"] = strtoupper($retorno['estadoCivil']  ?? "");
                $returnData["sexo"] = strtoupper($retorno['sexo']  ?? "");
                $returnData["docIdentidade"] = ($retorno['docIdentidade']);
                $returnData["nomeMae"] = strtoupper($retorno['nomeMae']  ?? "");
                $returnData["emailPessoal"] = ($retorno['emailPessoal']);
                $returnData["telefonePessoal"] = ($retorno['telefonePessoal']);
                $returnData["logradouro"] = strtoupper($retorno['logradouro']  ?? "");
                $returnData["bairro"] = strtoupper($retorno['bairro']  ?? "");
                $returnData["cep"] = ($retorno['cep']);
                $returnData["cidade"] = strtoupper($retorno['cidade']  ?? "");
                $returnData["uf"] = strtoupper($retorno['uf']  ?? "");
                $returnData["complemento"] = strtoupper($retorno['complemento'] ?? "");
                $returnData["endNumero"] = ($retorno['endNumero'] );
                $returnData["statusId"] = strtoupper($retorno['statusId']  ?? "");
                $returnData["dataNascimento"] = ($retorno['dataNascimento']);
                $returnData["matricula"] = ($retorno['matricula']);

                // $propostaHistoricos = $retorno['propostaHistoricos'];
                // foreach ($propostaHistoricos as $historico){
                //     // echo "<br><br>beneficio: " . $proposta['beneficio'] . "<br>";
                // }

                $dataPropostaInsight = [
                    "vendedorUsuarioId" => $returnData["vendedorUsuarioId"],
                    "nomeStatus" => $returnData["nomeStatus"],
                    "statusAdicional" => $returnData["statusAdicionalId"],
                    "linkKompletoCliente" => $returnData["linkKompletoCliente"],
                    "nomeStatus" => $returnData["nomeStatus"],
                    "nomeCliente" => $returnData["nomeCliente"],
                    "estadoCivil" => $returnData["estadoCivil"],
                    "sexo" => $returnData["sexo"],
                    "docIdentidade" => $returnData["docIdentidade"],
                    "nomeMae" => $returnData["nomeMae"],
                    "emailPessoal" => $returnData["emailPessoal"],
                    "telefonePessoal" => $returnData["telefonePessoal"],
                    "logradouro" => $returnData["logradouro"],
                    "bairro" => $returnData["bairro"],
                    "cep" => numberOnly($returnData["cep"]),
                    "cidade" => $returnData["cidade"],
                    "uf" => $returnData["uf"],
                    "complemento" => $returnData["complemento"],
                    "endNumero" => $returnData["endNumero"],
                    "statusId" => $returnData["statusId"],
                    "dataNascimento" => $returnData["dataNascimento"],
                    "matricula" => $returnData["matricula"],
                ];
                
                $propostaAdded = $this->criar_proposta_insight($dataPropostaInsight, ['integraallId' => $integraallId]);
            } else {
                $returnData["color"] = "#f22e46";
            }
        }

        return $returnData;
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