<?php

namespace App\Controllers\Fgts;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\dbMaster;
use App\Models\M_telegram;

class Indicadores extends BaseController
{
    protected $session;
    protected $dbMasterDefault;
    protected $telegram;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger) {
        parent::setDB("fgtsDB"); //passa o banco de dados diferente do default (opcional) antes de iniciar o controler
        parent::initController($request, $response, $logger);
        //nesse caso o dbMaster vai apontar para o banco FGTS

        //o dbMasterDefault vai apontar para o banco do InsightSuite
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
    }

    //http://localhost/InsightSuite/public/indicadores-diarios
    public function indicadores_diarios(){
        //$statusFilaAgora = $this->dbMaster->runQuery("select statusProposta, count(*) total from proposta_fgts where statusProposta IN ('CRIADA', 'PASSO 02 - SIMULACAO ONLINE', 'PASSO 02 - SIMULACAO OFFLINE', 'PASSO 03 - DADOS PESSOAIS', 'PASSO 03.1 - DADOS PESSOAIS DOCUMENTOS', 'PASSO 04 - DADOS RESIDENCIAIS', 'PASSO 05 - DADOS BANCÁRIOS', 'PASSO 06 - REVISAO FINAL', 'PASSO 06 - CADASTRO PENDENTE', 'PASSO 07 - GRAVADA OFFLINE', 'PASSO 07 - GRAVADA ONLINE', 'PASSO 08 - PROPOSTA DISPONÍVEL', 'PASSO 08 - FORMALIZAÇÃO FEITA', 'PASSO 08 - AGUARDANDO PAGAMENTO', 'PASSO 08 - PAGAMENTO EM ATRASO', 'PASSO 08 - PENDENTE DOCUMENTO', 'PASSO 08 - LENTIDÃO CAIXA', 'PASSO 08 - CLIENTE VULNERÁVEL', 'PASSO 08 - MENSAGEM DIRETA', 'PASSO 08 - BANCO INVÁLIDO', 'PASSO 08 - PROPOSTA SELECIONADA', 'PASSO 08 - APP CONFIGURADO') group by statusProposta order by total desc;");
        
        $propostasPagas30 = $this->dbMaster->runQuery("select '- ONTEM - ' statusProposta, count(verificador) numero, sum(valor_pago) valor from proposta_fgts_finalizadas where DATE(data_criacao) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)
        UNION ALL
        select '- 7 DIAS - ' statusProposta, count(verificador) numero, sum(valor_pago) valor from proposta_fgts_finalizadas where DATE(data_criacao) >= DATE_SUB(CURDATE(), INTERVAL 8 DAY)
        UNION ALL
        select '- 30 DIAS - ' statusProposta, count(verificador) numero, sum(valor_pago) valor from proposta_fgts_finalizadas where DATE(data_criacao) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        UNION ALL
        select '- TOTAL GERAL - ' statusProposta, count(verificador) numero, sum(valor_pago) valor from proposta_fgts_finalizadas ;");

        $strFilaAgora = "<b>💰💰💰 PAGAS - RECENTEMENTE </b>\n";      
        foreach ($propostasPagas30["result"]->getResult() as $row){
            $strFilaAgora .= $row->statusProposta . $row->numero . ' - R$' . simpleRound($row->valor) . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);
        //echo $strFilaAgora;
        //exit;

        $top5FontesPagamento = $this->dbMaster->runQuery("select UPPER((case when (chave_origem = '' or chave_origem is null) then 'DIRECT' ELSE chave_origem end)) chave_origem, count(valor_pago) total from proposta_fgts_finalizadas where DATE(data_criacao) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by chave_origem order by total desc LIMIT 7;");
        $strFilaAgora = "<b>📈📈📈 ORIGEM PAGAS - ONTEM</b>\n";
        foreach ($top5FontesPagamento["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->chave_origem) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);    
        //echo "<br><br>" . $strFilaAgora;
        //exit;

        $top30FontesPagamento = $this->dbMaster->runQuery("select UPPER((case when (chave_origem = '' or chave_origem is null) then 'DIRECT' ELSE chave_origem end)) chave_origem, count(valor_pago) total from proposta_fgts_finalizadas where DATE(data_criacao) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) group by chave_origem order by total desc LIMIT 7;");
        $strFilaAgora = "<b>📈📈📈 ORIGEM PAGAS - 30 DIAS</b>\n";
        foreach ($top30FontesPagamento["result"]->getResult() as $row){ 
            $strFilaAgora .= "- " . strtoupper($row->chave_origem) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);    
        //echo "<br><br>" . $strFilaAgora;
        //exit;

        ///// ORIGEM PAGAS
        $top5FontesTrafego = $this->dbMaster->runQuery("select UPPER((case when (utm_campaign = '' or utm_campaign is null) then 'DIRECT' ELSE utm_campaign end)) utm_campaign, count(*) total from campanha_click_count where DATE(last_updated) > DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by utm_campaign order by total desc LIMIT 7;");
        $strFilaAgora = "<b>🔗🔗🔗 CLICK COUNT - ONTEM </b>\n";
        foreach ($top5FontesTrafego["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->utm_campaign) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);    
        //echo "<br><br>" . $strFilaAgora;
       // exit;

        ///// ORIGEM PAGAS
        $top5FontesTrafego = $this->dbMaster->runQuery("select UPPER((case when (utm_campaign = '' or utm_campaign is null) then 'DIRECT' ELSE utm_campaign end)) utm_campaign, count(*) total from campanha_click_count where DATE(last_updated) > DATE_SUB(CURDATE(), INTERVAL 7 DAY) group by utm_campaign order by total desc LIMIT 7;");
        $strFilaAgora = "<b>🔗🔗🔗 CLICK COUNT - 7 DIAS </b>\n";
        foreach ($top5FontesTrafego["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->utm_campaign) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);    
        //echo "<br><br>" . $strFilaAgora;
        // exit;
       
        ///// NOVOS CLIENTES
        $clientesOntem = $this->dbMaster->runQuery("select count(*) total  from proposta_fgts where DATE(data_criacao) = DATE((DATE_SUB(CURDATE(), INTERVAL 1 DAY)));");
        $clientes7Dias = $this->dbMaster->runQuery("select count(*) total  from proposta_fgts where DATE(data_criacao) > DATE((DATE_SUB(CURDATE(), INTERVAL 8 DAY)));");
        $clientes30Dias = $this->dbMaster->runQuery("select count(*) total  from proposta_fgts where DATE(data_criacao) > DATE((DATE_SUB(CURDATE(), INTERVAL 30 DAY)));");
        $strFilaAgora = "<b>✅✅✅ NUM NOVOS CLIENTES </b>\n";
        $strFilaAgora .= "- ONTEM - " . $clientesOntem['firstRow']->total . "\n";
        $strFilaAgora .= "- 7 DIAS - " . $clientes7Dias['firstRow']->total . "\n";
        $strFilaAgora .= "- 30 DIAS - " . $clientes30Dias['firstRow']->total . "\n";

        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);    
        //echo "<br><br>" . $strFilaAgora;
        //exit;

        ///// ORIGEM DOS NOVOS CLIENTES
        $top20OriCli = $this->dbMaster->runQuery("select UPPER((case when (chave_origem = '' or chave_origem is null) then 'DIRECT' ELSE chave_origem end)) chave_origem, count(verificador) total from proposta_fgts where DATE(data_criacao) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by chave_origem order by total desc LIMIT 7;");
        $strFilaAgora = "<b>✅✅✅ ORIGEM N.CLI. ONTEM </b>\n";
        foreach ($top20OriCli["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->chave_origem) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);    
        //echo "<br><br>" . $strFilaAgora;
        //exit;

        ///// ORIGEM DOS NOVOS CLIENTES
        $top20OriCli30 = $this->dbMaster->runQuery("select UPPER((case when (chave_origem = '' or chave_origem is null) then 'DIRECT' ELSE chave_origem end)) chave_origem, count(verificador) total from proposta_fgts where DATE(data_criacao) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) group by chave_origem order by total desc LIMIT 7;");
        $strFilaAgora = "<b>✅✅✅ ORIGEM N.CLI. 30 DIAS </b>\n";
        foreach ($top20OriCli30["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->chave_origem) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);    
        //echo "<br><br>" . $strFilaAgora;
        //exit;
    }

    //http://localhost/InsightSuite/public/metricas-semanais
    public function metricas_semanais($data_inicial = null, $data_final = null){

        if (is_null($data_inicial) or (is_null($data_final))) {
            $data_inicial = date("Y-m-d");
            $data_final = date("Y-m-d", strtotime("-7 days"));

        }
        $clicksCpg = $this->dbMaster->runQuery("select slug, count(*) total from campanha_click_count where (last_updated >= '$data_inicial 00:00:01' and last_updated <= '$data_final 23:59:59') group by slug order by slug, total desc limit 100;");
        $numPropostas = $this->dbMaster->runQuery("select 'Total Propostas' slug, count(*) total from proposta_fgts where data_criacao > '$data_inicial 00:00:01' and data_criacao < '$data_final 23:59:59';");
        $numPropostasPagas = $this->dbMaster->runQuery("select 'Número Propostas pagas' slug, count(*) total from proposta_fgts_finalizadas where data_criacao > '$data_inicial 00:00:01' and data_criacao < '$data_final 23:59:59' order by data_criacao asc limit 500 ;");
        $vlrPropostasPagas = $this->dbMaster->runQuery("select 'Valor Propostas pagas' slug, sum(valor_pago) total from proposta_fgts_finalizadas where data_criacao > '$data_inicial 00:00:01' and data_criacao < '$data_final 23:59:59' order by data_criacao asc limit 500 ;");

        $strFilaAgora = "<b><h2>🔗🔗🔗 CLICKS CAMPANHAS - DE $data_inicial A $data_final</h2><br>";
        foreach ($clicksCpg["result"]->getResult() as $row){
            $strFilaAgora .= strtoupper($row->slug . ' - ' . $row->total . "<br>");
        }
        echo $strFilaAgora;

        $strFilaAgora = "<b><h2>✅✅✅ NUMERO CADASTROS EFETIVOS - DE $data_inicial A $data_final</h2><br>";
        foreach ($numPropostas["result"]->getResult() as $row){
            $strFilaAgora .= strtoupper($row->slug . ' - ' . $row->total . "<br>");
        }
        echo $strFilaAgora;

        $strFilaAgora = "<b><h2>✅✅✅ NUMERO PROPOSTAS PAGAS - DE $data_inicial A $data_final</h2><br>";
        foreach ($numPropostasPagas["result"]->getResult() as $row){
            $strFilaAgora .= strtoupper($row->slug . ' - ' . $row->total . "<br>");
        }
        echo $strFilaAgora;

        $strFilaAgora = "<b><h2>💰💰💰 NUMERO PROPOSTAS PAGAS - DE $data_inicial A $data_final</h2><br>";
        foreach ($vlrPropostasPagas["result"]->getResult() as $row){
            $strFilaAgora .= strtoupper($row->slug . ' - ' . $row->total . "<br>");
        }
        echo $strFilaAgora;

        ///// ORIGEM PAGAS
        $top5FontesTrafego = $this->dbMaster->runQuery("select UPPER((case when (utm_campaign = '' or utm_campaign is null) then 'DIRECT' ELSE utm_campaign end)) utm_campaign, count(*) total from campanha_click_count where (last_updated >= '$data_inicial 00:00:01' and last_updated <= '$data_final 23:59:59') group by utm_campaign order by total desc LIMIT 15;");
        $strFilaAgora = "<br><br><b>🔗🔗🔗 CLICK COUNT </b><br>";
        foreach ($top5FontesTrafego["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->utm_campaign) . ' - ' . $row->total . "<br>";
        }
        echo $strFilaAgora;

        ///// ORIGEM DOS NOVOS CLIENTES
        $top20OriCli = $this->dbMaster->runQuery("select UPPER((case when (chave_origem = '' or chave_origem is null) then 'DIRECT' ELSE chave_origem end)) chave_origem, count(verificador) total from proposta_fgts where (data_criacao >= '$data_inicial 00:00:01' and data_criacao <= '$data_final 23:59:59') group by chave_origem order by total desc LIMIT 15;");
        $strFilaAgora = "<br><br><b>✅✅✅ ORIGEM N.CLI. </b><br>";
        foreach ($top20OriCli["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->chave_origem) . ' - ' . $row->total . "<br>";
        }
        echo $strFilaAgora;
        
        $top5FontesPagamento = $this->dbMaster->runQuery("select UPPER((case when (chave_origem = '' or chave_origem is null) then 'DIRECT' ELSE chave_origem end)) chave_origem, count(valor_pago) total from proposta_fgts_finalizadas where (data_criacao >= '$data_inicial 00:00:01' and data_criacao <= '$data_final 23:59:59') group by chave_origem order by total desc LIMIT 15;");
        $strFilaAgora = "<br><br><b>📈📈📈 ORIGEM PAGAS</b><br>";
        foreach ($top5FontesPagamento["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->chave_origem) . ' - ' . $row->total . "<br>";
        }
        echo $strFilaAgora;
    }




    public function indicadores_esteira(){
        $statusFilaAgora = $this->dbMaster->runQuery("select statusProposta, count(*) total from proposta_fgts where statusProposta IN ('CRIADA', 'PASSO 02 - SIMULACAO ONLINE', 'PASSO 02 - SIMULACAO OFFLINE', 'PASSO 03 - DADOS PESSOAIS', 'PASSO 03.1 - DADOS PESSOAIS DOCUMENTOS', 'PASSO 04 - DADOS RESIDENCIAIS', 'PASSO 05 - DADOS BANCÁRIOS', 'PASSO 06 - REVISAO FINAL', 'PASSO 06 - CADASTRO PENDENTE', 'PASSO 07 - GRAVADA OFFLINE', 'PASSO 07 - GRAVADA ONLINE', 'PASSO 08 - PROPOSTA DISPONÍVEL', 'PASSO 08 - FORMALIZAÇÃO FEITA', 'PASSO 08 - AGUARDANDO PAGAMENTO', 'PASSO 08 - PAGAMENTO EM ATRASO', 'PASSO 08 - PENDENTE DOCUMENTO', 'PASSO 08 - LENTIDÃO CAIXA', 'PASSO 08 - CLIENTE VULNERÁVEL', 'PASSO 08 - MENSAGEM DIRETA', 'PASSO 08 - BANCO INVÁLIDO', 'PASSO 08 - PROPOSTA SELECIONADA', 'PASSO 08 - APP CONFIGURADO') group by statusProposta order by total desc;");
        $propostasPagasHoje = $this->dbMaster->runQuery("select p.statusProposta, count(p.statusProposta) numero, sum(valor_pago) valor from proposta_fgts p inner join proposta_fgts_gravacao_json g on p.id_proposta = g.id_proposta where p.statusProposta = 'PASSO 09 - PROPOSTA FINALIZADA' and DATE(p.last_update) = CURDATE() group by p.statusProposta;");
        $apiPAN = $this->dbMaster->runQuery("select status, count(*) total from api_log where banco='PAN' and DATE(last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by status, banco order by total;");
        $apiFACTA = $this->dbMaster->runQuery("select status, count(*) total from api_log where banco='FACTA' and DATE(last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by status, banco order by total;");
        $top5FontesTrafego = $this->dbMaster->runQuery("select utm_campaign, count(*) total from campanha_click_count where DATE(last_updated) = CURDATE() group by utm_campaign order by total desc LIMIT 10;");
        
        $strFilaAgora = "⭐️⭐️⭐️ <b> PRODUÇÃO </b> ⭐️⭐️⭐️\n\n";
        $strFilaAgora .= "<b>📦📦📦 ESTEIRA AGORA:</b>\n";
        
        foreach ($statusFilaAgora["result"]->getResult() as $row){
            $propostaSimples = trim(propostaFaseFormatSimples($row->statusProposta));
            $strFilaAgora .= "- " . ($propostaSimples == "PROPOSTA SELECIONADA"  ? "🚨🚨 " : "") . $propostaSimples . " - " . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora);

        $strFilaAgora = "<b>✅✅✅ FINALIZADAS - HOJE</b>\n";      
        foreach ($propostasPagasHoje["result"]->getResult() as $row){
            $propostaSimples = propostaFaseFormatSimples($row->statusProposta);
            $strFilaAgora .= "- " .  $propostaSimples . ' - ' . $row->numero . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora);

        $strFilaAgora = "<b>👩🏻‍🔧👩🏻‍🔧👩🏻‍🔧 ORIGEM CLIENTES - HOJE </b>\n";
        foreach ($top5FontesTrafego["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->slug) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora);


        // $strApi = "<b>🏦🏦🏦 API PAN - ONTEM </b>\n";
        // foreach ($apiPAN["result"]->getResult() as $row){
        //     $strApi .= "- " . strtoupper($row->status) . ' - ' . $row->total . "\n";
        // }
        // $output = $this->telegram->notifyTelegramGroup($strApi);

        // $strApi = "<b>🏦🏦🏦 API FACTA - ONTEM </b>\n";
        // foreach ($apiFACTA["result"]->getResult() as $row){
        //     $strApi .= "- " . strtoupper($row->status) . ' - ' . $row->total . "\n";
        // }
        // $output = $this->telegram->notifyTelegramGroup($strApi);
    }    

}
