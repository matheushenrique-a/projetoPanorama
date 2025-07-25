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
        $adgroup = $this->getpost('adgroup');

        $adList = null;
        $adListResult = null;
        
        
        //lista todos os ads mas agrupados por páginas para saber quais páginas tem mais ads
        if (!empty($groups)){
            $sql = 'select p.pageId, count(*) total, max(p.ad_snapshot_url) urlAd, max(p.last_update) last_update, s.action, p.group 
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

             if (!empty($adgroup)) {
                if (strpos($sql, 'where') !== false) {
                    $sql .= ' and p.group = "' . $adgroup . '" ';
                } else {
                    $sql .= ' where p.group = "' . $adgroup . '" ';
                }
            }

            $sql .= ' group by pageId, p.group order by total desc limit ' . $paginas . ';';
            ///echo $sql;exit;
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

        $sqlQuery = 'select distinct a.group from ads_pages a order by a.group;';
		$adgroupList = $this->dbMaster->runQuery($sqlQuery);

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
        $dados['adgroup'] = $adgroup;
        $dados['adgroupList'] = $adgroupList;

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

    //http://localhost/InsightSuite/public/ads-savead
    //https://insightsuite.pravoce.io/ads-savead
    public function savead(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204); // No Content
            exit;
        }

        $request = file_get_contents('php://input');

        //$this->telegram->notifyTelegramGroup("🕵🏻‍♀️🕵🏻‍♀️🕵🏻‍♀️ $request", telegramPraVoceDigital);


        //$request = '{"user":"openaccess","url":"https://scontent.fplu6-1.fna.fbcdn.net/o1/v/t2/f2/m69/AQMDHTddLUw8Yvv49fYKfaU4Pr2BShhcY0OpLpfruh912C54tdYOjdxXAIgcNuJsNBN2bNR2kLCAyxVAoXYiOmid.mp4?strext=1&_nc_cat=105&_nc_oc=AdmyEPVtRJ6p8Lqtl4k1Cv9gz3oRn4jW90teh67pXUHSdY4a0UD9dQYomd5w0VdLwjrt5cerEiJQts3nOCJd4NmI&_nc_sid=8bf8fe&_nc_ht=scontent.fplu6-1.fna.fbcdn.net&_nc_ohc=h0ZrqFsf2JEQ7kNvwH5qv7A&efg=eyJ2ZW5jb2RlX3RhZyI6Inhwdl9wcm9ncmVzc2l2ZS5WSV9VU0VDQVNFX1BST0RVQ1RfVFlQRS4uQzMuMzYwLnByb2dyZXNzaXZlX2gyNjQtYmFzaWMtZ2VuMl8zNjBwIiwieHB2X2Fzc2V0X2lkIjoyMzkxOTYyMzQ3NDM4Nzk2MywidmlfdXNlY2FzZV9pZCI6MTAwOTksImR1cmF0aW9uX3MiOjg4LCJ1cmxnZW5fc291cmNlIjoid3d3In0%3D&ccb=17-1&_nc_zt=28&_nc_eui2=AeFMO5Bddis4OxTkNcNrxMXt-5Hx8FuaAob7kfHwW5oChsptU_iSdLmKamqiFeG5bsiaSctQl9uvy--9Qfkw_Ntk&oh=00_AfRikEzfdLzq3uXq3DVy35-PFPCdlGmI1fKmHDKGmbeNtQ&oe=6880D1E9","advertiser":"chefandersonsousa","adText":"🔥 Esse é o tartar que parou a internet… e agora você vai ver quem tá por trás dele.\n\nHoje eu te mostro a receita completa na mão, no olho, do meu jeito.\nNada de truque. Só carne de verdade, tempero de respeito e aquela entrega de alma que a cozinha pede.\n\n📍Direto da Maloca da Tuttapanna, com o chef na linha de frente.\nAssiste até o fim… e me diz se você teria coragem de encarar esse sabor!\n\n👇 Marca quem merece provar esse tartar!\n#TartarÉNaMaloca #ChefAndersonSousa #ComidaComPersonalidade #GastronomiaDeVerdade","libraryId":["1688742229194582"],"dateInfo":"Started running on Jul 18, 2025 · Total active time 4 hrs","thumbnail":"https://scontent.fplu6-1.fna.fbcdn.net/v/t39.35426-6/519535017_762319832881042_3346301328037777203_n.jpg?stp=dst-jpg_s60x60_tt6&_nc_cat=100&ccb=1-7&_nc_sid=c53f8f&_nc_eui2=AeGOvXqgrGIpGHElFvIyNf6xqjHlyDriD5SqMeXIOuIPlIYGPXIjEJqZzPTIBvSXpd52gNVjuWfK1neP_WI0EtoA&_nc_ohc=rwyW5xhMkm8Q7kNvwEVzP6a&_nc_oc=AdmHMQE_bE_ljwcOLb-XE6-207BTlimTUcAatd8wkikoJobuUCXRo5fovbBrcoIxR0cAaLmXbXq5lu5raUKfiuaF&_nc_zt=14&_nc_ht=scontent.fplu6-1.fna&_nc_gid=Vd1_dA-TuvJ46jjorGNZCg&oh=00_AfSjNfj4Z1bET84Bm8CYqNqMSN4ldcP_pRLwk3M3mnJJ8g&oe=6880BFFE"}';
        $response = json_decode($request, true);



        $user = $response['user'] ?? 'NA';
        $url = $response['url'] ?? 'NA';

        $advertiser = $response['advertiser'] ?? '';
        $adText = $response['adText'] ?? '';
        $libraryId = $response['libraryId'] ?? '';
        $dateInfo = $response['dateInfo'] ?? '';
        $thumbnail = $response['thumbnail'] ?? '';

        $adData = [
            'user' => $user,
            'url' => $url,
            'advertiser' => $advertiser,
            'adText' => $adText,
            'libraryId' => $libraryId,
            'dateInfo' => $dateInfo,
            'thumbnail' => $thumbnail
        ];

        $added = $this->dbMasterDefault->insert('ads_extension', $adData);

        $newAd = $this->dbMasterDefault->select('ads_extension', ['id_ads' => $added["insert_id"]]);

        $returnData["guid"] = "";
        if ($newAd['existRecord']){
            $returnData["guid"] = $newAd['firstRow']->guid;
        }
        
        //$this->telegram->notifyTelegramGroup("SAVEAD:\n\nUSER:\n$user\n\nURL:\n$url\n\nANUNCIANTE:\n$advertiser\n\nTEXTO:\n$adText\n\nLIBID:\n$libraryId\n\nDATE:\n$dateInfo\n\nIMG:\n$thumbnail", telegramPraVoceDigital);
        $this->telegram->notifyTelegramGroup("🕵🏻‍♀️🕵🏻‍♀️🕵🏻‍♀️ " . strtoupper($advertiser) . " [$libraryId]\n" . $url, telegramPraVoceDigital);

        $returnData["status"] = true;
        $returnData["mensagem"] = "OK";                
        echo json_encode($returnData);
    }

    //http://localhost/InsightSuite/public/ads-validatetoken
    //https://insightsuite.pravoce.io/ads-validatetoken
    public function validatetoken() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        $request = file_get_contents('php://input');
        $data = json_decode($request, true);
        $token = $data['token'] ?? '';

        // Exemplo simples: token = "abc123"
        $valid = ($token === '123456');

        $this->telegram->notifyTelegramGroup("TOKEN CHECK:\n$token\n$valid\n\n" . $request, telegramQuid);

        echo json_encode(['valid' => $valid]);
    }





    function fetchAds($url, &$allAds){
        do {
            $response = $this->getAds2($url);
            $data = json_decode($response['retorno'], true);

            if (!empty($data['data'])) {
                $allAds = array_merge($allAds, $data['data']);
                //echo '16:06:57 - <h3>Dump 56 </h3> <br><br>' . var_dump($allAds); exit;					//<-------DEBUG
            }

            

            //echo $data['paging']['next'] ?? null;exit;
            $url = $data['paging']['next'] ?? null;

        } while ($url);
    }

    public function getAds2($url){
        $headers = $this->getHeader();
		//$url = META_GRAPH_API . "ads_archive?access_token=". META_TOKEN . ($params);
		//echo $url;exit;
        //$url = urlencode($url);
		//echo $url;exit;
        $result =  $this->http_request('GET', $url, $headers);
        //echo '18:18:12 - <h3>Dump 26 </h3> <br><br>' . var_dump($result); exit;					//<-------DEBUG
		return $result;
	}

    //salva ads por palavra chave para identifiar paginas com grande volumes de ads.
    //http://localhost/InsightSuite/public/ads-load
    //https://insightsuite.pravoce.io/ads-load
    public function loadMiner(){
        $accessToken = META_TOKEN;
        $keywordClean = "natural"; //palavra chave para busca
        $country = 'us'; //país para busca
        $group = $keywordClean; //grupo para busca
        $language = 'en'; //idioma para busca
        $limit = 1000;
        $searchUrl = 'https://graph.facebook.com/v23.0/ads_archive?search_terms=' . $keywordClean . '&ad_type=ALL&languages=' . $language . '&ad_active_status=ACTIVE&ad_reached_countries=' . $country . '&access_token=' . $accessToken . '&ad_delivery_date_min=2025-07-20&media_type=VIDEO&limit=' . $limit . '&ad_delivery_date_max=2025-07-20&unmask_removed_content=true';
        $allAds = [];
        $this->fetchAds($searchUrl, $allAds);

        $i= 0;
        $totalAdd = 0;

        foreach ($allAds as $ad) {
            $i++;
            // echo "Page ID: " . $ad['page_id'] . "<br>";
            // echo "Ad Snapshot URL: " . $ad['ad_snapshot_url'] . "<br>";
            // echo "Ad Delivery Start Time: " . $ad['ad_delivery_start_time'] . "<br>";
            // echo "Ad ID: " . $ad['id'] . "<br>";
            // echo "-----------------------------" . "<br>";
            echo "$i: Page/Ad ID: " . $ad['page_id'] . "/" . $ad['id'] . "<br>";

            $id_ad = $ad['id'];
            $pageId = $ad['page_id'];
            
            $adItem = $this->dbMaster->select('ads_pages', ['id_ad' => $id_ad]);
            $isBlocked = $this->dbMaster->select('ads_saved', ['pageId' => $pageId, 'action' => 'dislike'])['existRecord'];

            //se o ad não existe na tabela ads_pages e não está bloqueado, insere o ad
            if ((!$adItem['existRecord']) and (!$isBlocked)) {
                $data = [
                    'pageId' => $pageId,
                    'ad_snapshot_url' => $ad['ad_snapshot_url'],
                    'ad_delivery_start_time' => $ad['ad_delivery_start_time'],
                    'id_ad' => $id_ad,
                    'keyword' => $keywordClean,
                    'group' => $group,
                ];

                $added = $this->dbMaster->insert('ads_pages',$data);
                $totalAdd++;
            }
        }

        // Exemplo de exibição
        echo "<br><br>Total de anúncios coletados: " . count($allAds) . "<Br>";
        echo "<br>Adicionados: " . ($totalAdd) . "<Br>";
        // print_r($allAds);
        
        exit;

        $group = "";
        $limit = 1000;
        $ad_delivery_date_max = date('Y-m-d', strtotime('-5 days')); //anuncios antes dessa data
        $ad_delivery_date_min = date('Y-m-d', strtotime('-5 days')); //anuncios depois dessa data

        $keywords = [
            [urlencode("Mounjaro"), "WL", 'US'],
            [urlencode("zepbound"), "WL", 'US'],
            [urlencode("quiz.cakto"), "CAKTO-US", 'US'],
            [urlencode("inlead"), "INLEAD-US", 'US'],
            [urlencode("quiz.cakto"), "CAKTO-BR", 'BR'],
            [urlencode("inlead"), "INLEAD-BR", 'BR'],
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
            $keywordClean = $keyword[0];
            $group = $keyword[1];
            $country = $keyword[2];
            $url = '&search_terms=' . $keywordClean . '&search_type=KEYWORD_UNORDERED&ad_type=ALL&ad_reached_countries=' . $country . '&ad_active_status=ACTIVE&media_type=VIDEO&publisher_platforms=INSTAGRAM&ad_delivery_date_min=' . $ad_delivery_date_min  . '&limit=' . $limit;
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
                                'keyword' => $keywordClean,
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
