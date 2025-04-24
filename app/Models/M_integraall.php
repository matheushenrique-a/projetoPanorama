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

    public function proposta_integraall($integraallId, $autoRefresh = false){

        if ($autoRefresh){
            //busca atualização no integraall antes de retornar dados locais
            //$this->buscar_propostas($integraallId);
        }
        $query = "select * from aaspa_propostas where integraallId = '$integraallId'";
        $result = $this->dbMasterDefault->runQuery($query);
        return $result;
    }

    public function ultimasPropostas($limit = 6){
        $sql = "select * from aaspa_propostas where vendedorUsuarioId = '" . $this->session->parameters["integraallId"] . "' ";
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
                        AND data_criacao >= CURDATE() - INTERVAL 30 DAY
                        AND (vendedorUsuarioId = '" . $this->session->parameters["integraallId"] . "' )
                    GROUP BY DATE(data_criacao)
                ) AS sub;";
            
        return $this->dbMasterDefault->runQuery($sql);
    }

    //
    //
    //
    //
    public function ranking_ativacoes(){
        $sqlAtivacoes = "SELECT vendedorUsuarioId, assessor, COUNT(*) AS averbadas, (COUNT(*) / 7) media 
                        FROM aaspa_propostas 
                        WHERE data_ativacao IS NOT NULL
                        AND DATE(data_criacao) BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()
                        GROUP BY assessor
                        ORDER BY averbadas DESC;";

        $ativacoes = $this->dbMasterDefault->runQuery($sqlAtivacoes);

        return $ativacoes;
    }



    public function tse($data){
        $headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        //$url = "http://localhost:3000/consultar-cpf";
        $url = API_TSE;

        return $this->m_http->http_request('POST', $url, $headers, $data);
    }

    public function qualificaCalculadora($data){
        $headers = [];
		$headers[] = "accept: */*";
		$headers[] = "Content-Type: application/json";

        $url = API_Calculadora . 'Qualificacao/Consulta';

        return $this->m_http->http_request('POST', $url, $headers, $data);
    }

    public function criar_proposta_insight($data, $key = null){
        if (!is_null($key)){
            $proposta = $this->dbMasterDefault->select('aaspa_propostas', $key);

            if (!$proposta['existRecord']){
                $added = $this->dbMasterDefault->insert('aaspa_propostas',$data);
            } else {
                $updated = $this->dbMasterDefault->update('aaspa_propostas', $data, $key);
            }    
        } else {
            $added = $this->dbMasterDefault->insert('aaspa_propostas', $data);
        }
    }

    public function criar_proposta_integraall($data){
        $headers = $this->getHeader();
        $url = API_Integraall . 'proposta';
        $result = $this->m_http->http_request('POST', $url, $headers, $data);

        //echo '08:12:04 - <h3>Dump 41 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG

        //DEBUG 01 - ERRO IDADE
        //$result['sucesso'] = true; 
        //$result['retorno'] = '["\"Erro ao criar proposta: Idade não permitida!\""]';

        //DEBUG 02 - ERRO AUTENTICACAO / REDE
        //$result['sucesso'] = true; 
        //$result['retorno'] = '';

        //DEBUG 03 - CAMPOS NÃO PRENCHIDOS
        //$result['sucesso'] = true; 
        //$result['retorno'] = '["\"Api Kompleto Respondeu: \\r\\nCelular deve ter exatamente 11 dígitos.\\r\\nNome da Mãe é obrigatório.\\r\\nNúmero é obrigatório.\\r\\n\""]';

        //DEBUG 04 - AUTORIZATION ERROR
        //$result['sucesso'] = true; 
        //$result['retorno'] = '{"type":"https://tools.ietf.org/html/rfc7235#section-3.1","title":"Unauthorized","status":401,"traceId":"00-71520932c3d279465b93420dd521c8e2-44ad56f541ab87cf-00"}';

        //DEBUG 05 - SUCESSO PROPOSTA GRAVADA
        //$result['sucesso'] = true;
        //$result['retorno'] = '{"message":"Proposta criada com sucesso!","data":{"id":37588,"token":null,"status":1,"nome":"LENA MARCIA AYRES LIMA","cpf":"28135113234","celular":"31995781355","email":"LENALEIXO@IG.COM.BR","termos":{"cliente":"https://kompleto.app.br/ASS37588","vendedor":"https://kompleto.app.br/TUV37588"}}}';

        $returnData["status"] = false;
        $returnData["mensagem"] = "";       

        if ($result['sucesso']){
            $detalhesGravacao = json_decode($result['retorno'], true);
            
            //quando decode do resultado é vazio indica que não existe json e sim texto puro com erro
            if (empty($detalhesGravacao)){
                $returnData["status"] = false;
                $returnData["mensagem"] = traduzirErroIntegraall($result['retorno']) . "<br>Detalhes: " . (empty($result['retorno'])  ? 'Nenhum detalhe retornado' : $result['retorno']); ;
            
            //quando decode do resultado é um array com 1 elemento, indica lista de erros
            } else if ((is_array($detalhesGravacao)) and (isset($detalhesGravacao[0]))){
                
                $returnData["status"] = false;
                $returnData["mensagem"] = str_replace("Api Kompleto Respondeu", "REVISE A PROPOSTA:", $detalhesGravacao[0]);
                $returnData["mensagem"] = str_replace("\r\n", "<br>- ", $returnData["mensagem"]);
                $returnData["mensagem"] = str_replace('\r\n', "<br>- ", $returnData["mensagem"]);
                $returnData["mensagem"] = str_replace('::', ":", $returnData["mensagem"]);

                //remove ultimo bullet
                $toRemove = "<br>- "; $lastPos = strrpos($returnData["mensagem"], $toRemove);
                if ($lastPos !== false) {
                    $returnData["mensagem"] = substr_replace($returnData["mensagem"], '', $lastPos, strlen($toRemove));
                }

                $returnData["mensagem"] = str_replace("Erro ao criar proposta:", "REVISE A PROPOSTA:<br>- ", $returnData["mensagem"]);
                $returnData["mensagem"] = str_replace('"', "", $returnData["mensagem"]);
            
            //cenario onde a proposta foi gravada com sucesso
            } else if (isset($detalhesGravacao['message'])){
                $returnData["status"] = true;
                $returnData["mensagem"] = $detalhesGravacao['message'];

                if (isset($detalhesGravacao['data'])){
                    $id = $detalhesGravacao['data']['id'];
                    $token = $detalhesGravacao['data']['token'];
                    $statusId = $detalhesGravacao['data']['status'];
                    $nome = $detalhesGravacao['data']['nome'];
                    $cpf = $detalhesGravacao['data']['cpf'];
                    $celular = $detalhesGravacao['data']['celular'];
                    $email = $detalhesGravacao['data']['email'];

                    $returnData['integraallExtra']['token'] = $token;
                    $returnData['integraallExtra']['nome'] = $nome;
                    $returnData['integraallExtra']['cpf'] = $cpf;
                    $returnData['integraallExtra']['email'] = $email;
                    
                    if (isset($detalhesGravacao['data']['termos'])){
                        $returnData['integraallExtra']['termoCliente'] = $detalhesGravacao['data']['termos']['cliente'];
                        $returnData['integraallExtra']['termoVendedor'] = $detalhesGravacao['data']['termos']['vendedor'];
                    }

                    if (!empty($id)){
                        $returnData['integraall']['integraallId'] = $id;
                        //$returnData['integraall']['token'] = $token;
                        //$returnData['integraall']['nome'] = $nome;
                        $returnData['integraall']['statusId'] = $statusId;
                        $returnData['integraall']['nomeStatus'] = getStatusNomePorId($statusId)[1];
                    }
                }
            //cenário onde o json retorna erro de autorization ou algo de rede (mais baixo nível)
            } else if (isset($detalhesGravacao['title'])){
                $returnData["status"] = false;
                $type = $detalhesGravacao['type'];
                $title = $detalhesGravacao['title'];
                $status = $detalhesGravacao['status'];
                $traceId = $detalhesGravacao['traceId'];

                $returnData["mensagem"] = "Falha geral - " . $detalhesGravacao['title'] . "<br>Rastreio: $traceId";

                // Verifica se há erros
                if (isset($detalhesGravacao['errors']) && is_array($detalhesGravacao['errors'])) {
                    $returnData["mensagem"] .= "<br>Erros encontrados:<br>";

                    foreach ($detalhesGravacao['errors'] as $campo => $mensagens) {
                        $returnData["mensagem"] .= "Campo {$campo}";
                        foreach ($mensagens as $mensagem) {
                            $returnData["mensagem"] .=  "- {$mensagem}<br>";
                        }
                    }
                } else {
                    $returnData["mensagem"] .=  "<br>Nenhum detalhe adicional informado.";
                }
            }
        } else {
            $returnData["mensagem"] = "Erro geral: " . $result['retorno'];
        }

        return $returnData;
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

    ///http://localhost/InsightSuite/public/integraall-buscar-propostas/31315
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

                $returnData["statusId"] = $retorno['statusId'];
                $returnData["nomeStatus"] = getStatusNomePorId($retorno['statusId']); //array

                $returnData["statusAdicionalId"] = $retorno['statusAdicionalId'];
                $returnData["statusAdicional"] = getStatusAdicionalPorId($retorno['statusAdicionalId']); //array

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
                $returnData["dataNascimento"] = ($retorno['dataNascimento']);
                $returnData["matricula"] = ($retorno['matricula']);

                // $propostaHistoricos = $retorno['propostaHistoricos'];
                // foreach ($propostaHistoricos as $historico){
                //     // echo "<br><br>beneficio: " . $proposta['beneficio'] . "<br>";
                // }

                $dataPropostaInsight = [
                    "vendedorUsuarioId" => $returnData["vendedorUsuarioId"],

                    "statusId" => $returnData["statusId"],
                    "nomeStatus" => strtoupper($returnData["nomeStatus"][1]),   //extrai apenas o nome do status
                    "statusAdicionalId" => $returnData["statusAdicionalId"],
                    "statusAdicional" => strtoupper($returnData["statusAdicional"][1]), //extrai apenas o nome do status

                    "linkKompletoCliente" => $returnData["linkKompletoCliente"],
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
        
        $saida = $this->m_http->http_request('GET', $url, $headers);
        //echo '15:01:07 - <h3>Dump 52 </h3> <br><br>' . var_dump($saida); exit;					//<-------DEBUG
        return $saida;
    }

    //sync
    public function integraall_importar_propostas($filters){
        $headers = $this->getHeader();
        $queryString = http_build_query($filters);
        $url = API_Integraall . 'Proposta/ListarPropostas/?' . $queryString;
        
        return $this->m_http->http_request('GET', $url, $headers);
    }

    //sync
    public function buscaUltimaProposta($filters){
        $result = $this->integraall_importar_propostas($filters);

        $lastIntegraallId = 0;
        if ($result['sucesso']){
            $retorno = json_decode($result['retorno'], true);
            if (isset($retorno['qtdResultado']) && $retorno['qtdResultado'] > 0){
                $propostas = $retorno['resultado'];

                foreach ($propostas as $proposta){

                    if ($proposta['id'] > $lastIntegraallId) {
                        $lastIntegraallId = $proposta['id'];
                    }

                    $data = [
                        'integraallId' => $proposta['id'],
                        "nomeCliente" => $proposta['nomeCliente'],
                        "cpf" => $proposta['cpf'],
                        "telefonepessoal" => $proposta['telefonePessoal'],

                        'statusId' => $proposta['statusId'],
                        'nomeStatus' => strtoupper(getStatusNomePorId($proposta['statusId'])[1] ?? ""),

                        'statusAdicionalId' => $proposta['statusAdicionalId'],
                        'statusAdicional' => strtoupper(getStatusAdicionalPorId($proposta['statusAdicionalId'])[1]  ?? ""),
                        
                        'assessor' => $proposta['nomeVendedor'],
                        'data_criacao' => $proposta['dataCadastro'],
                        'linkKompletoCliente' => $proposta['linkKompletoCliente'],
                        'matricula' => $proposta['matricula'],
                        'linkAtivo' => $proposta['linkAtivo'],
                        'produtoId' => $proposta['produtoId'],
                        "revendedorId" => $proposta['revendedorId'],
                        "data_ativacao" => $proposta['dataSolicitacaoAtivacao'],
                        "vendedorUsuarioId" => $proposta['vendedorUsuarioId']
                    ];

                    $propostaIntegraall = $this->dbMasterDefault->select('aaspa_propostas', ['integraallId' => $data['integraallId']]);

                    //faz lookup do Id Integraall com Id Insight
                    $userId = $proposta['vendedorUsuarioId'];
                    $sqlQuery = 'select * from user_account where parameters like "%{\"integraallId\": ' . $proposta['vendedorUsuarioId'] . ',%"';
                    $userContext = $this->dbMasterDefault->runQuery($sqlQuery);
                    if ($userContext['existRecord']){$userId = $userContext['firstRow']->userId;}
                    
                    if (!$propostaIntegraall['existRecord']){
                        $added = $this->dbMasterDefault->insert('aaspa_propostas', $data);
                    } else {
                        $updated = $this->dbMasterDefault->update('aaspa_propostas', $data, ['integraallId' => $data['integraallId']]);
                    }
                }
            }
        }

        return $lastIntegraallId;        
    }
    
    public function validarCpf($filters){
        $headers = $this->getHeader();
        $queryString = http_build_query($filters);
        $url = API_Integraall . 'Cpf/BuscarDadosPorCpf?' . $queryString;
        //echo $url;exit;
        return $this->m_http->http_request('GET', $url, $headers);
    }

}


?>