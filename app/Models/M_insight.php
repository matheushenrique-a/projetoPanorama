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

        return $notificacoes;
    }

    function gerarTimelineNotificacoes($limit = 7)
    {
        $html = '<div class="timeline">';
        $tituloInicial = "";
        $i = 0;

        $notificacoes = $this->load_notifications($limit);
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
            "ADESÃO" => "Adesão",
            "AUDITORIA" => "Auditoria",
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
                        'ultimo_status' => $status_original
                    ];
                    $this->dbMasterDefault->update('quid_propostas', $data, $whereCheck);
                    $atualizados++;
                }
            }
        }
    }

    protected $allowedFields = [
        'adesao',
        'cpf',
        'nome',
        'assessor',
        'produto',
        'valor',
        'telefone',
        'data_criacao',
        'panorama_id',
        'report_to',
        'codigo_entidade',
        'valor_parcela',
        'numero_parcela',
        'matricula',
        'dataNascimento',
        'ultimo_status'
    ];

    public function importarEmMassa(array $data)
    {
        if (empty($data)) {
            return redirect()
                ->to(urlInstitucional . 'insight-listar-propostas/0/upload')
                ->with('error', 'Nenhum dado para importar.');
        }

        $tabela = 'quid_propostas';
        $inseridos = 0;

        foreach ($data as $linha) {
            $whereCheck = ['adesao' => $linha['adesao']];
            $registro = $this->dbMasterDefault->select($tabela, $whereCheck);

            if (!$registro['existRecord']) {
                $this->dbMasterDefault->insert($tabela, $linha);
                $inseridos++;
            }
        }

        if ($inseridos > 0) {
            return redirect()
                ->to(urlInstitucional . 'insight-listar-propostas/0/upload')
                ->with('success', "$inseridos registros importados com sucesso!");
        } else {
            return redirect()
                ->to(urlInstitucional . 'insight-listar-propostas/0/upload')
                ->with('error', 'Nenhum novo registro foi importado.');
        }
    }
}
