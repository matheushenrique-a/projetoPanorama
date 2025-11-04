<?php

namespace App\Controllers\Bmg;

use App\Controllers\BaseController;
use App\Models\M_bmg;

class Mailing extends BaseController
{
    protected $m_bmg;

    public function index()
    {
        $dados['pageTitle'] = 'Mainling';

        return $this->loadpage('bmg/mailing', $dados);
    }

    public function list()
    {
        helper('filesystem');

        $baseDir = WRITEPATH . 'jobs/';
        $dirs = [
            'Pendentes'    => $baseDir . 'pendentes/',
            'Processando'  => $baseDir . 'processando/',
            'Concluído'   => $baseDir . 'concluidos/',
        ];

        $jobs = [];

        foreach ($dirs as $status => $dir) {
            if (!is_dir($dir)) continue;

            $arquivos = glob($dir . '*.json');
            log_message('debug', "Buscando em {$dir}, encontrados: " . count($arquivos));

            foreach ($arquivos as $arquivo) {
                $data = json_decode(file_get_contents($arquivo), true);
                if (!$data) continue;

                $data['status'] = ucfirst($status);
                $data['arquivo'] = basename($arquivo);
                $data['ultimo_update'] = date('d/m/Y H:i:s', filemtime($arquivo));
                $data['_mtime'] = filemtime($arquivo);

                // Limitar os dados exibidos (sem CPFs)
                unset($data['cpfs']);

                $jobs[] = $data;
            }
        }

        // Ordena pelo último update (mais recente primeiro)
        usort($jobs, fn($a, $b) => ($b['_mtime'] ?? 0) <=> ($a['_mtime'] ?? 0));

        $dados = [
            'pageTitle' => 'Mailing - Processos',
            'jobs' => $jobs
        ];

        return $this->loadpage('bmg/mailing_list', $dados);
    }

    public function generate()
    {
        helper(['filesystem']);

        $produto = $this->request->getPost('produto');
        $valorMinimo = $this->request->getPost('valorMinimo') ?? "";
        $valorMaximo = $this->request->getPost('valorMaximo') ?? "";
        $entidade = $this->request->getPost('entidade');

        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['erro' => 'Arquivo inválido']);
        }

        $uploadDir = WRITEPATH . 'uploads/jobs/';
        $jobsPendentes = WRITEPATH . 'jobs/pendentes/';

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        if (!is_dir($jobsPendentes)) mkdir($jobsPendentes, 0777, true);

        $jobId = uniqid('job_', true);
        $filePath = $uploadDir . $jobId . '.csv';
        $file->move($uploadDir, $jobId . '.csv');

        $handle = fopen($filePath, 'r');
        $cpfs = [];
        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            $cpf = trim($data[0] ?? '');
            if (!empty($cpf) && strtolower($cpf) !== 'cpf') {
                $cpfs[] = $cpf;
            }
        }
        fclose($handle);

        $jobData = [
            'id' => $jobId,
            'arquivo' => $filePath,
            'produto' => $produto,
            'valorMinimo' => $valorMinimo,
            'valorMaximo' => $valorMaximo,
            'entidade' => $entidade,
            'cpfs' => $cpfs,
            'status' => 'pendente',
            'progresso' => 0,
            'total' => count($cpfs),
            'concluidos' => 0,
            'criado_em' => date('Y-m-d H:i:s')
        ];

        file_put_contents($jobsPendentes . $jobId . '.json', json_encode($jobData, JSON_PRETTY_PRINT));

        return redirect()->to('/mailing')->with('success', 'Job de mailing criado com sucesso!');
    }

    public function download($jobId)
    {
        $jobsConcluidos = WRITEPATH . 'jobs/resultados/';
        $pattern = $jobsConcluidos . $jobId . '_resultado*.csv';

        $arquivos = glob($pattern);

        if (empty($arquivos)) {
            return 'Arquivo de resultado não encontrado.';
        }

        $jobFile = $arquivos[0];

        return $this->response->download($jobFile, null);
    }

    public function delete($jobId)
    {
        $dirs = [
            WRITEPATH . 'jobs/pendentes/',
            WRITEPATH . 'jobs/processando/',
            WRITEPATH . 'jobs/concluidos/',
            WRITEPATH . 'jobs/resultados/',
        ];

        foreach ($dirs as $dir) {
            $jsonFile = $dir . $jobId . '.json';
            if (file_exists($jsonFile)) {
                unlink($jsonFile);
            }

            $csvPattern = $dir . $jobId . '*.csv';
            $csvFiles = glob($csvPattern);
            foreach ($csvFiles as $csvFile) {
                unlink($csvFile);
            }
        }

        return redirect()->to('/mailing/list');
    }

    public function gerarSaque($cpf){
        $this->m_bmg = new M_bmg();

        $result = $this->m_bmg->gerarMailingSaque($cpf);

        return var_dump($result);
    }
}
