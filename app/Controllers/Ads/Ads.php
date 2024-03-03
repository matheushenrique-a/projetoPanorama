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
        $this->checkSession();

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

        $actionTaken = $this->isSaved($adId, $pageId, false);
        $newStatus = "";
        
        if ($actionTaken == "none"){
            $newStatus = $action;
            $this->dbMaster->insert('ads_saved', array('userId' => $this->session->userId, "adId" => $adId, "keyword" => $keyword, "action" => $action, "pageId" => $pageId, "url" => $url, "createDate" => $createDate));
        
        } else if (($actionTaken == "dislike") and ($action == "dislike")){ 
            $newStatus = 'view';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId], ['last_update' => 'current_timestamp()']);

        } else if (($actionTaken == "dislike") and ($action == "saved")){ 
            $newStatus = 'saved';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId], ['last_update' => 'current_timestamp()']);

        } else if (($actionTaken == "dislike") and ($action == "view")){ 
            $newStatus = 'dislike';
        
        } else if (($actionTaken == "saved") and ($action == "saved")){
            $newStatus = 'view';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId], ['last_update' => 'current_timestamp()']);
            
        } else if (($actionTaken == "saved") and ($action == "view")){
            //nothing
            $newStatus = "saved";

        } else if (($actionTaken == "saved") and ($action == "dislike")){
            $newStatus = 'dislike';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId], ['last_update' => 'current_timestamp()']);
        
        } else if (($actionTaken == "view") and ($action == "saved")){
            $newStatus = 'saved';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId], ['last_update' => 'current_timestamp()']);

        } else if (($actionTaken == "view") and ($action == "dislike")){
            $newStatus = 'dislike';
            $this->dbMaster->update('ads_saved', ['action' => $newStatus], ['adId' => $adId], ['last_update' => 'current_timestamp()']);
        
        } else if (($actionTaken == "view") and ($action == "view")){
            //nothing
            $newStatus = $action;
        }
    
        //echo  $result;exit;

        $saida = ["newStatus" => $newStatus, "debug" => "AdId: $adId, Keyword: $keyword, Era: $actionTaken, Quer Virar: $action"];
        echo json_encode($saida); 
    }

    public function isSaved($adId, $pageId, $checkPageLevel){
        $actionTaken = $this->dbMaster->select('ads_saved', ['adId' => $adId]);

        if (!$actionTaken['existRecord']){
            if ($checkPageLevel) {
                $actionTakenPageLevel = $this->dbMaster->select('ads_saved', ['pageId' => $pageId]);

                if ($actionTakenPageLevel['existRecord']){
                    return  $actionTakenPageLevel['firstRow']->action;
                } else {
                    return "none";
                }    
            } else {
                return "none";
            }
        } else {
            return  $actionTaken['firstRow']->action;
        }
	}

    public function listarAds(){
        $buscarProp = $this->getpost('buscarProp');
        $favoritos = $this->getpost('favoritos');

        $adList = null;
        $adListResult = null;
        

        if (!empty($favoritos)){
            $this->dbMaster->setOrderBy(array("last_update", "DESC"));
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
            $paginas = $this->getpost('paginas',true);
        } else if (!empty($buscarProp)){
            helper('cookie');

            $preFilter = $this->getpost('preFilter', false);
            if (!empty($preFilter)) {
                $preFilterPars = explode("-", strtolower($preFilter));
                $keyword = $preFilterPars[0];
                $country = strtoupper($preFilterPars[1]);
                $language = $preFilterPars[2];

                //echo "$keyword, $country, $language"; exit;
            } else {
                $keyword = $this->getpost('keyword', false);
                $country = $this->getpost('country', false);
                $language = $this->getpost('language', false);
            }
            $pageId = $this->getpost('pageId', false);
            $adType = $this->getpost('adType', false);
            $status = $this->getpost('status', false);
            $type = $this->getpost('type', false);
            $platform = $this->getpost('platform', false);
            $searchType = $this->getpost('searchType',false);
            $initialDate = $this->getpost('initialDate',false);
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
            Services::response()->setCookie('paginas', $paginas);

            $urlFinal = "";

            if (!empty($keyword)) {
                $urlFinal .= "&search_terms=$keyword";
                if (!empty($searchType)) $urlFinal .= "&search_type=$searchType";
            }
            if (!empty($adType)) $urlFinal .= "&ad_type=$adType";
            if (!empty($pageId)) $urlFinal .= "&search_page_ids=$pageId";
            if (!empty($country)) $urlFinal .= "&ad_reached_countries=$country";
            if (!empty($status)) $urlFinal .= "&ad_active_status=$status";
            if (!empty($language)) $urlFinal .= "&languages=" . strtolower($language);
            if (!empty($type)) $urlFinal .= "&media_type=$type";
            if (!empty($platform)) $urlFinal .= "&publisher_platforms=$platform";
            if (!empty($initialDate)) $urlFinal .= "&initialDate=$initialDate";
            if (!empty($initialDate)) $urlFinal .= "&ad_delivery_date_min=$initialDate";
            if (!empty($paginas)) $urlFinal .= "&limit=$paginas";
            
            //echo '11:00:27 - <h3>Dump 20 </h3> <br><br>' . var_dump($urlFinal); exit;					//<-------DEBUG

            //$urlFinal = "&ad_type=ALL&ad_reached_countries=BR&ad_active_status=ACTIVE&ad_delivery_date_min=2024-01-01&media_type=ALL&limit=100";
            //echo '' . var_dump($urlFinal); exit;					//<-------DEBUG
            $adList = $this->getAds($urlFinal);

            if ((!is_null($adList)) and ($adList['sucesso'])){
                $adListResult = json_decode($adList['retorno'], true);

                if (isset($adListResult['data'])){
                    foreach ($adListResult['data'] as $key => $value) {
                        $actionTaken = $this->isSaved($adListResult['data'][$key]['id'], $adListResult['data'][$key]['page_id'], true);
                        $adListResult['data'][$key]['id'] = ["id" => $adListResult['data'][$key]['id'], "action" => $actionTaken];
                    }
                }
            }
        } else {
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
            $paginas = $this->getpost('paginas',true);
        }

        $dados['pageTitle'] = "Ads - Listar Ads";
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
        $dados['paginas'] = $paginas;
        $dados['adList'] = $adList;
        $dados['adListResult'] = $adListResult;
        $dados['favoritos'] = $favoritos;

        return $this->loadpage('ads/listar_ads', $dados);
    }




    public function getAds($params){
        $headers = $this->getHeader();
		$url = META_GRAPH_API . "ads_archive?access_token=". META_TOKEN . $params;
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

}
