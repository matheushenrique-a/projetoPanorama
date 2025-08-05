<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\dbMaster;
use App\Models\M_telegram;
use App\Models\M_http;
use Symfony\Component\Panther\Client;

class M_insight extends Model
{
    protected $dbMasterDefault;
    protected $session;
    protected $telegram;
    protected $m_http;

    public function __construct()
    {
        $this->dbMasterDefault = new dbMaster();
        $this->session = session();
        $this->telegram =  new M_telegram();
        $this->m_http =  new M_http();
    }

    public function load_notifications($limit = 7)
    {
        $userId = $this->session->userId;
        $role = $this->session->role;
        $notificacoes = null;

        // if ($role == "OPERADOR") {
        //     $sqlQuery = 'SELECT * from insight_notificacoes where userId = ' . $userId .  '  and notifica_user = TRUE order by id DESC LIMIT '. $limit . ';';
        //     $notificacoes = $this->dbMasterDefault->runQuery($sqlQuery);		
        // } else if ($role == "SUPERVISOR") {
        //     $sqlQuery = 'SELECT * from insight_notificacoes where userId = ' . $userId .  '  and notifica_supervisor = TRUE order by id DESC LIMIT '. $limit . ';';
        //     $notificacoes = $this->dbMasterDefault->runQuery($sqlQuery);		
        // } else if ($role == "GERENTE") {
        //     $sqlQuery = 'SELECT * from insight_notificacoes where userId = ' . $userId .  '  and notifica_manager = TRUE order by id DESC LIMIT '. $limit . ';';
        //     $notificacoes = $this->dbMasterDefault->runQuery($sqlQuery);		
        // } else {
        //     echo 'Usuário sem ROLE definida, contact o administrador';exit;
        // }
        return $notificacoes;
    }

    function gerarTimelineNotificacoes($limit = 7)
    {
        $html = '<div class="timeline">';
        $tituloInicial = "";
        $i = 0;

        $notificacoes = $this->load_notifications($limit);

        // if (!$notificacoes['existRecord']){
        //     return '<div class="timeline">Nenhuma notificação localizada!<br></div>';
        // } else {
        //     foreach ($notificacoes["result"]->getResult() as $row) {
        //         $json_detalhes = $row->json_detalhes;
        //         $detalhes = json_decode($json_detalhes, true);
        //         $tipo = $row->tipo;
        //         $titulo = $row->titulo;
        //         $data_criacao = $row->data_criacao;

        //         $icon = "";

        //         if ($tituloInicial != $titulo) {
        //             $tituloInicial = $titulo;
        //             if ($i > 0) {
        //                 $html .= '</div></div></div>'; // Fecha bloco anterior
        //             }
        //             $i++;

        //             $html .= '<div class="timeline-item">';
        //             $html .= '<div class="timeline-line w-40px"></div>';
        //             $html .= '<div class="timeline-icon symbol symbol-circle symbol-40px me-4">
        //                         <div class="symbol-label bg-light">
        //                             <span class="svg-icon svg-icon-2 svg-icon-gray-500">
        //                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        //                                     <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor" />
        //                                     <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor" />
        //                                 </svg>
        //                             </span>
        //                         </div>
        //                     </div>';
        //             $html .= '<div class="timeline-content mb-3 mt-n1">
        //                         <div class="pe-3 mb-5">
        //                             <div class="fs-5 fw-bold mb-2">' . htmlspecialchars($titulo) . '</div>
        //                             <div class="d-flex align-items-center mt-1 fs-6">
        //                                 <div class="text-muted me-2 fs-7">Recebida em ' . dataUsPtHours($data_criacao, true) . '</div>
        //                             </div>
        //                         </div>
        //                         <div class="overflow-auto pb-5">';
        //         }

        //         if (($tipo == 'proposta_criada') || ($tipo == 'proposta_atualizada')) {
        //             if ($row->tipo == "proposta_criada") {
        //                 $icon = "👋🏻 ";
        //             } else if ($row->tipo == "proposta_atualizada") {
        //                 if ((isset($detalhes['statusFinal'])) && ($detalhes['statusFinal'] == 'APROVADA')) {
        //                     $icon = "🎉 ";
        //                 } else if (((strpos(strtoupper($detalhes['statusAdicional']), 'CANCEL') !== false)) || (strpos(strtoupper($detalhes['nomeStatus']), 'CANCEL') !== false)) {
        //                     $icon = "❌ ";
        //                 } else if (((strpos(strtoupper($detalhes['statusAdicional']), 'AGUARDA') !== false)) || (strpos(strtoupper($detalhes['nomeStatus']), 'AGUARDA') !== false)) {
        //                     $icon = "⏱️ ";
        //                 }
        //             }

        //             $html .= '<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-1000px px-7 py-2 mb-2">
        //                         <a href="" class="fs-5 text-dark text-hover-primary fw-semibold w-275px min-w-275px">' . $icon . htmlspecialchars($detalhes['integraallId']) . ' | ' . substr(htmlspecialchars($detalhes['nomeCliente']), 0, 15) . '...</a>
        //                         <div class="min-w-275px pe-2"><span class="badge badge-light-' . getStatusNomePorId($detalhes['statusId'])[2] . '">' . getStatusNomePorId($detalhes['statusId'])[1] . '</span> <span class="badge badge-light-' . getStatusAdicionalPorId($detalhes['statusAdicionalId'])[2] . '">' . getStatusAdicionalPorId($detalhes['statusAdicionalId'])[1] . '</span></div>
        //                         <a href="" class="btn btn-sm btn-light btn-active-light-primary">Detalhes</a>
        //                     </div>';
        //         } else if ($tipo == 'auditoria_whatsapp') {
        //             $icon = ($detalhes['gravidade'] == "alta") ? "🚨 " : "⚠️ ";

        //             $html .= '<div class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-1000px px-7 py-2 mb-2">
        //                         <a href="" class="fs-5 text-dark text-hover-primary fw-semibold w-275px min-w-275px">' . $icon . htmlspecialchars($detalhes['gravidade']) . ' | ' . htmlspecialchars($detalhes['telefone_cliente']) . '</a>
        //                         <div class="min-w-275px pe-2"><span class="badge badge-light text-muted">Feedback: ' . substr(htmlspecialchars($detalhes['frase_feedback']), 0, $limit) . '...</span></div>
        //                         <a href="" class="btn btn-sm btn-light btn-active-light-primary">Detalhes</a>
        //                     </div>';
        //         }
        //     }

        //     $html .= '</div></div></div>'; // fecha último bloco
        //     $html .= '</div>'; // fecha timeline principal

        //     return $html;
        // }


    }

    public function getChat($telefoneWaId)
    {
        $chat = null;
        if ((!empty($telefoneWaId)) and (strlen($telefoneWaId) == 13)) {
            $db =  $this->dbMasterDefault->getDB();
            $builder = $db->table('whatsapp_log');
            $builder->Like('whatsapp_log.To', $telefoneWaId); //bug do número 9 no whatsapp
            $builder->orLike('whatsapp_log.From', $telefoneWaId);
            $builder->orderBy('id', 'DESC');
            $builder->select('*');
            //echo $builder->getCompiledSelect();exit;
            $chat = $this->dbMasterDefault->resultfy($builder->get());
        }
        return $chat;
    }

    public function getJourney($telefoneWaId)
    {
        $journey = null;
        if ((!empty($telefoneWaId)) and (strlen($telefoneWaId) == 13)) {
            //JOURNEY
            $db =  $this->dbMasterDefault->getDB();
            $builder = $db->table('customer_journey');
            $builder->Where('verificador', $telefoneWaId);
            $builder->orderBy('id_interaction', 'DESC');
            $builder->select('*');
            //echo $builder->getCompiledSelect();exit;
            $journey = $this->dbMasterDefault->resultfy($builder->get());
        }
        return  $journey;
    }

    public function atualizar_propostas()
    {
        $url = "https://grupoquid.panoramaemprestimos.com.br/html.do?action=exportarLayout&saida=json&chaveExportacao=a9fX3qV7zT2nP5wLmR8sD1cJ6bU0yH4eKQvZ&layout=33&dias=10";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
        $json = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            echo "cURL Error: " . $err;
            return;
        }

        $json_utf8 = mb_convert_encoding($json, 'UTF-8', 'ISO-8859-1');

        $dados = json_decode($json_utf8, true);

        if (!is_array($dados)) {
            echo "Erro ao decodificar JSON.";
            return;
        }

        $statusMap = [
            "CRÉDITO ENVIADO" => "Aprovada",
            "ANÁLISE BANCO" => "Análise",
            "ADESÃO" => "Pendente",
            "AUDITORIA" => "Pendente",
            "CANCELADA: DECURSO DE PRAZO" => "Cancelada",
            "CANCELADA: CLIENTE" => "Cancelada",
            "CANCELADA: DADOS CADASTRAIS" => "Cancelada",
            "CANCELADA: DADOS BANCÁRIOS" => "Cancelada",
            "CANCELADA POR LIMITE" => "Cancelada",
            "FORMALIZAÇÃO NÃO REALIZADA" => "Pendente",
            "PENDENTE FORMALIZAÇÃO" => "Pendente",
            "TED DEVOLVIDA" => "Pendente",
            "CONTA CORRIGIDA" => "Análise"
        ];

        $atualizados = 0;

        foreach ($dados as $item) {
            $adesao = $item['ADESÃO'];
            $status_original = $item['STATUS'];
            $status_traduzido = isset($statusMap[$status_original]) ? $statusMap[$status_original] : $status_original;

            $whereCheck = ['adesao' => $adesao];
            $resultado = $this->dbMasterDefault->select('quid_propostas', $whereCheck);

            if ($resultado['existRecord']) {
                $registroBanco = $resultado['firstRow'];

                if ($registroBanco->status !== $status_traduzido) {
                    $data = [
                        'status' => $status_traduzido,
                    ];
                    $this->dbMasterDefault->update('quid_propostas', $data, $whereCheck);
                    $atualizados++;
                }
            }
        }
    }
}
