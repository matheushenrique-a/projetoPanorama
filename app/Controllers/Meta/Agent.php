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
use App\Models\M_meta;

class Agent extends BaseController
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
        $this->meta =  new m_meta();
    }

    //http://localhost/InsightSuite/public/ai-manager
    //http://insightsuite.pravoce.io/ai-manager
    public function aiManager(){
        $account = '328587016319669';
        $cpg = '120210958927260213';
        $adSet = '120210958927290213';

        $data_inicial = date("Y-m-d");
        $data_final = date("Y-m-d");
        $statusArray = '["ACTIVE", "PAUSED"]';
        $dataPreset = 'today';

        $cpgList = $this->listCPGsAdSets("campaigns", $account, $dataPreset, $statusArray);

        if ($cpgList['existRecord']){
            foreach ($cpgList['data']['data'] as $key => $value) {
                $fbDataCpg = $this->extractCPGAdSetData($cpgList['data'], $key);
                //echo $fbDataCpg['idCpg'] . "-" . $fbDataCpg['campanha'] . "<br>";

                if ($fbDataCpg['idCpg'] == $cpg) {
                    //echo "Campanha encontrada<br>";

                    if ($fbDataCpg['configured_status'] == "ACTIVE"){
                        //$this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - CAMPANHA LOCALIZADA, INICIANDO ANÁLISE...", telegramPraVoceDigital);

                        $adSetList = $this->listCPGsAdSets("adsets", $fbDataCpg['idCpg'], $dataPreset, $statusArray);
                        //echo '23:51:51 - <h3>Dump 60 </h3> <br><br>' . var_dump($adSetList['data']['data']); exit;					//<-------DEBUG
                        if ($adSetList['existRecord']){
                            //$this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - LISTANDO ADSETS DA CAMPANHA...", telegramPraVoceDigital);

                            $matchAdSet = false;

                            foreach ($adSetList['data']['data'] as $key => $value) {
                                $fbDataAdSet = $this->extractCPGAdSetData($adSetList['data'], $key);
    
                                if ($fbDataAdSet['idCpg'] == $adSet) {
                                    $matchAdSet = true;
                                    //$this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - ADSET ENCONTRADO, INICIANDO ANÁLISE DE ROAS...", telegramPraVoceDigital);

                                    $fbDataPayAdSet = $this->getInsights($cpg, $adSet,  $fbDataCpg['cpgType'], $fbDataAdSet['daily_budget'], $fbDataAdSet['budget_remaining'], $data_inicial,  $data_final);
                                    //echo "<h4>ADSET FOUND: " . $fbDataAdSet['daysUpdated'] . " - " . $fbDataPayAdSet['impressions'] . " - " . $fbDataAdSet['daily_budget'] . "</h4>";
                                    //echo "Adset: " . $fbDataAdSet['idCpg'] . " - " . $fbDataAdSet['campanha'];
                                    //echo '10:03:46 - <h3>fbDataPayAdSet </h3> <br><br>' . var_dump($fbDataPayAdSet);
                                    //echo '10:03:46 - <h3>fbDataCpg </h3> <br><br>' . var_dump($fbDataCpg);
                                    //echo '10:03:46 - <h3>fbDataAdSet </h3> <br><br>' . var_dump($fbDataAdSet);

                                    //array(22) { ["lp"]=> string(4) "1554" ["ic"]=> int(138) ["pix"]=> string(1) "6" ["sales"]=> string(2) "28" ["abandoned"]=> int(0) ["billet"]=> string(1) "2" ["declined"]=> string(1) "1" ["pixbol"]=> int(8) ["revenue"]=> string(6) "1129.5" ["impressions"]=> string(5) "24076" ["reach"]=> string(5) "21826" ["ctr"]=> string(8) "5.133743" ["cpm"]=> string(9) "73.211912" ["clicks"]=> string(4) "1236" ["daily_budget"]=> int(5000) ["cpc"]=> float(1.4260922275987) ["costPerImpression"]=> float(0.073211912) ["cost"]=> float(1762.649993312) ["roas"]=> float(0.64079653038643) ["result"]=> float(-633.149993312) ["bugdet_used"]=> float(35.253) ["last_update"]=> string(10) "2024-09-27" } 10:03:46 -
                                    //array(11) { ["campanha"]=> string(54) "CPG 1 | 1-5-1 | ESCALA | PRECE | ABO | MGPT-ORACAO-97" ["idCpg"]=> string(18) "120210958927260213" ["budget_remaining"]=> int(0) ["amount_spent"]=> int(0) ["daily_budget"]=> int(0) ["configured_status"]=> string(6) "ACTIVE" ["cpgType"]=> string(3) "ABO" ["updated_time"]=> string(19) "2024-09-27 06:00:02" ["daysUpdated"]=> string(1) "0" ["offer"]=> string(13) "ORACAO-DIVINA" ["ticket"]=> string(2) "97" } 10:03:46 -
                                    //array(10) { ["campanha"]=> string(71) "ADSET 2O | 1-5-1 | ACREDITA | ESCALA | PRECE | CBO | MGPT-PR-TE-151-67" ["idCpg"]=> string(18) "120210958927290213" ["budget_remaining"]=> float(3237.35) ["amount_spent"]=> float(1762.65) ["daily_budget"]=> int(5000) ["configured_status"]=> string(6) "ACTIVE" ["cpgType"]=> string(3) "CBO" ["updated_time"]=> string(19) "2024-09-25 13:45:47" ["daysUpdated"]=> string(1) "1" ["ticket"]=> string(2) "67" } 10:03:46 -

                                    //exit;
                                    //echo "<div>Ticket: " . $fbDataCpg['ticket'] . " | Daily Budget: " . $fbDataPayAdSet['daily_budget'] . " | Gasto Atual : " . simpleRound($fbDataCpg['amount_spent']) . " | Impressions: " . $fbDataPayAdSet['impressions'] . " | Clicks: " . $fbDataPayAdSet['clicks'] . " |  CTR: " . $fbDataPayAdSet['ctr'] . " | Sales: " . $fbDataPayAdSet['sales'] . " | Result: " . simpleRound($fbDataPayAdSet['result'])  . " | ROAS: " . $fbDataPayAdSet['roas'] . "</div>";

                                    $ticket = $fbDataCpg['ticket'];
                                    $gasto = $fbDataAdSet['amount_spent'];
                                    $deltaGasto = $gasto / $ticket;
                                    $deltaGastoPercent = ($gasto / $ticket) * 100;
                                    $roas = $fbDataPayAdSet['roas'];
                                    $novoOrcamento = $fbDataAdSet['daily_budget'] * 1.15;
                
                                    $strMessage = "";
                                    $output = "";

                                    if ($deltaGasto <= 0.75) {
                                        $strMessage = "⚪️ MANTER: campanha gastou menos de 75% do ticket. Gasto/Ticket: " . simpleRound($deltaGastoPercent) . "% | Ticket: " . simpleRound($ticket);
                                        $output = "NENHUMA";
                                    } else if ($roas >= 1.15) {
                                        $strMessage = "🟢 AUMENTAR: orçamento para " . simpleRound($novoOrcamento) . " pois o ROAS está positivo. ROAS: " . simpleRound($roas);
                                        $output = "ATUAR MANUALMENTE";
                                    } else if (($fbDataPayAdSet['result']) < -500) {
                                        $strMessage = "🔴 PARAR: limite negativo -500 do dia atingindo. ROAS: " . simpleRound($roas) . ", Gasto: R$ " . simpleRound($gasto) . ", Receita: R$ " . simpleRound($fbDataPayAdSet['revenue']) . ", Resultado: R$ " . simpleRound($fbDataPayAdSet['result']);
                                        $output = "AUTOMÁTICA COM RESULTADO: " . $this->changeStatusCpg($cpg, "PAUSED")['retorno'];
                                    } else  {
                                        $strMessage = "🟠 MANTER ATUAL: ROAS comprometido mas dentro do limite de -500 do dia. ROAS: " . simpleRound($roas) . ", Gasto: R$ " . simpleRound($gasto) . ", Receita: R$ " . simpleRound($fbDataPayAdSet['revenue']) . ", Resultado: R$ " . simpleRound($fbDataPayAdSet['result']);
                                        $output = "NENHUMA";
                                    }
                                    //echo "<br>RECOMENDA: $strMessage - $output";                                   
                                    $this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - RECOMENDAÇÃO FINAL " .  $strMessage . " - AÇÃO: " . $output, telegramPraVoceDigital);                                       
                                } else {
                                    //echo "Adset Alternativo: " . $fbDataAdSet['idCpg'] . " - " . $fbDataAdSet['campanha'] . "<br>";
                                }
                            }
                            if (!$matchAdSet){
                                $this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - ADSET DA ESCALA NÃO LOCALIZADO DENTRO DA CAMPANHA! VERIFICAR ESTRUTURA.", telegramPraVoceDigital);
                            }
                        } else {
                            $this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - NENHUM ADSET ENCONTRADO NA CAMPANHA. VERIFICAR ESTRUTURA.", telegramPraVoceDigital);
                            //echo "Nenhum Adset encontrado<br>";
                        }
                    } else if ($fbDataCpg['configured_status'] == "PAUSED") {
                        $this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - A CAMPANHA ESTÁ PARADA, NADA A ANALISAR.", telegramPraVoceDigital);
                    } else {
                        $this->telegram->notifyTelegramGroup("🤖🤖🤖 META BOT - STATUS CAMPANHA NÃO IDENTIFICADO: " . $fbDataCpg['configured_status'], telegramPraVoceDigital);
                    }
                }
            }
        }
    } 

    //http://localhost/InsightSuite/public/import-data
    //http://insightsuite.pravoce.io/import-data
    public function importData2(){
        $cpgList = null;
        $cpgListResult = null;
        $data_inicial = date("Y-m-d");
        $data_final = date("Y-m-d");
        
        //$statusArray = '["ACTIVE", "PAUSED"]';
        $statusArray = '["ACTIVE"]';
        $dataPreset = 'today';

        $account = [];
        $account[] = ['conta' => 'MGPT', 'id' => '328587016319669'];
        $account[] = ['conta' => 'OFC', 'id' => '397934202905061'];
        $account[] = ['conta' => 'PVC', 'id' => '1557752151343685'];
        $account[] = ['conta' => 'VAN', 'id' => '339022398063345'];

        $cleanQuery = "delete from vsl_facebook_data where (last_update >= '$data_inicial 00:00:00' and last_update <= '$data_final 23:59:59');";                          
        $this->dbMaster->runQueryGeneric($cleanQuery);

        foreach ($account as $keyAcct => $value) {
            $fbData = [];
            $cpgList = $this->listCPGsAdSets("campaigns", $account[$keyAcct]['id'], $dataPreset, $statusArray);
            if ($cpgList['existRecord']){
                foreach ($cpgList['data']['data'] as $key => $value) {
                    $fbDataCpg = $this->extractCPGAdSetData($cpgList['data'], $key);
                    
                    //if (strpos($fbDataCpg['campanha'], "| ESCALA | PRECE") === false) continue;
                    if ($fbDataCpg['daysUpdated'] > 7) continue;
                    //if (strpos($fbDataCpg['campanha'], "TESTE") !== false) continue;

                    $fbDataAcct['actName'] = $account[$keyAcct]['conta'];
                    $fbDataAcct['actId'] =  $account[$keyAcct]['id'];
                    $fbDataAcct['cpgType'] =  $fbDataCpg['cpgType'];

                    $fbDataPay = $this->getInsights($fbDataCpg['idCpg'],  $fbDataAcct['cpgType'], $fbDataCpg['daily_budget'], $fbDataCpg['budget_remaining'], $data_inicial,  $data_final);
                    echo "<div style='font-size: 28px; font-weight: 600'>" . $fbDataCpg['campanha'] . " (" . $fbDataAcct['cpgType'] . ") " . $fbDataCpg['idCpg'] .  "</div>";

                    if ($fbDataPay['impressions'] == 0) continue;
                    
                    if ($fbDataAcct['cpgType'] == "CBO"){
                        echo "<div>Ticket: " . $fbDataCpg['ticket'] . " | Daily Budget: " . $fbDataPay['daily_budget'] . " | Gasto Atual : " . simpleRound($fbDataCpg['amount_spent']) . " | Impressions: " . $fbDataPay['impressions'] . " | Clicks: " . $fbDataPay['clicks'] . " |  CTR: " . $fbDataPay['ctr'] . " | Sales: " . $fbDataPay['sales'] . " | Result: " . simpleRound($fbDataPay['result'])  . " | ROAS: " . $fbDataPay['roas'] . "</div>";
                
                        $ticket = $fbDataCpg['ticket'];
                        $gasto = abs($fbDataCpg['amount_spent']);
                        $deltaGasto = $gasto / $ticket;
                        $deltaGastoPercent = ($gasto / $ticket) * 100;
                        $roas = $fbDataPay['roas'];
                        $novoOrcamento = $fbDataPay['daily_budget'] * 1.3;
    
                        if ($deltaGasto <= 0.75) {
                            echo "<div style='font-size: 22px;color: green'>MANTER: campanha gastou menos de 75% do ticket. Gasto/Ticket: " . simpleRound($deltaGastoPercent) . "% | Ticket: " . simpleRound($ticket) . "</div>";
                        } else if ($roas >= 1.15) {
                            echo "<div style='font-size: 22px;color: blue'>AUMENTAR: orçamento para " . simpleRound($novoOrcamento) . " pois o ROAS está positivo. ROAS: " . simpleRound($roas) . "</div>";
                        } else if (($roas >= 0.90) and ($roas < 1.15)) {
                            echo "<div style='font-size: 22px;color: orange'>MANTER: ROAS já está comprometido. ROAS: " . simpleRound($roas) . "</div>";
                        } else if ($roas < 0.90) {
                            echo "<div style='font-size: 22px;color: red'>PARAR: perda de ROAS com gasto suficietne. ROAS: " . simpleRound($roas) . ", Gasto/Ticket: " . simpleRound($deltaGastoPercent) . "%</div>";
                         
                            //$result = $this->M_meta->changeStatusCpg($fbDataCpg['idCpg'], "PAUSED");
                            //echo "<div style='font-size: 18px;color: red'" . ($result['sucesso'] ? 'SUCESSO' : 'ERRO') . " - "  . $result['retorno'] . "</div>";
                        }
                        
                        $added = $this->dbMaster->insert('vsl_facebook_data', $fbDataAcct + $fbDataCpg + $fbDataPay);
                    } else {
                        $adSetList = $this->listCPGsAdSets("adsets", $fbDataCpg['idCpg'], $dataPreset, $statusArray);

                        if ($adSetList['existRecord']){
                            foreach ($adSetList['data']['data'] as $key => $value) {       
                                $fbDataAdSet = $this->extractCPGAdSetData($adSetList['data'], $key);
                                //if ($fbDataAdSet['daysUpdated'] > 7) continue;

                                $fbDataAdSet['idAdSet'] =  $fbDataAdSet['idCpg']; //ID ADSET no campo correto
                                $fbDataAdSet['idCpg'] = $fbDataCpg['idCpg']; //ID da CPG no lugar do ID ADSET

                                $fbDataPayAdSet = $this->getInsights($fbDataAdSet['idAdSet'],  $fbDataAcct['cpgType'], $fbDataAdSet['daily_budget'], $fbDataAdSet['budget_remaining'], $data_inicial,  $data_final);
                                echo "<h4>ADSET: " . $fbDataAdSet['idAdSet'] . " - " . $fbDataAdSet['campanha'] . " - " . $fbDataAdSet['daysUpdated'] . " - " . $fbDataPayAdSet['impressions'] . "</h4>";

                                if ($fbDataPayAdSet['impressions'] == 0) continue;        
                                $added = $this->dbMaster->insert('vsl_facebook_data', $fbDataAcct + $fbDataAdSet + $fbDataPayAdSet);                                                    
                            }
                        }
                    }
                    unset($fbDataCpg);
                    unset($fbDataAdSet);
                    unset($fbDataPay);
                    unset($fbDataPayAdSet);
                }
            }
        }

        //$this->indicadores_vsl();
    }

    public function getInsights($cpgId, $adSetId, $cpgType, $daily_budget, $budget_remaining, $data_inicial,  $data_final){
        $sqlQuery = "select event, sum(total) total, sum(renda) renda from (
            select event, ip, count(*) total, sum(cId) renda from vsl_campanha_tracker 
            where (last_updated >= '$data_inicial 00:00:01' and last_updated <= '$data_final 23:59:59') 
            and utm_content = '" . $cpgId . "' 
            and referrer not like '%facebookexternalhit%'
            group by event, ip) data
            group by event;";

            //echo '00:39:15 - <h3>Dump 48 </h3> <br><br>' . var_dump($sqlQuery); exit;					//<-------DEBUG
            
        $eventos = $this->dbMaster->runQuery($sqlQuery);

        $fbData['lp'] = 0; //Vsl-Product-Pass
        $fbData['ic'] = 0; //Vsl-Pay-oracao-L0-171
        $fbData['pix'] = 0; //Vsl-Product-Pix-Created
        $fbData['sales'] = 0; //Vsl-Product-Order-Approved
        $fbData['abandoned'] = 0; //Vsl-Product-Cart-Abandoned
        $fbData['billet'] = 0; //Vsl-Product-Billet-Created
        $fbData['declined'] = 0; //Vsl-Product-Order-Rejected
        $fbData['pixbol'] = 0; //Vsl-Product-Order-Rejected
        $fbData['revenue'] = 0; //VSL-PRODUCT-ORDER-APPROVED

        foreach ($eventos["result"]->getResult() as $row){
            $evento = strtoupper($row->event);

            if (strpos($evento, "VSL-PRODUCT-PASS-") !== false){
                $fbData['lp'] = $row->total;
            } else if (strpos($evento, "VSL-PAY-") !== false){
                $fbData['ic'] += $row->total;
            } else if ($evento == 'VSL-PRODUCT-PIX-CREATED'){
                $fbData['pix'] = $row->total;
            } else if ($evento == 'VSL-PRODUCT-ORDER-APPROVED'){
                $fbData['sales'] = $row->total;
                $fbData['revenue'] = $row->renda;
            } else if ($evento == 'VSL-PRODUCT-CART-ABANDONED'){
                $fbData['abandoned'] = $row->total;
            } else if ($evento == 'VSL-PRODUCT-BILLET-CREATED'){
                $fbData['billet'] = $row->total;
            } else if ($evento == 'VSL-PRODUCT-ORDER-REJECTED'){
                $fbData['declined'] = $row->total;
            }
            //echo $evento . "-" . $row->total . '<br>';
        }
        $fbData['pixbol'] = $fbData['pix'] + $fbData['billet'];
        //echo '20:55:09 - <h3>Dump 29 </h3> <br><br>' . var_dump($fbData); exit;					//<-------DEBUG

        $adDetails = $this->getCpgsInsights($adSetId, $data_inicial, $data_final);
        $detailsFull = json_decode($adDetails['retorno'], true);

        //echo '10:17:09 - <h3>Dump 23 </h3> <br><br>' . var_dump($detailsFull); exit;					//<-------DEBUG

        $impressions = 0;
        $cpm = 0;
        if (isset($detailsFull['data'][0])){

            


            // $daily_budgetMeta = isset($detailsFull['data'][0]['daily_budget']);
            // if (($daily_budgetMeta) and (empty($daily_budget))) {
            //     $daily_budget
            // }

            $impressions = $detailsFull['data'][0]['impressions'];
            $fbData['impressions'] = $impressions;
            $fbData['reach'] = $detailsFull['data'][0]['reach'];

            $fbData['ctr'] = (isset($detailsFull['data'][0]['website_ctr'])  ? $detailsFull['data'][0]['website_ctr'][0]['value'] : 0);
            $cpm = (isset($detailsFull['data'][0]['cpm'])  ? $detailsFull['data'][0]['cpm'] : 0);
            $fbData['cpm'] = $cpm;
            $fbData['clicks'] = (isset($detailsFull['data'][0]['inline_link_clicks'])  ? $detailsFull['data'][0]['inline_link_clicks'] : 0);
        }

        $fbData['impressions'] = $impressions;
        $fbData['daily_budget'] = $daily_budget;

        if ($impressions == 0) return $fbData;

        //cost de dias antigos não vem na API então da prioridade ao calculo manual quando existe cpm
        if (($cpm > 0)) {
            $costPerImpression = $cpm / 1000;
            $cost = $costPerImpression * $impressions;														
        } else {
            $cost = $daily_budget-$budget_remaining;
        }

        if ($fbData['clicks'] > 0) {
            $fbData['cpc'] = $cost / $fbData['clicks'];
        }

        $revenue = $fbData['revenue'];

        $fbData['costPerImpression'] = $costPerImpression;
        $fbData['cost'] = $cost;
        $roas = ($cost != 0 ? $revenue/$cost : '0');
        $fbData['roas'] = $roas;
        $result =  abs($revenue) - abs($cost);
        
        //echo "cost: $cost, receita: $revenue, resultado: $result";exit;
        $fbData['result'] = $result;
        $used = ($daily_budget != 0 ? (($daily_budget-$budget_remaining)/$daily_budget)*100 : '0');
        
        $fbData['bugdet_used'] = $used;
        $fbData['last_update'] = $data_inicial;

       

        return $fbData;
    }


    public function listCPGsAdSets($idType, $cpgId, $dataPreset, $statusArray){
        $urlFinal = ($idType == "campaigns"  ? "act_" : '') . $cpgId . "/$idType?access_token=" . META_TOKEN;
        $urlFinal .= "&fields=" . urlencode("name,daily_budget,budget_remaining,configured_status,start_time,updated_time");
        $urlFinal .= "&date_preset=$dataPreset&limit=100&effective_status=" . urlencode($statusArray);

        $headers = $this->getHeader();
		$url = META_GRAPH_API . $urlFinal;
		///echo $url;exit;
        //$url = urlencode($url);
		//echo $url;exit;
        $result =  $this->http_request('GET', $url, $headers);

        if ((!is_null($result)) and ($result['sucesso'])){
            $adSetListResult = json_decode($result['retorno'], true);

            if (isset($adSetListResult['data'])){
                return ['existRecord' => true, 'data' => $adSetListResult];
            } else {
                return ['existRecord' => false];
            }
        } else {
            return ['existRecord' => false];
        }
	}

    public function extractCPGAdSetData($cpgListResult, $key){
        //echo '23:10:15 - <h3>Dump 66 </h3> <br><br>' . var_dump($cpgListResult); exit;					//<-------DEBUG
        $fbData['campanha'] = $cpgListResult['data'][$key]['name'];
        $fbData['idCpg'] = $cpgListResult['data'][$key]['id'];

        $budget_remaining = $cpgListResult['data'][$key]['budget_remaining'];
        $budget_remaining = $budget_remaining / 100;
        $fbData['budget_remaining'] = $budget_remaining;

        $daily_budget = (isset($cpgListResult['data'][$key]['daily_budget'])  ? $cpgListResult['data'][$key]['daily_budget'] : '0');
        $daily_budget = $daily_budget / 100;
        $fbData['amount_spent'] = $daily_budget - $budget_remaining;

        $fbData['daily_budget'] = $daily_budget;
        $fbData['configured_status'] = $cpgListResult['data'][$key]['configured_status'];

        $fbData['cpgType'] = "ABO";
        if (isset($cpgListResult['data'][$key]['daily_budget'])) $fbData['cpgType'] = "CBO"; //only CBO has daily budget

        $updated_time = $cpgListResult['data'][$key]['updated_time'];
        
        $date = new \DateTime($updated_time);
        $updated_time = $date->format('Y-m-d H:i:s');
        $fbData['updated_time'] = $updated_time;

        $date = new \DateTime($updated_time);
        $today = new \DateTime();
        $interval = $date->diff($today);
        $daysUpdated = $interval->format('%a');
        $fbData['daysUpdated'] = $daysUpdated;
        //echo $cpgListResult['data'][$key]['name'] . "-" . $daysUpdated . "<br>";

        if ($daysUpdated > 7) return $fbData;

        $cpgArray = explode("|", $fbData['campanha']);
        $utmContent =  trim($cpgArray[count($cpgArray)-1]); //ultima parte do nome da campanha precis ter o UTM Content 
        $UtmContentDetails = explode("-", $utmContent);
        $ticketSale = ($UtmContentDetails[count($UtmContentDetails)-1]);
        $oferta = "-" . strtoupper(($UtmContentDetails[1])) . "-";

        $slugLookUp = $this->dbMaster->select('vsl_product_term', ['term' => $oferta]);
        if ($slugLookUp['existRecord']) $fbData['offer'] = strtoupper($slugLookUp['firstRow']->slug);
        
        $fbData['ticket'] = $ticketSale;
        return $fbData;
    }

    //http://localhost/InsightSuite/public/indicadores-vsl
    //http://insightsuite.pravoce.io/indicadores-vsl
    public function indicadores_vsl(){
        $cpgList = null;
        $cpgListResult = null;
        $data_inicial = date("Y-m-d");
        $data_final = date("Y-m-d");        

        // $data_inicial = '2024-08-01';
        // $data_final = '2024-08-03';

        $sqlQuery = "select actName, sum(impressions) impressions, sum(clicks) clicks, avg(ctr) ctr, 
        avg(cpm) cpm, sum(ic) ic, sum(sales) sales, sum(cost) cost, sum(revenue) revenue, 
        avg(roas) roas, sum(result) result, max(DATE_FORMAT(inserted_date,'%H:%i')) hora, count(actName) cpgs
        from vsl_facebook_data 
        where (last_update >= '$data_inicial 00:00:00' and last_update <= '$data_final 23:59:59') 
        group by actName;";

        $accts = $this->dbMaster->runQuery($sqlQuery);

        foreach ($accts["result"]->getResult() as $row){
            $actName = strtoupper($row->actName);
            $cpgs = $row->cpgs;
            $impressions = $row->impressions;
            $clicks = $row->clicks;
            $ctr = $row->ctr;
            $cpm = $row->cpm;
            $ic = $row->ic;
            $sales = $row->sales;
            $cost = $row->cost;
            $revenue = $row->revenue;
            $roas = $row->roas;
            $result = $row->result;
            $hora = $row->hora;

            if ($impressions > 0){
                $roas = ($cost != 0 ? $revenue/$cost : '0');
                $ctr = ($impressions != 0 ? ($clicks/$impressions) * 100 : '0');
                $cpm = ($impressions != 0 ? ($cost/$impressions) * 1000 : '0');

                $strFilaAgora = "<b>🌟🌟🌟 $actName - CPGS $cpgs - $hora</b>\n";
                $strFilaAgora .= "Impressões: " . $impressions . "\n";
                $strFilaAgora .= "Clicks: " . $clicks . "\n";
                $strFilaAgora .= "CTR: " . simpleRound($ctr) . "%\n";
                $strFilaAgora .= "CPM: R$ " . simpleRound($cpm) . "\n";
                $strFilaAgora .= "ICs: " . $ic . "\n";
                $strFilaAgora .= "-----\n";
                $strFilaAgora .= "Vendas: " . $sales . "\n";
                $strFilaAgora .= "Custo: R$ " . simpleRound($cost) . "\n";
                $strFilaAgora .= "Receita: R$ " . simpleRound($revenue) . "\n";

                $strFilaAgora .= "ROAS: " . simpleRound($roas) . "\n";
                $strFilaAgora .= "Resultado: R$ " . simpleRound($result) . "\n";
    
                $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDigital);
            }
        }

        //RECUPERAÇÕES:
        $sqlQuery = "select event, sum(cId) revenue, count(cId) vendas from vsl_campanha_tracker 
            where (last_updated >= '$data_inicial 00:00:00' and last_updated <= '$data_final 23:59:59')
            and (event = 'Vsl-Product-Order-Approved')
            and utm_campaign = 'recuperacao'
            group by event;";

        $recuperacao = $this->dbMaster->runQuery($sqlQuery);
        
        if ($recuperacao['existRecord']){
            $recRevenue = $recuperacao['firstRow']->revenue;
            $recVendas = $recuperacao['firstRow']->vendas;
        } else {
            $recRevenue = 0;
            $recVendas = 0;
        }

        $strFilaAgora = "<b>🌟🌟🌟 RECUPERACOES </b>\n";
        $strFilaAgora .= "Vendas: " . $recVendas . "\n";
        $strFilaAgora .= "Receita: " . simpleRound($recRevenue) . "\n";

        if ($recVendas > 0){
            $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDigital);
        }

        //COMPENSACOES:
        $sqlQuery = "select event, sum(cId) revenue, count(cId) vendas 
                    from vsl_campanha_tracker
                    where event = 'Vsl-Product-Order-Approved'
                    and (inserted_date >= '$data_inicial' and inserted_date <= '$data_final 23:59:59')
                    and last_updated < '$data_inicial 00:00:00'
                     group by event;";

        $comp = $this->dbMaster->runQuery($sqlQuery);
        
        if ($comp['existRecord']){
            $compRevenue = $comp['firstRow']->revenue;
            $compVendas = $comp['firstRow']->vendas;
        } else {
            $compRevenue = 0;
            $compVendas = 0;
        }

        $strFilaAgora = "<b>🌟🌟🌟 COMPENSACOES </b>\n";
        $strFilaAgora .= "Vendas: " . $compVendas . "\n";
        $strFilaAgora .= "Receita: " . simpleRound($compRevenue) . "\n";

        if ($compVendas > 0){
            $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDigital);
        }

        $sqlQuery = "select last_update, sum(impressions) impressions, sum(clicks) clicks, avg(ctr) ctr, 
        avg(cpm) cpm, sum(ic) ic, sum(sales) sales, sum(cost) cost, sum(revenue) revenue, 
        avg(roas) roas, sum(result) result, max(DATE_FORMAT(inserted_date,'%H:%i')) hora, count(actName) cpgs
        from vsl_facebook_data 
        where (last_update >= '$data_inicial 00:00:00' and last_update <= '$data_final 23:59:59') 
        group by last_update;";

        $geral = $this->dbMaster->runQuery($sqlQuery);

        if ($geral['existRecord']){
            $cpgs = strtoupper($geral['firstRow']->cpgs);
            $impressions = strtoupper($geral['firstRow']->impressions);
            $clicks = strtoupper($geral['firstRow']->clicks);
            $ctr = strtoupper($geral['firstRow']->ctr);
            $cpm = strtoupper($geral['firstRow']->cpm);
            $ic = strtoupper($geral['firstRow']->ic);
            $sales = strtoupper($geral['firstRow']->sales);
            $cost = strtoupper($geral['firstRow']->cost);
            $revenue = strtoupper($geral['firstRow']->revenue);
            $roas = strtoupper($geral['firstRow']->roas);
            $result = strtoupper($geral['firstRow']->result);
            $hora = strtoupper($geral['firstRow']->hora);

            $ctr = ($impressions != 0 ? ($clicks/$impressions) * 100 : '0');
            $cpm = ($impressions != 0 ? ($cost/$impressions) * 1000 : '0');

            $strFilaAgora = "<b>🌟🌟🌟 GERAL - CPGS $cpgs - $hora</b>\n";
            $strFilaAgora .= "Impressões: " . $impressions . "\n";
            $strFilaAgora .= "Clicks: " . $clicks . "\n";
            $strFilaAgora .= "CTR: " . simpleRound($ctr) . "%\n";
            $strFilaAgora .= "CPM: R$ " . simpleRound($cpm) . "\n";
            $strFilaAgora .= "ICs: " . $ic . "\n";
            $strFilaAgora .= "-----\n";
            $strFilaAgora .= "Vendas: " . ($sales + $recVendas + $compVendas) . "\n";
            $strFilaAgora .= "Custo: R$ " . simpleRound($cost) . "\n";

            $receitaGeral = $revenue + $recRevenue + $compRevenue;
            $roasGeral = ($cost != 0 ? $receitaGeral/$cost : '0');

            $strFilaAgora .= "Receita: R$ " . simpleRound($receitaGeral) . "\n";
            $strFilaAgora .= "ROAS: " . simpleRound($roasGeral) . "\n";
            $strFilaAgora .= "Resultado: R$ " . simpleRound($receitaGeral-$cost) . "\n";

            $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDigital);
        }

         //PRODUTO:
         $sqlQuery = "select pt.slug, count(utm_term) vendas, sum(cid) receita from vsl_campanha_tracker ct inner join vsl_product_term pt on ct.utm_term = pt.term
            where (ct.last_updated >= '$data_inicial 00:00:01' and ct.last_updated <= '$data_final 23:59:59')
            and (event = 'Vsl-Product-Order-Approved')
            group by pt.slug;";

        $produto = $this->dbMaster->runQuery($sqlQuery);

        if ($produto['existRecord']){
            $strFilaAgora = "<b>🌟🌟🌟 OFERTAS </b>\n";
            foreach ($produto["result"]->getResult() as $row){
                $oferta = strtoupper($row->slug);
                $vendas = strtoupper($row->vendas);
                $receita = strtoupper($row->receita);

                $sqlQueryOffer = "select offer, sum(cost) cost
                                    from vsl_facebook_data 
                                    where (last_update >= '$data_inicial 00:00:00' and last_update <= '$data_final 23:59:59') 
                                    and offer = '$oferta'
                                    group by offer;";

                $offerCost = $this->dbMaster->runQuery($sqlQueryOffer);
                $costVendaTotal =  0;
                $roiOffer = 0;

                if ($offerCost['existRecord']){
                    $costVendaTotal = $offerCost['firstRow']->cost;
                    $roiOffer = ($costVendaTotal != 0 ? $receita/$costVendaTotal : '0');
                    $roiOffer = simpleRound($roiOffer);
                }

                $strFilaAgora .= "$oferta - $vendas - R$ " . simpleRound($receita) .  " - (R$ $costVendaTotal) - ROAS $roiOffer \n";
            }

            $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDigital);
        }
         
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
