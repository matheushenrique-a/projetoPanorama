<?php

namespace App\Controllers\Meta;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use Config\Services;

class Meta extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("vsl"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        $this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
    }

    public function manager($pageIdRoot = null){
        
        $buscarProp = $this->getpost('buscarProp');
        $favoritos = $this->getpost('favoritos');
        $pages = $this->getpost('pages');
        $statusView = $this->getpost('statusView');

        $cpgList = null;
        $cpgListResult = null;
        $data_inicial = date("Y-m-d");
        $data_final = date("Y-m-d");
        
        if ((!empty($buscarProp))){
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

            //$pageId = $this->getpost('pageId', false);
            //$status = $this->getpost('status', false);
            //$exibir = $this->getpost('exibir', true);
            //$language = $this->getpost('language', true);
            $type = $this->getpost('type', false);
            $platform = $this->getpost('platform', false);
            $searchType = $this->getpost('searchType',false);
            $data_final = $this->getpost('data_final',false);
            $data_inicial = $this->getpost('data_inicial',false);
          

            $paginas = $this->getpost('paginas',false);

            Services::response()->setCookie('account', $account);
            Services::response()->setCookie('dataPreset', $dataPreset);
            Services::response()->setCookie('status', $status);
            Services::response()->setCookie('exibir', $exibir);

            Services::response()->setCookie('keyword', $keyword);
            Services::response()->setCookie('pageId', $pageId);
            Services::response()->setCookie('language', $language);
            Services::response()->setCookie('type', $type);
            Services::response()->setCookie('platform', $platform);
            Services::response()->setCookie('searchType', $searchType);
            Services::response()->setCookie('data_final', $data_final);
            Services::response()->setCookie('data_inicial', $data_inicial);
            Services::response()->setCookie('paginas', $paginas);

            $urlFinal = "act_$account/campaigns?access_token=" . META_TOKEN;
            $urlFinal .= "&fields=" . urlencode("name,daily_budget,budget_remaining,configured_status,start_time,updated_time");
            $urlFinal .= "&date_preset=$dataPreset&effective_status=" . urlencode($statusArray);
            
            // if (!empty($dataPreset)) $urlFinal .= "&ad_type=$dataPreset";
            // if (!empty($pageId)) $urlFinal .= "&search_page_ids=$pageId";
            // if (!empty($exibir)) $urlFinal .= "&ad_reached_countries=$exibir";
            // if (!empty($status)) $urlFinal .= "&ad_active_status=$status";
            // if (!empty($language)) $urlFinal .= "&languages=" . strtolower($language);
            // if (!empty($type)) $urlFinal .= "&media_type=$type";
            // if (!empty($platform)) $urlFinal .= "&publisher_platforms=$platform";
            // if (!empty($data_inicial)) $urlFinal .= "&data_inicial=$data_inicial";
            // if (!empty($data_final)) $urlFinal .= "&ad_delivery_date_min=$data_final";
            //if (!empty($paginas)) $urlFinal .= "&limit=$paginas";
            
           // echo '11:00:27 - <h3>Dump 20 </h3> <br><br>' . var_dump($urlFinal); exit;					//<-------DEBUG

            //$urlFinal = "&ad_type=ALL&ad_reached_countries=BR&ad_active_status=ACTIVE&ad_delivery_date_min=2024-01-01&media_type=ALL&limit=100";
            //echo '' . var_dump($urlFinal); exit;					//<-------DEBUG
            $cpgList = $this->getCpgs($urlFinal);

            //echo '22:50:23 - <h3>Dump 21 </h3> <br><br>' . var_dump($cpgList['retorno']); exit;					//<-------DEBUG

            if ((!is_null($cpgList)) and ($cpgList['sucesso'])){
                $cpgListResult = json_decode($cpgList['retorno'], true);
                //echo '18:59:43 - <h3>Dump 35 </h3> <br><br>' . var_dump($cpgListResult); exit;					//<-------DEBUG

                if (isset($cpgListResult['data'])){
                    foreach ($cpgListResult['data'] as $key => $value) {
                        $cpgName = $cpgListResult['data'][$key]['name'];
                        
                        if ((!empty($keyword)) and (strpos(strtoupper($cpgName), strtoupper($keyword)) === false)) continue;

                        $cpgArray = explode("|", $cpgName);
                        $utmContent =  trim($cpgArray[count($cpgArray)-1]); //ultima parte do nome da campanha precis ter o UTM Content 
                        $UtmContentDetails = explode("-", $utmContent);
                        $ticketSale = ($UtmContentDetails[count($UtmContentDetails)-1]);

                        // $sqlQuery = "select event, count(*) total, sum(cId) renda from vsl_campanha_tracker 
                        // where (last_updated >= '2024-07-11 00:00:01' and last_updated <= '2024-07-13 23:59:59')
                        // group by event;";

                        // $sqlQuery = "select event, count(*) total, sum(cId) renda from vsl_campanha_tracker 
                        // where (last_updated >= '$data_inicial 00:00:01' and last_updated <= '$data_final 23:59:59')
                        // and utm_content = '$utmContent'
                        // group by event;";

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
                        $cpgListResult['data'][$key]['id'] = ["id" => $cpgListResult['data'][$key]['id'], "adDetails" => $adDetails, "sales" => $eventosCgp] ;
                        //break;
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
        $dados['type'] = $type;
        $dados['pageId'] = $pageId;
        $dados['dataPreset'] = $dataPreset;
        $dados['status'] = $status;
        $dados['language'] = $language;
        $dados['platform'] = $platform;
        $dados['searchType'] = $searchType;
        $dados['data_final'] = $data_final;
        $dados['data_inicial'] = $data_inicial;
        $dados['paginas'] = $paginas;
        $dados['cpgList'] = $cpgList;
        $dados['cpgListResult'] = $cpgListResult;
        $dados['favoritos'] = $favoritos;
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
