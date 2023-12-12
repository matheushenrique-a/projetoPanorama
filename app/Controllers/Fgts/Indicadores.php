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

    public function indicadores_diarios(){
        $statusFilaAgora = $this->dbMaster->runQuery("select statusProposta, count(*) total from proposta_fgts where statusProposta IN ('CRIADA', 'PASSO 02 - SIMULACAO ONLINE', 'PASSO 02 - SIMULACAO OFFLINE', 'PASSO 03 - DADOS PESSOAIS', 'PASSO 03.1 - DADOS PESSOAIS DOCUMENTOS', 'PASSO 04 - DADOS RESIDENCIAIS', 'PASSO 05 - DADOS BANCÁRIOS', 'PASSO 06 - REVISAO FINAL', 'PASSO 06 - CADASTRO PENDENTE', 'PASSO 07 - GRAVADA OFFLINE', 'PASSO 07 - GRAVADA ONLINE', 'PASSO 08 - PROPOSTA DISPONÍVEL', 'PASSO 08 - FORMALIZAÇÃO FEITA', 'PASSO 08 - AGUARDANDO PAGAMENTO', 'PASSO 08 - PAGAMENTO EM ATRASO', 'PASSO 08 - PENDENTE DOCUMENTO', 'PASSO 08 - LENTIDÃO CAIXA', 'PASSO 08 - CLIENTE VULNERÁVEL', 'PASSO 08 - MENSAGEM DIRETA', 'PASSO 08 - BANCO INVÁLIDO', 'PASSO 08 - PROPOSTA SELECIONADA', 'PASSO 08 - APP CONFIGURADO') group by statusProposta order by total desc;");
        $propostasPagasOntem = $this->dbMaster->runQuery("select p.statusProposta, count(p.statusProposta) numero, sum(valor_pago) valor from proposta_fgts p inner join proposta_fgts_gravacao_json g on p.id_proposta = g.id_proposta where p.statusProposta = 'PASSO 09 - PROPOSTA FINALIZADA' and DATE(p.last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by p.statusProposta;");
        
        $propostasPagas30 = $this->dbMaster->runQuery("select '- ONTEM - ' titulo, count(valor_pago) propostas, sum(valor_pago) valor from proposta_fgts_finalizadas where DATE(data_pagamento) = DATE((DATE_SUB(CURDATE(), INTERVAL 1 DAY)))
        UNION ALL
        select '- 7 DIAS - ' titulo, count(valor_pago) propostas, sum(valor_pago) valor from proposta_fgts_finalizadas where DATE(data_pagamento) > DATE((DATE_SUB(CURDATE(), INTERVAL 8 DAY)))
        UNION ALL
        select '- 30 DIAS - ' titulo, count(valor_pago) propostas, sum(valor_pago) valor from proposta_fgts_finalizadas where DATE(data_pagamento) > DATE((DATE_SUB(CURDATE(), INTERVAL 30 DAY)))
        UNION ALL
        select '- TOTAL GERAL - ' titulo, count(valor_pago) propostas, sum(valor_pago) valor from proposta_fgts_finalizadas;");

        $top5FontesPagamento = $this->dbMaster->runQuery("select chave_origem, count(*) total from proposta_fgts where DATE(last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) and chave_origem is not null and statusProposta = 'PASSO 09 - PROPOSTA FINALIZADA' group by chave_origem order by total desc LIMIT 10;");
        $top5FontesTrafego = $this->dbMaster->runQuery("select slug, count(*) total from campanha_click_count where DATE(last_updated) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by slug order by total desc LIMIT 10;");
        $apiPAN = $this->dbMaster->runQuery("select status, count(*) total from api_log where banco='PAN' and DATE(last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by status, banco order by total;");
        $apiFACTA = $this->dbMaster->runQuery("select status, count(*) total from api_log where banco='FACTA' and DATE(last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by status, banco order by total;");
 
        $clientesOntem = $this->dbMaster->runQuery("select count(*) total  from proposta_fgts where DATE(data_criacao) = DATE((DATE_SUB(CURDATE(), INTERVAL 1 DAY)));");
        $clientes7Dias = $this->dbMaster->runQuery("select count(*) total  from proposta_fgts where DATE(data_criacao) > DATE((DATE_SUB(CURDATE(), INTERVAL 8 DAY)));");
        $clientes30Dias = $this->dbMaster->runQuery("select count(*) total  from proposta_fgts where DATE(data_criacao) > DATE((DATE_SUB(CURDATE(), INTERVAL 30 DAY)));");


        $strFilaAgora = "⭐️⭐️⭐️ <b> PRODUÇÃO </b> ⭐️⭐️⭐️\n\n";
        $strFilaAgora .= "<b>📦📦📦 ESTEIRA - AGORA:</b>\n";
        
        foreach ($statusFilaAgora["result"]->getResult() as $row){
            $strFilaAgora .= "- " . propostaFaseFormatSimples($row->statusProposta) . " - " . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);

        $strFilaAgora = "<b>💰💰💰 PAGAS - ONTEM</b>\n";      
        foreach ($propostasPagasOntem["result"]->getResult() as $row){
            $strFilaAgora .= "- " . propostaFaseFormatSimples($row->statusProposta) . ' - ' . $row->numero . ' - R$' . simpleRound($row->valor) . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);

        $strFilaAgora = "<b>💰💰💰 PAGAS - RECENTEMENTE </b>\n";      
        foreach ($propostasPagas30["result"]->getResult() as $row){
            $strFilaAgora .= $row->titulo . $row->propostas . ' - R$' . simpleRound($row->valor) . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);
        
        $strFilaAgora = "<b>📈📈📈 ORIGEM PAGAS - ONTEM</b>\n";
        foreach ($top5FontesPagamento["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->chave_origem) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);        

        $strFilaAgora = "<b>👩🏻‍🔧👩🏻‍🔧👩🏻‍🔧 ORIGEM CLIENTES - ONTEM </b>\n";
        foreach ($top5FontesTrafego["result"]->getResult() as $row){
            $strFilaAgora .= "- " . strtoupper($row->slug) . ' - ' . $row->total . "\n";
        }
        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);

        $strFilaAgora = "<b>✅✅✅ NOVOS CLIENTES </b>\n";
        $strFilaAgora .= "- ONTEM - " . $clientesOntem['firstRow']->total . "\n";
        $strFilaAgora .= "- 7 DIAS - " . $clientes7Dias['firstRow']->total . "\n";
        $strFilaAgora .= "- 30 DIAS - " . $clientes30Dias['firstRow']->total . "\n";

        $output = $this->telegram->notifyTelegramGroup($strFilaAgora, telegramPraVoceDiretoria);

        // $strApi = "<b>🏦🏦🏦 API PAN - ONTEM </b>\n";
        // foreach ($apiPAN["result"]->getResult() as $row){
        //     $strApi .= "- " . strtoupper($row->status) . ' - ' . $row->total . "\n";
        // }
        // $output = $this->telegram->notifyTelegramGroup($strApi, telegramPraVoceDiretoria);

        // $strApi = "<b>🏦🏦🏦 API FACTA - ONTEM </b>\n";
        // foreach ($apiFACTA["result"]->getResult() as $row){
        //     $strApi .= "- " . strtoupper($row->status) . ' - ' . $row->total . "\n";
        // }
        // $output = $this->telegram->notifyTelegramGroup($strApi, telegramPraVoceDiretoria);

    }

    public function indicadores_esteira(){
        $statusFilaAgora = $this->dbMaster->runQuery("select statusProposta, count(*) total from proposta_fgts where statusProposta IN ('CRIADA', 'PASSO 02 - SIMULACAO ONLINE', 'PASSO 02 - SIMULACAO OFFLINE', 'PASSO 03 - DADOS PESSOAIS', 'PASSO 03.1 - DADOS PESSOAIS DOCUMENTOS', 'PASSO 04 - DADOS RESIDENCIAIS', 'PASSO 05 - DADOS BANCÁRIOS', 'PASSO 06 - REVISAO FINAL', 'PASSO 06 - CADASTRO PENDENTE', 'PASSO 07 - GRAVADA OFFLINE', 'PASSO 07 - GRAVADA ONLINE', 'PASSO 08 - PROPOSTA DISPONÍVEL', 'PASSO 08 - FORMALIZAÇÃO FEITA', 'PASSO 08 - AGUARDANDO PAGAMENTO', 'PASSO 08 - PAGAMENTO EM ATRASO', 'PASSO 08 - PENDENTE DOCUMENTO', 'PASSO 08 - LENTIDÃO CAIXA', 'PASSO 08 - CLIENTE VULNERÁVEL', 'PASSO 08 - MENSAGEM DIRETA', 'PASSO 08 - BANCO INVÁLIDO', 'PASSO 08 - PROPOSTA SELECIONADA', 'PASSO 08 - APP CONFIGURADO') group by statusProposta order by total desc;");
        $propostasPagasHoje = $this->dbMaster->runQuery("select p.statusProposta, count(p.statusProposta) numero, sum(valor_pago) valor from proposta_fgts p inner join proposta_fgts_gravacao_json g on p.id_proposta = g.id_proposta where p.statusProposta = 'PASSO 09 - PROPOSTA FINALIZADA' and DATE(p.last_update) = CURDATE() group by p.statusProposta;");
        $apiPAN = $this->dbMaster->runQuery("select status, count(*) total from api_log where banco='PAN' and DATE(last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by status, banco order by total;");
        $apiFACTA = $this->dbMaster->runQuery("select status, count(*) total from api_log where banco='FACTA' and DATE(last_update) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) group by status, banco order by total;");
        $top5FontesTrafego = $this->dbMaster->runQuery("select slug, count(*) total from campanha_click_count where DATE(last_updated) = CURDATE() group by slug order by total desc LIMIT 10;");
        
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
