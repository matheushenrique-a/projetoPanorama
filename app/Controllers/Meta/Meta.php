<?php

namespace App\Controllers\Meta;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use Config\Services;
use App\Models\M_chatGpt;

class Meta extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $chatgpt;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("vsl"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->chatgpt =  new m_chatGpt();
    }

    public function action($id, $action){
        if ((!empty($id)) and (($action == "ACTIVE") or ($action == "PAUSED"))) {
            $result = $this->changeStatusCpg($id, $action);
            echo "<h1>Resultado:<br>" . var_dump($result) . "</h1>";
        }
    }

    public function manager($pageIdRoot = null){
        
        $buscarProp = $this->getpost('buscarProp');
        $iaExpert = $this->getpost('iaExpert');
        $favoritos = $this->getpost('favoritos');
        $pages = $this->getpost('pages');
        $statusView = $this->getpost('statusView');

        $cpgList = null;
        $cpgListResult = null;
        $data_inicial = date("Y-m-d");
        $data_final = date("Y-m-d");
        
        if ((!empty($buscarProp)) or (!empty($iaExpert))){
            helper('cookie');

            $account = $this->getpost('account', false);
            $dataPreset = $this->getpost('dataPreset', false);
            $status = $this->getpost('status', true);   

            if ($status == "") {
                $status = "ACTIVE";
                $statusArray = '["ACTIVE"]';
            } else if ($status == "ALL") {
                $statusArray = '["ACTIVE", "PAUSED"]';
            } else {
                $statusArray = '["' . $status . '"]';
            }

            $pageId = $this->getpost('pageId', false);
            $keyword = $this->getpost('keyword', false);
            
            $keyword = $this->getpost('keyword', false);
            $language = $this->getpost('language', false);
            $exibir = $this->getpost('exibir', false);
            $data_final = $this->getpost('data_final',false);
            $data_inicial = $this->getpost('data_inicial',false);
          

            $paginas = $this->getpost('paginas',false);

            Services::response()->setCookie('account', $account);
            Services::response()->setCookie('dataPreset', $dataPreset);
            Services::response()->setCookie('status', $status);
            Services::response()->setCookie('exibir', $exibir);
            Services::response()->setCookie('keyword', $keyword);
            Services::response()->setCookie('data_final', $data_final);
            Services::response()->setCookie('data_inicial', $data_inicial);
            Services::response()->setCookie('paginas', $paginas);

            $urlFinal = "act_$account/campaigns?access_token=" . META_TOKEN;
            $urlFinal .= "&fields=" . urlencode("name,daily_budget,budget_remaining,configured_status,start_time,updated_time");
            $urlFinal .= "&date_preset=$dataPreset&&limit=50&effective_status=" . urlencode($statusArray);
                        
           // echo '11:00:27 - <h3>Dump 20 </h3> <br><br>' . var_dump($urlFinal); exit;					//<-------DEBUG

            //$urlFinal = "&ad_type=ALL&ad_reached_countries=BR&ad_active_status=ACTIVE&ad_delivery_date_min=2024-01-01&media_type=ALL&limit=100";
            //echo '' . var_dump($urlFinal); exit;					//<-------DEBUG
            $cpgList = $this->getCpgs($urlFinal);
            $IAPrompt = "";
            //echo '22:50:23 - <h3>Dump 21 </h3> <br><br>' . var_dump($cpgList['retorno']); exit;					//<-------DEBUG

            if ((!is_null($cpgList)) and ($cpgList['sucesso'])){
                $cpgListResult = json_decode($cpgList['retorno'], true);
                //echo '18:59:43 - <h3>Dump 35 </h3> <br><br>' . var_dump($cpgListResult); exit;					//<-------DEBUG

                if (isset($cpgListResult['data'])){
                    foreach ($cpgListResult['data'] as $key => $value) {
                        $cpgName = $cpgListResult['data'][$key]['name'];
                        $id = $cpgListResult['data'][$key]['id'];

                        $budget_remaining = $cpgListResult['data'][$key]['budget_remaining'];
                        $budget_remaining = $budget_remaining / 100;
                        $daily_budget = (isset($cpgListResult['data'][$key]['daily_budget'])  ? $cpgListResult['data'][$key]['daily_budget'] : '0');
                        $daily_budget = $daily_budget / 100;
                        $configured_status = $cpgListResult['data'][$key]['configured_status'];

                        if ((!empty($keyword)) and (strpos(strtoupper($cpgName), strtoupper($keyword)) === false)) continue;

                        $cpgArray = explode("|", $cpgName);
                        $utmContent =  trim($cpgArray[count($cpgArray)-1]); //ultima parte do nome da campanha precis ter o UTM Content 
                        $UtmContentDetails = explode("-", $utmContent);
                        $ticketSale = ($UtmContentDetails[count($UtmContentDetails)-1]);

                        $sqlQuery = "select event, sum(total) total, sum(renda) renda from (
                        select event, ip, count(*) total, sum(cId) renda from vsl_campanha_tracker 
                        where (last_updated >= '$data_inicial 00:00:01' and last_updated <= '$data_final 23:59:59') 
                        and utm_content = '$utmContent' 
                        and referrer not like '%facebookexternalhit%'
                        group by event, ip) data
                        group by event;";

                        //echo '00:39:15 - <h3>Dump 48 </h3> <br><br>' . var_dump($sqlQuery); exit;					//<-------DEBUG

                        $eventos = $this->dbMaster->runQuery($sqlQuery);

                        $eventosCgp['lp'] = 0; //Vsl-Product-Pass
                        $eventosCgp['pay'] = 0; //Vsl-Pay-oracao-L0-171
                        $eventosCgp['pix'] = 0; //Vsl-Product-Pix-Created
                        $eventosCgp['sales'] = 0; //Vsl-Product-Order-Approved
                        $eventosCgp['card'] = 0; //Vsl-Product-Cart-Abandoned
                        $eventosCgp['billet'] = 0; //Vsl-Product-Billet-Created
                        $eventosCgp['declined'] = 0; //Vsl-Product-Order-Rejected
                        $eventosCgp['pixbol'] = 0; //Vsl-Product-Order-Rejected
                        $eventosCgp['ticket'] = 0; //Vsl-Product-Order-Rejected
                        $eventosCgp['revenue'] = 0; //Vsl-Product-Order-Rejected
            
                        foreach ($eventos["result"]->getResult() as $row){
                            $evento = strtoupper($row->event);

                            if ($evento == 'VSL-PRODUCT-PASS'){
                                $eventosCgp['lp'] = $row->total;
                            } else if (strpos($evento, "VSL-PAY-") !== false){
                                $eventosCgp['pay'] += $row->total;
                            } else if ($evento == 'VSL-PRODUCT-PIX-CREATED'){
                                $eventosCgp['pix'] = $row->total;
                            } else if ($evento == 'VSL-PRODUCT-ORDER-APPROVED'){
                                $eventosCgp['sales'] = $row->total;
                                $eventosCgp['revenue'] = $row->renda;
                            } else if ($evento == 'VSL-PRODUCT-CART-ABANDONED'){
                                $eventosCgp['card'] = $row->total;
                            } else if ($evento == 'VSL-PRODUCT-BILLET-CREATED'){
                                $eventosCgp['billet'] = $row->total;
                            } else if ($evento == 'VSL-PRODUCT-ORDER-REJECTED'){
                                $eventosCgp['declined'] = $row->total;
                            }
                            //echo $evento . "-" . $row->total . '<br>';
                        }
                        $eventosCgp['pixbol'] = $eventosCgp['pix'] + $eventosCgp['billet'];
                        $eventosCgp['ticket'] = $ticketSale;
                        //echo '20:55:09 - <h3>Dump 29 </h3> <br><br>' . var_dump($eventosCgp); exit;					//<-------DEBUG

                        $adDetails = $this->getCpgsInsights($cpgListResult['data'][$key]['id'], $data_inicial, $data_final);
                        $detailsFull = json_decode($adDetails['retorno'], true);

                        $impressions = 0;
                        $cpm = 0;
                        $ctr = 0;
                        $costInsight = 0;
                        $cost_per_unique_click = 0;

                        //impressions, reach, website_ctr, cpm, cpc, unique_clicks, clicks, inline_link_clicks
                        if (isset($detailsFull['data'][0])){
                            $impressions = $detailsFull['data'][0]['impressions'];
                            $ctr = (isset($detailsFull['data'][0]['website_ctr'])  ? $detailsFull['data'][0]['website_ctr'][0]['value'] : 0);
                            //$cost_per_unique_click = (isset($detailsFull['data'][0]['cost_per_unique_click'])  ? $detailsFull['data'][0]['cost_per_unique_click'] : 0);
                            $cpm = (isset($detailsFull['data'][0]['cpm'])  ? $detailsFull['data'][0]['cpm'] : 0);
                        }

                        //cost de dias antigos não vem na API então da prioridade ao calculo manual quando existe cpm
                        if (($cpm > 0)) {
                            $costPerImpression = $cpm / 1000;
                            $cost = $costPerImpression * $impressions;														
                        } else {
                            $cost = $daily_budget-$budget_remaining;
                        }
                        $used = simpleRound($daily_budget != 0 ? (($daily_budget-$budget_remaining)/$daily_budget)*100 : '0');

                        if (($configured_status == "ACTIVE") and ($impressions > 0)) {
                            $IAPrompt .= "<br>Id: $id\n";
                            $IAPrompt .= "<br>Nome: $utmContent\n";
                            $IAPrompt .= "<br>Orçamento Diário: $daily_budget\n";
                            $IAPrompt .= "<br>Orçamento Utilizado: $cost\n";
                            $IAPrompt .= "<br>Orçamento Usado: $used%\n";
                            $IAPrompt .= "<br>Impressões: $impressions\n";
                            $IAPrompt .= "<br>CTR: " . simpleround($ctr) . "\n";
                            $IAPrompt .= "<br>CPM: $cpm\n";
                            $IAPrompt .= "<br>Initiated Checkouts: " . $eventosCgp['pay'] . "\n";
                            $IAPrompt .= "<br>Vendas: " . $eventosCgp['sales'] . "\n";
                            $IAPrompt .= "<br>Receita: " . $eventosCgp['revenue'] . "\n\n";
                            $IAPrompt .= "<br><br>";
                        } 

                        $cpgListResult['data'][$key]['id'] = ["id" => $cpgListResult['data'][$key]['id'], "adDetails" => $adDetails, "sales" => $eventosCgp] ;
                        //break;
                    }
                    $basePrompt = "Você é um gestor de tráfego pago com 10 anos de experiência em análise de campanhas para facebook e instagram. Sua missão é analisar dados de campanhas e realizar recomendações com base em indicadores chaves como custo, cpm, ctr, vendas, initiated checkout e outros. Considere na análise que Initiated Checkout é um forte indicador de interesse e compra. CPM baixo é um bom sinal de custo menor para exibição da campanha e alto número de impressões é bom sinal de entrega da campanha ao público. Também evita parar campanhas cujo orçamento usado seja menor de 35%. Você recebeu a lista de resultados de campanhas abaixo e precisa identificar campanhas de baixa conversão (ROI) e classifica-las em 3 status:
                    <br>- PAUSE: campanhas de baixa performance;\n
                    <br>- KEEP: campanhas com indicadores promissores apesar da baixa performance;\n
                    <br>- INCREASE: campanhas com resultados bons que merecem mais orçamento.\n

                    <br><br>\n\nJustifque e explique sua decisão citando os indicadores usados e seus respectivos valores considerados.

                    <br><br>\n\nAo final liste apenas o resultado em formato CSV abaixo sem nenhuma outra informação:
                    <br>\nId; Nome; Orçamento Usado;CTR; CPM; Vendas; Receita; Initiated Checkouts; Status; Justificativa\n
                    <br><br>\nAgora faça a análise das campanhas abaixo:\n";
                    $basePrompt .= $IAPrompt;
                    //$basePrompt .= "\n\n Por fim, com base na análise de todas as campanhas identifique padrões de comportamento geral dos números e liste recomendações gerais para melhoria da performance das campanhas.";
                    //echo $basePrompt;exit;

                    $resultGpt = $this->chatgpt->runQuery($basePrompt);
                    //echo '23:13:25 - <h3>Dump 24 </h3> <br><br>' . var_dump($resultGpt); exit;					//<-------DEBUG

                    if (!empty($iaExpert)) {
                        $dados['iaExpert'] = $resultGpt;
                        $dados['pageTitle'] = "Ads - Gerenciar";

                        return $this->loadpage('ads/ia_expert', $dados);
                        exit;
                    }
                }
            }

        } else {
            $pageId = $this->getpost('pageId', false);
            $keyword = $this->getpost('keyword', true);
            $account = $this->getpost('account', true);
            $status = $this->getpost('status', true);
            $dataPreset = $this->getpost('dataPreset', true);
            $exibir = $this->getpost('exibir', true);
            
            $language = $this->getpost('language', true);
            $type = $this->getpost('type', true);
            $platform = $this->getpost('platform', true);
            $searchType = $this->getpost('searchType',true);
            $paginas = $this->getpost('paginas',true);
        }

        $dados['pageTitle'] = "Ads - Gerenciar";
        $dados['account'] = $account;
        $dados['exibir'] = $exibir;

        $dados['statusView'] = $statusView;
        $dados['keyword'] = $keyword;
        $dados['status'] = $status;
        $dados['data_final'] = $data_final;
        $dados['data_inicial'] = $data_inicial;
        $dados['paginas'] = $paginas;
        $dados['cpgList'] = $cpgList;
        $dados['cpgListResult'] = $cpgListResult;
        $dados['pages'] = $pages;

        return $this->loadpage('ads/manager', $dados);
    }

    public function getCpgs($params){
        $headers = $this->getHeader();
		$url = META_GRAPH_API . ($params);
		///echo $url;exit;
        //$url = urlencode($url);
		//echo $url;exit;
        $result =  $this->http_request('GET', $url, $headers);
        //echo '18:18:12 - <h3>Dump 26 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
		return $result;
	}

    public function changeStatusCpg($id, $status){
        $headers = $this->getHeader();
		$url = META_GRAPH_API . ($id) . "?access_token=" . META_TOKEN . "&status=" . $status;
		//echo $url;exit;
        //$url = urlencode($url);
		//echo $url;exit;
        $result =  $this->http_request('POST', $url, $headers);
        //echo '18:18:12 - <h3>Dump 26 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
		return $result;
	}

    public function getCpgsInsights($cpgId, $dataInicial, $dataFinal){
        $headers = $this->getHeader();
		$url = META_GRAPH_API . $cpgId . "/insights?access_token=" . META_TOKEN . "&fields=" . urlencode("impressions, reach, website_ctr, cpm, cpc, unique_clicks, clicks, inline_link_clicks, cost_per_unique_click") . "&time_range=" . urlencode("{'since':'$dataInicial','until':'$dataFinal'}");
		//echo $url;exit;
        //$url = urlencode($url);
		//echo $url;exit;
        $result =  $this->http_request('GET', $url, $headers);
        //echo '18:18:12 - <h3>Dump 26 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
		return $result;
	}

    public function getHeader(){
		$headers = [];
		$headers[] = "accept: application/json";
		$headers[] = "Content-Type: application/json";

		return $headers;
	}

    function http_request($method, $url, $headers = [], $data = null){
        //echo '20:54:34 - <h3>Dump 35 </h3> <br><br>' . var_dump($data); exit;					//<-------DEBUG
        //echo '22:17:22 - <h3>Dump 35 </h3> <br><br>' . var_dump($headers); exit;					//<-------DEBUG
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FAILONERROR, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        if ($method == 'DELETE') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        
        if ($method == 'GET') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        }

        if(!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);

        //echo '20:53:27 - <h3>Dump 96 </h3> <br><br>' . var_dump($output); exit;					//<-------DEBUG
        
        if (curl_errno($curl)) {
            $retorno = array('sucesso' => false, 'retorno' => curl_error($curl));
        } else {
            $retorno = array('sucesso' => true, 'retorno' => $output);
        }
    
        curl_close($curl);
        return $retorno;
    }


    //http://localhost/InsightSuite/public/ads-load
    //https://insightsuite.pravoce.io/ads-load
    public function loadMiner(){
        ini_set('max_execution_time', 320); 
        //$file_path = fopen('/home/customer/www/insightsuite.pravoce.io/writable/miner.html', 'r');
        $file_path = '/Applications/XAMPP/xamppfiles/htdocs/InsightSuite/writable/miner.html';
        //$file_path = '/home/customer/www/insightsuite.pravoce.io/writable/miner.html';
        $html = file_get_contents($file_path);

        //Create a new DOM document
        $dom = new \DOMDocument;

        //Parse the HTML. The @ is used to suppress any parsing errors
        //that will be thrown if the $html string isn't valid XHTML.
        @$dom->loadHTML($html);

        //Get all links. You could also use any other tag name here,
        //like 'img' or 'table', to extract other tags.
        $links = $dom->getElementsByTagName('a');

        //Iterate over the extracted links and display their URLs
        $count = 0;
        $added = 0;
        $existent = 0;
        foreach ($links as $link){
            //Extract and show the "href" attribute. 
            $url = $link->getAttribute('href');

            $inicio = substr($url, 0, 51);

            if ($inicio == 'https://www.facebook.com/ads/library/?active_status'){
                $count++;
                $queryParams = [];
                parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);

                //$url = str_replace("active_status=all", "active_status=active", $url);
                //echo '<a href="'. $url . '" target="_blank">' . $count . '- View Page </a><br>';
                
                if (isset($queryParams['view_all_page_id'])) {
                	$pageId = $queryParams['view_all_page_id'];
                	
                    $actionTaken = $this->dbMaster->select('ads_pages', ['pageId' => $pageId]);

                    if (!$actionTaken['existRecord']){
                        $this->dbMaster->insert('ads_pages', array("pageId" => $pageId));
                        $added++;
                        echo "Page ID Added: $pageId <br>";
                    } else {
                        echo "Page ID Existent: $pageId <br>";
                        $existent++;
                    }
                    
                } else {
                	echo "view_all_page_id parameter not found in the URL.<br>";
                }
            }
        }
        echo "<br><br>Pages Added: $added <br>";
        echo "Pages Existent: $existent <br>";
    }

}
