<?php

namespace App\Controllers\Ads;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use Config\Services;

class Ads extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("fgtsDB"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        //$this->checkSession();

        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
    }

    public function adsLike(){
        $action = $this->getpost('action');
        $keyword = $this->getpost('keyword');
        $adId = $this->getpost('adId');
        $pageId = $this->getpost('pageId');
        $url = $this->getpost('url');
        $createDate = $this->getpost('createDate');
        header('Content-Type: application/json');

        $actionTaken = $this->isSaved($adId, $pageId, false)["action"];
        $newStatus = "";
        
        if ($actionTaken == "none"){
            $newStatus = $action;
            $this->dbMaster->insert('ads_saved', array('userId' => $this->session->userId, "adId" => $adId, "keyword" => $keyword, "action" => $action, "pageId" => $pageId, "url" => $url, "createDate" => $createDate));
        
        } else if (($actionTaken == "dislike") and ($action == "star")){ 
            $newStatus = 'star';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
        } else if (($actionTaken == "dislike") and ($action == "dislike")){ 
            $newStatus = 'view';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);

        } else if (($actionTaken == "dislike") and ($action == "saved")){ 
            $newStatus = 'saved';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);

        } else if (($actionTaken == "dislike") and ($action == "view")){ 
            $newStatus = 'dislike';

            
        } else if (($actionTaken == "saved") and ($action == "star")){
            $newStatus = 'star';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
        } else if (($actionTaken == "saved") and ($action == "saved")){
            $newStatus = 'view';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
            
        } else if (($actionTaken == "saved") and ($action == "view")){
            //nothing
            $newStatus = "saved";
        } else if (($actionTaken == "saved") and ($action == "dislike")){
            $newStatus = 'dislike';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
        


        } else if (($actionTaken == "view") and ($action == "star")){
            $newStatus = 'star';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);

        } else if (($actionTaken == "view") and ($action == "saved")){
            $newStatus = 'saved';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);

        } else if (($actionTaken == "view") and ($action == "dislike")){
            $newStatus = 'dislike';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
        
        } else if (($actionTaken == "view") and ($action == "view")){
            //nothing
            $newStatus = $action;




        } else if (($actionTaken == "star") and ($action == "view")){
            $newStatus = 'star';
        } else if (($actionTaken == "star") and ($action == "star")){
            $newStatus = 'saved';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
        } else if (($actionTaken == "star") and ($action == "dislike")){
            $newStatus = 'dislike';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
        } else if (($actionTaken == "star") and ($action == "saved")){
            $newStatus = 'saved';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId, 'userId' => $this->session->userId], ['last_update' => 'current_timestamp()']);
        }
    

        
        //echo  $result;exit;

        $saida = ["newStatus" => $newStatus, "debug" => "AdId: $adId, Keyword: $keyword, Era: $actionTaken, Quer Virar: $action"];
        echo json_encode($saida); 
    }

    public function adsNicho(){
        $adId = $this->getpost('adId');
        $salePage = $this->getpost('salePage');
        $checkOut = $this->getpost('checkOut');
        $description = $this->getpost('description');
        $nicho = $this->getpost('nicho');
        $categoria = $this->getpost('categoria');

        header('Content-Type: application/json');
        $this->dbMaster->update('ads_saved', ['salePage' => $salePage, 'checkOut' => $checkOut, 'description' => $description, 'nicho' => $nicho, 'categoria' => $categoria], ['adId' => $adId], ['last_update' => 'current_timestamp()']);

        $saida = ["result" => "ok"];
        echo json_encode($saida); 
    }

    public function isSaved($adId, $pageId, $checkPageLevel){
        $actionTaken = $this->dbMaster->select('ads_saved', ['adId' => $adId, 'userId' => $this->session->userId]);

        if (!$actionTaken['existRecord']){
            if ($checkPageLevel) {
                $actPage = $this->dbMaster->select('ads_saved', ['pageId' => $pageId, 'userId' => $this->session->userId]);

                if ($actPage['existRecord']){
                    return  ["level" => "page", "action" => $actPage['firstRow']->action, "salePage" => $actPage['firstRow']->salePage, "checkOut" => $actPage['firstRow']->checkOut, "description" => $actPage['firstRow']->description, "nicho" => $actPage['firstRow']->nicho, "categoria" => $actPage['firstRow']->categoria];
                } else {
                    return  ["level" => "none", "action" => "none", "salePage" => "", "checkOut" => "", "description" => "", "nicho" => "", "categoria" => ""];
                }    
            } else {
                return  ["level" => "direct", "action" => "none", "salePage" => "", "checkOut" => "", "description" => "", "nicho" => "", "categoria" => ""];
            }
        } else {
            return  ["level" => "direct", "action" => $actionTaken['firstRow']->action, "salePage" => $actionTaken['firstRow']->salePage, "checkOut" => $actionTaken['firstRow']->checkOut, "description" => $actionTaken['firstRow']->description, "nicho" => $actionTaken['firstRow']->nicho, "categoria" => $actionTaken['firstRow']->categoria];
        }
	}

    public function listarAds($pageIdRoot = null){
        $buscarProp = $this->getpost('buscarProp');
        $favoritos = $this->getpost('favoritos');
        $pages = $this->getpost('pages');
        $groups = $this->getpost('groups');
        $statusView = $this->getpost('statusView');
        $paginas = $this->getpost('paginas');

        $adList = null;
        $adListResult = null;
        
        
        //lista todos os ads mas agrupados por páginas para saber quais páginas tem mais ads
        if (!empty($groups)){
            $sql = 'select p.pageId, count(*) total, max(p.ad_snapshot_url) urlAd, max(p.last_update) last_update, s.action 
                    from ads_pages p left join ads_saved s on p.pageId = s.pageId and s.userId = ' . $this->session->userId;
            
            if ($statusView == "view") {
                $sql .= ' where action = "view" ';
            } else if ($statusView == "saved") {
                $sql .= ' where action = "saved" or action = "star" ';
            } else if ($statusView == "dislike") {
                $sql .= ' where action = "dislike" ';
            } else if (($statusView == "all") or (empty($statusView))) {
                //nada
            } else if ($statusView == "null") {
                $sql .= ' where action is null ';
            } else if ($statusView == "star") {
                $sql .= ' where action = "star" ';
            }
            
            $sql .= ' group by pageId order by total desc limit ' . $paginas . ';';
            //echo $sql;exit;
            $adList = $this->dbMaster->runQuery($sql);

            $keyword = $this->getpost('keyword', true);
            $preFilter = $this->getpost('preFilter', true);
            $pageId = $this->getpost('pageId', true);
            $adType = $this->getpost('adType', true);
            $country = $this->getpost('country', true);
            $status = $this->getpost('status', true);
            //echo '22:16:13 - <h3>Dump 22 </h3> <br><br>' . var_dump($status); exit;					//<-------DEBUG
            $language = $this->getpost('language', true);
            $type = $this->getpost('type', true);
            $platform = $this->getpost('platform', true);
            $searchType = $this->getpost('searchType',true);
            $initialDate = $this->getpost('initialDate',true);
            $ad_delivery_date_max = $this->getpost('ad_delivery_date_max',true);
            $paginas = $this->getpost('paginas',true);
        } else if (!empty($pages)){
            //$this->dbMaster->setOrderBy(array("last_update", "DESC"));
            //$this->dbMaster->setLimit($paginas);
            //$adList = $this->dbMaster->select('ads_pages', null);
            $sql = 'select p.pageId, p.last_update, s.action from ads_pages p left join ads_saved s on p.pageId = s.pageId and s.userId = ' . $this->session->userId;
            
            if ($statusView == "view") {
                $sql .= ' where action = "view" ';
            } else if ($statusView == "saved") {
                $sql .= ' where action = "saved" or action = "star" ';
            } else if ($statusView == "dislike") {
                $sql .= ' where action = "dislike" ';
            } else if (($statusView == "all") or (empty($statusView))) {
                //nada
            } else if ($statusView == "null") {
                $sql .= ' where action is null ';
            } else if ($statusView == "star") {
                $sql .= ' where action = "star" ';
            }
            
            $sql .= ' order by p.last_update desc limit ' . $paginas . ';';
            //echo $sql;exit;
            $adList = $this->dbMaster->runQuery($sql);

            $keyword = $this->getpost('keyword', true);
            $preFilter = $this->getpost('preFilter', true);
            $pageId = $this->getpost('pageId', true);
            $adType = $this->getpost('adType', true);
            $country = $this->getpost('country', true);
            $status = $this->getpost('status', true);
            //echo '22:16:13 - <h3>Dump 22 </h3> <br><br>' . var_dump($status); exit;					//<-------DEBUG
            $language = $this->getpost('language', true);
            $type = $this->getpost('type', true);
            $platform = $this->getpost('platform', true);
            $searchType = $this->getpost('searchType',true);
            $initialDate = $this->getpost('initialDate',true);
            $ad_delivery_date_max = $this->getpost('ad_delivery_date_max',true);
            $paginas = $this->getpost('paginas',true);


        } else if (!empty($favoritos)){
            $this->dbMaster->setOrderBy(array("last_update", "DESC"));
            $this->dbMaster->setLimit(500);
            $adList = $this->dbMaster->select('ads_saved', ['userId' => $this->session->userId, 'action' => 'saved']);

            $keyword = $this->getpost('keyword', true);
            $preFilter = $this->getpost('preFilter', true);
            $pageId = $this->getpost('pageId', true);
            $adType = $this->getpost('adType', true);
            $country = $this->getpost('country', true);
            $status = $this->getpost('status', true);
            //echo '22:16:13 - <h3>Dump 22 </h3> <br><br>' . var_dump($status); exit;					//<-------DEBUG
            $language = $this->getpost('language', true);
            $type = $this->getpost('type', true);
            $platform = $this->getpost('platform', true);
            $searchType = $this->getpost('searchType',true);
            $initialDate = $this->getpost('initialDate',true);
            $ad_delivery_date_max = $this->getpost('ad_delivery_date_max',true);
            $paginas = $this->getpost('paginas',true);
        } else if ((!empty($buscarProp)) or (!empty($pageIdRoot))){
            helper('cookie');

            $preFilter = $this->getpost('preFilter', false);
            $pageId = $this->getpost('pageId', false);
            $keyword = $this->getpost('keyword', false);
            
            $keyword = $this->getpost('keyword', false);
            $language = $this->getpost('language', false);
            $status = $this->getpost('status', true);   
            $country = $this->getpost('country', true);

            if (!empty($preFilter)) {
                $preFilterPars = explode("-", strtolower($preFilter));
                $keyword = $preFilterPars[0];
                $country = strtoupper($preFilterPars[1]);
                $language = $preFilterPars[2];

                //echo "$keyword, $country, $language"; exit;
            } 
            
            if (!empty($pageIdRoot)) {
                $pageId = $pageIdRoot;
                $keyword = "";
                $preFilter = "";
                $status = "ALL";
            } 

            //$pageId = $this->getpost('pageId', false);
            //$status = $this->getpost('status', false);
            //$country = $this->getpost('country', true);
            //$language = $this->getpost('language', true);
            $adType = $this->getpost('adType', false);
            $type = $this->getpost('type', false);
            $platform = $this->getpost('platform', false);
            $searchType = $this->getpost('searchType',false);
            $initialDate = $this->getpost('initialDate',false);
            $ad_delivery_date_max = $this->getpost('ad_delivery_date_max',false);
            $paginas = $this->getpost('paginas',false);

            Services::response()->setCookie('keyword', $keyword);
            Services::response()->setCookie('preFilter', $preFilter);
            Services::response()->setCookie('pageId', $pageId);
            Services::response()->setCookie('adType', $adType);
            Services::response()->setCookie('country', $country);
            Services::response()->setCookie('status', $status);
            Services::response()->setCookie('language', $language);
            Services::response()->setCookie('type', $type);
            Services::response()->setCookie('platform', $platform);
            Services::response()->setCookie('searchType', $searchType);
            Services::response()->setCookie('initialDate', $initialDate);
            Services::response()->setCookie('ad_delivery_date_max', $ad_delivery_date_max);
            Services::response()->setCookie('paginas', $paginas);

            $urlFinal = "";

            if (!empty($keyword)) {
                $urlFinal .= "&search_terms=" . urlencode($keyword);
                if (!empty($searchType)) $urlFinal .= "&search_type=$searchType";
            }
            if (!empty($adType)) $urlFinal .= "&ad_type=$adType";
            if (!empty($pageId)) $urlFinal .= "&search_page_ids=$pageId";
            if (!empty($country)) $urlFinal .= "&ad_reached_countries=$country";
            if (!empty($status)) $urlFinal .= "&ad_active_status=$status";
            if (!empty($language)) $urlFinal .= "&languages=" . strtolower($language);
            if (!empty($type)) $urlFinal .= "&media_type=$type";
            if (!empty($platform)) $urlFinal .= "&publisher_platforms=$platform";
            if (!empty($ad_delivery_date_max)) $urlFinal .= "&ad_delivery_date_max=$ad_delivery_date_max";
            if (!empty($initialDate)) $urlFinal .= "&ad_delivery_date_min=$initialDate"; //Search for ads delivered after the date (inclusive) you provide. The date format should be YYYY-mm-dd.
            if (!empty($paginas)) $urlFinal .= "&limit=$paginas";
            
            //echo '11:00:27 - <h3>Dump 20 </h3> <br><br>' . var_dump($urlFinal); exit;					//<-------DEBUG

            //$urlFinal = "&ad_type=ALL&ad_reached_countries=BR&ad_active_status=ACTIVE&ad_delivery_date_min=2024-01-01&media_type=ALL&limit=100";
            //echo '' . var_dump($urlFinal); exit;					//<-------DEBUG
            $adList = $this->getAds($urlFinal);

            if ((!is_null($adList)) and ($adList['sucesso'])){
                $adListResult = json_decode($adList['retorno'], true);
                //echo '18:59:43 - <h3>Dump 35 </h3> <br><br>' . var_dump($adListResult); exit;					//<-------DEBUG

                if (isset($adListResult['data'])){
                    foreach ($adListResult['data'] as $key => $value) {
                        $adDetails = $this->isSaved($adListResult['data'][$key]['id'], $adListResult['data'][$key]['page_id'], true);
                        $adListResult['data'][$key]['id'] = ["id" => $adListResult['data'][$key]['id'], "adDetails" => $adDetails];
                    }
                }
            }
        } else {
            $pageId = $this->getpost('pageId', false);
            $keyword = $this->getpost('keyword', true);
            $preFilter = $this->getpost('preFilter', true);
            $status = $this->getpost('status', true);
            $adType = $this->getpost('adType', true);
            $country = $this->getpost('country', true);
            
            $language = $this->getpost('language', true);
            $type = $this->getpost('type', true);
            $platform = $this->getpost('platform', true);
            $searchType = $this->getpost('searchType',true);
            $initialDate = $this->getpost('initialDate',true);
            $ad_delivery_date_max = $this->getpost('ad_delivery_date_max',true);
            $paginas = $this->getpost('paginas',true);
        }

        $dados['pageTitle'] = "Ads - Listar Ads";
        $dados['statusView'] = $statusView;
        $dados['keyword'] = $keyword;
        $dados['preFilter'] = $preFilter;
        $dados['country'] = $country;
        $dados['type'] = $type;
        $dados['pageId'] = $pageId;
        $dados['adType'] = $adType;
        $dados['status'] = $status;
        $dados['language'] = $language;
        $dados['platform'] = $platform;
        $dados['searchType'] = $searchType;
        $dados['initialDate'] = $initialDate;
        $dados['ad_delivery_date_max'] = $ad_delivery_date_max;
        $dados['paginas'] = $paginas;
        $dados['adList'] = $adList;
        $dados['adListResult'] = $adListResult;
        $dados['favoritos'] = $favoritos;
        $dados['pages'] = $pages;
        $dados['groups'] = $groups;

        return $this->loadpage('ads/listar_ads', $dados);
    }

    public function getAds($params){
        $headers = $this->getHeader();
		$url = META_GRAPH_API . "ads_archive?access_token=". META_TOKEN . ($params);
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


    //salva ads por palavra chave para identifiar paginas com grande volumes de ads.
    //http://localhost/InsightSuite/public/ads-load
    //https://insightsuite.pravoce.io/ads-load
    public function loadMiner(){

        $group = "WL";
        //$group = "COPY2";
        $limit = 1000;
        $ad_delivery_date_max = date('Y-m-d', strtotime('-5 days')); //anuncios antes dessa data
        $ad_delivery_date_min = date('Y-m-d', strtotime('-5 days')); //anuncios depois dessa data

        $keywords = [
            // urlencode("weight"),
            // urlencode("loss"),
            // urlencode("burnning"),
            // urlencode("slim"),
            // urlencode("belly"),
            // urlencode("diet"),
            // urlencode("burn"),
            // urlencode("fat"),
            // urlencode("food"),
            // urlencode("meal"),
            // urlencode("transformation"),
            // urlencode("calories"),
            // urlencode("healthy"),
            // urlencode("keto"),
            // urlencode("fasting"),
            // urlencode("inches"),
            // urlencode("metabolism"),
            // urlencode("cravings"),
            // urlencode("hormone"),
            // urlencode("hunger"),
            // urlencode("ozempic"),
            // urlencode("semaglutide"),
            // urlencode("liraglutide"),
            // urlencode("saxenda"),
            // urlencode("wegovy"),
            urlencode("Mounjaro"),
            urlencode("zepbound"),
            // urlencode("tirzepatide"),
            // urlencode("GLP-1"),
            // urlencode("GLP1"),
            // urlencode("GIP"),
            // urlencode("appetite"),
            // urlencode("sugar"),
            // urlencode("carbs"),
            // urlencode("carbohydrate"),
            // urlencode("calorie"),
            // urlencode("stubborn"),
            // urlencode("detox"),
            // urlencode("thermogenics"),
            // urlencode("boost"),
            // urlencode("cleanse"),
            // urlencode("gut"),
            // urlencode("serotonin"),
            // urlencode("satiety"),
            // urlencode("microbiome"),
            // urlencode("digestion"),
            // urlencode("immune"),
            // urlencode("ingredients"),
            // urlencode("recipe"),
            // urlencode("tea"),
            // urlencode("obesity"),
            // urlencode("bariatric"),
        ];

        // $keywords = [
        //     urlencode("copywriting"),
        //     urlencode("copywriter"),
        // ];


        $totalAdd = 0;

        foreach ($keywords as $keyword) {
            $url = '&search_terms=' . $keyword . '&search_type=KEYWORD_UNORDERED&ad_type=ALL&ad_reached_countries=US&ad_active_status=ACTIVE&media_type=VIDEO&publisher_platforms=INSTAGRAM&ad_delivery_date_min=' . $ad_delivery_date_min  . '&limit=' . $limit;
            $adList = $this->getAds($url);

            if ((!is_null($adList)) and ($adList['sucesso'])){
                $adListResult = json_decode($adList['retorno'], true);

                if (isset($adListResult['data'])){
                    foreach ($adListResult['data'] as $key => $value) {
                        $id_ad = $adListResult['data'][$key]['id'];
                        $pageId = $adListResult['data'][$key]['page_id'];
                        
                        $adItem = $this->dbMaster->select('ads_pages', ['id_ad' => $id_ad]);
                        $isBlocked = $this->dbMaster->select('ads_saved', ['pageId' => $pageId, 'action' => 'dislike'])['existRecord'];

                        if ((!$adItem['existRecord']) and (!$isBlocked)) {
                            $data = [
                                'pageId' => $pageId,
                                'ad_snapshot_url' => $adListResult['data'][$key]['ad_snapshot_url'],
                                'ad_delivery_start_time' => $adListResult['data'][$key]['ad_delivery_start_time'],
                                'id_ad' => $id_ad,
                                'keyword' => $keyword,
                                'group' => $group,
                            ];

                            $added = $this->dbMaster->insert('ads_pages',$data);
                            $totalAdd++; 
                        }
                    }
                }
            } else {
                $adListResult = json_decode($adList['retorno'], true);
                echo 'Error: ' . $adListResult['error']['message'] . '<br>';
            }
            sleep(rand(1, 5));
        }
        echo "<br><br>Pages Added: $totalAdd <br>";
    }

    //http://localhost/InsightSuite/public/ads-load
    //https://insightsuite.pravoce.io/ads-load
    public function loadMiner_old(){
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
