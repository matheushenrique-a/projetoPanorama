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

class Indicadores extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;
    protected $chatgpt;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("vsl"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->chatgpt =  new m_chatGpt();
    }

    //http://localhost/InsightSuite/public/indicadores-vsl
    public function indicadores_vsl(){
        $cpgList = null;
        $cpgListResult = null;
        $data_inicial = date("Y-m-d");
        $data_final = date("Y-m-d");

        $statusArray = '["ACTIVE", "PAUSED"]';
        $dataPreset = 'today';
        $account = "328587016319669";

        $urlFinal = "act_$account/campaigns?access_token=" . META_TOKEN;
        $urlFinal .= "&fields=" . urlencode("name,daily_budget,budget_remaining,configured_status,start_time,updated_time");
        $urlFinal .= "&date_preset=$dataPreset&effective_status=" . urlencode($statusArray);           
        // echo '11:00:27 - <h3>Dump 20 </h3> <br><br>' . var_dump($urlFinal); exit;					//<-------DEBUG

        $cpgList = $this->getCpgs($urlFinal);
        //echo '22:50:23 - <h3>Dump 21 </h3> <br><br>' . var_dump($cpgList['retorno']); exit;					//<-------DEBUG

        if ((!is_null($cpgList)) and ($cpgList['sucesso'])){
            $cpgListResult = json_decode($cpgList['retorno'], true);
            //echo '18:59:43 - <h3>Dump 35 </h3> <br><br>' . var_dump($cpgListResult); exit;					//<-------DEBUG

            if (isset($cpgListResult['data'])){
                $items = 0;
                $budgetTotal = 0;
                $costTotal = 0;
                $impressionsTotal = 0;
                $clicksTotal = 0;
                $ctrTotal = 0;
                $cpmTotal = 0;
                $lpTotal = 0;
                $icsTotal = 0;
                $RejectTotal = 0;
                $pixbolTotal = 0;
                $salesTotal = 0;
                $revenueTotal = 0;
                $lastPageId = 0;
                
                foreach ($cpgListResult['data'] as $key => $value) {
                    $cpgName = $cpgListResult['data'][$key]['name'];
                    $id = $cpgListResult['data'][$key]['id'];
                    $budget_remaining = $cpgListResult['data'][$key]['budget_remaining'];
                    $budget_remaining = $budget_remaining / 100;
                    $daily_budget = (isset($cpgListResult['data'][$key]['daily_budget'])  ? $cpgListResult['data'][$key]['daily_budget'] : '0');
                    $daily_budget = $daily_budget / 100;
                    $configured_status = $cpgListResult['data'][$key]['configured_status'];

                    $cpgArray = explode("|", $cpgName);
                    $utmContent =  trim($cpgArray[count($cpgArray)-1]); //ultima parte do nome da campanha precis ter o UTM Content 
                    $UtmContentDetails = explode("-", $utmContent);
                    $ticketSale = ($UtmContentDetails[count($UtmContentDetails)-1]);

                    $sqlQuery = "select event, count(*) total, sum(renda) renda from (
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
                    $clicks = 0;
                    $cpc = 0;
                    $ctr = 0;
                    $costInsight = 0;
                    $cost_per_unique_click = 0;

                    //impressions, reach, website_ctr, cpm, cpc, unique_clicks, clicks, inline_link_clicks
                    if (isset($detailsFull['data'][0])){
                        $impressions = $detailsFull['data'][0]['impressions'];
                        $reach = $detailsFull['data'][0]['reach'];
                        $ctr = (isset($detailsFull['data'][0]['website_ctr'])  ? $detailsFull['data'][0]['website_ctr'][0]['value'] : 0);
                        $cpm = (isset($detailsFull['data'][0]['cpm'])  ? $detailsFull['data'][0]['cpm'] : 0);
                        $cpc = (isset($detailsFull['data'][0]['cpc'])  ? $detailsFull['data'][0]['cpc'] : 0); 
                        $clicks = (isset($detailsFull['data'][0]['inline_link_clicks'])  ? $detailsFull['data'][0]['inline_link_clicks'] : 0); 
                    }

                    if ($impressions ==0) continue;

                    //cost de dias antigos não vem na API então da prioridade ao calculo manual quando existe cpm
                    if (($cpm > 0)) {
                        $costPerImpression = $cpm / 1000;
                        $cost = $costPerImpression * $impressions;														
                    } else {
                        $cost = $daily_budget-$budget_remaining;
                    }
                    $revenue = $eventosCgp['revenue'];
                    $ics = $eventosCgp['pay'];
                    $Reject = $eventosCgp['declined'];
                    $sales = $eventosCgp['sales'];
                    $roi = ($cost != 0 ? $revenue/$cost : '0');
                    $result = $revenue - $cost;
                    $pixbol = $eventosCgp['pixbol'];
                    $used = ($daily_budget != 0 ? (($daily_budget-$budget_remaining)/$daily_budget)*100 : '0');
                    $lp = $eventosCgp['lp'];

                    $items +=1;
                    $budgetTotal += $daily_budget;
                    $costTotal += $cost;
                    $impressionsTotal += $impressions;
                    $clicksTotal += $clicks;
                    $ctrTotal += $ctr;
                    $cpmTotal += $cpm;
                    $lpTotal += $lp;
                    $icsTotal += $ics;
                    $RejectTotal += $Reject;
                    $pixbolTotal += $pixbol;
                    $salesTotal += $sales;
                    $revenueTotal += $revenue;
                    
                    //break; //DEBUG
                }

                $usedPecent = ($budgetTotal != 0  ? simpleRound(($costTotal/$budgetTotal)*100) . "%" : '-');
                $roiTotal = ($costTotal != 0 ? $revenueTotal/$costTotal : '0');

                $strFilaAgora = "<b>🌟🌟🌟 CPG - STATUS - $account </b>\n";
                $strFilaAgora .= "Campanhas: $items\n";
                $strFilaAgora .= "Orçamento Total: R$ " . simpleRound($budgetTotal) . "\n";
                $strFilaAgora .= "Gasto Total: R$ " . simpleRound($costTotal) . "\n";
                $strFilaAgora .= "Orçamento Usado: " . $usedPecent . "\n";
                $strFilaAgora .= "Impressões: " . $impressionsTotal . "\n";
                $strFilaAgora .= "Clicks: " . $clicksTotal . "\n";
                $strFilaAgora .= "CTR Médio: " . simpleRound(($items > 0  ? $ctrTotal/$items : '0')) . "%\n";
                $strFilaAgora .= "CPM Médio: R$ " . simpleRound(($items > 0  ? $cpmTotal/$items : '0')) . "\n";
                $strFilaAgora .= "-----\n";
                $strFilaAgora .= "LP: " . $lpTotal . "\n";
                $strFilaAgora .= "ICs: " . $icsTotal . "\n";
                $strFilaAgora .= "Declines: " . $RejectTotal . "\n";
                $strFilaAgora .= "PIXBOL: " . $pixbolTotal . "\n";
                $strFilaAgora .= "Vendas: " . $salesTotal . "\n";
                $strFilaAgora .= "Receita: R$ " . simpleRound($revenueTotal) . "\n";
                $strFilaAgora .= "ROI: " . simpleRound($roiTotal) . "\n";
                $strFilaAgora .= "Resultado: R$ " . simpleRound($revenueTotal-$costTotal) . "\n";

                //echo $strFilaAgora;exit;
                $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDigital);
            }
        }


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
