<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\M_bmg;

class ProcessJobs extends BaseCommand
{
    protected $group       = 'Mailing';
    protected $name        = 'mailing:process';
    protected $description = 'Processa jobs de mailing pendentes';

    public function run(array $params = [])
    {
        $baseDir = WRITEPATH;
        $jobsDir = $baseDir . 'jobs/';
        $pendentesDir = $jobsDir . 'pendentes/';
        $processandoDir = $jobsDir . 'processando/';
        $concluidosDir = $jobsDir . 'concluidos/';
        $resultadosDir = $jobsDir . 'resultados/';

        // Cria pastas se não existirem
        foreach ([$pendentesDir, $processandoDir, $concluidosDir, $resultadosDir] as $dir) {
            if (!is_dir($dir)) mkdir($dir, 0777, true);
        }

        // Verifica se já existe algum job em processamento
        $processando = glob($processandoDir . '*.json');
        if (count($processando) > 0) {
            CLI::write("Um job já está em processamento. Saindo.", 'yellow');
            return;
        }

        // Pega o primeiro job pendente
        $pendentes = glob($pendentesDir . '*.json');
        if (count($pendentes) === 0) {
            CLI::write("Nenhum job pendente encontrado. Saindo.", 'yellow');
            return;
        }

        $jobFile = $pendentes[0];
        $jobData = json_decode(file_get_contents($jobFile), true);

        // Move para processando
        $jobId = $jobData['id'];
        $newJobFile = $processandoDir . basename($jobFile);
        rename($jobFile, $newJobFile);

        // Atualiza status
        $jobData['status'] = 'processando';
        $jobData['progresso'] = 0;
        $jobData['total'] = count($jobData['cpfs']);
        $jobData['concluidos'] = 0;
        file_put_contents($newJobFile, json_encode($jobData, JSON_PRETTY_PRINT));

        // Instancia model
        $model = new M_bmg();

        // Processa CPFs com callback para atualizar progresso
        $dados = [
            'produto' => $jobData['produto'],
            'valorMinimo' => $jobData['valorMinimo'],
            'valorMaximo' => $jobData['valorMaximo'],
            'entidade' => $jobData['entidade'],
            'cpfs' => $jobData['cpfs'],
        ];

        if ($jobData['produto'] === 'seguro') {
            $resultadoCSV = $model->gerarMailingSeguro($dados, $jobId, function ($concluidos, $total) use (&$jobData, $newJobFile) {
                $jobData['concluidos'] = $concluidos;
                $jobData['progresso'] = round(($concluidos / $total) * 100, 2);
                file_put_contents($newJobFile, json_encode($jobData, JSON_PRETTY_PRINT));
            });
        } else {
            $resultadoCSV = $model->gerarMailingSaque($dados, $jobId, function ($concluidos, $total) use (&$jobData, $newJobFile) {
                $jobData['concluidos'] = $concluidos;
                $jobData['progresso'] = round(($concluidos / $total) * 100, 2);
                file_put_contents($newJobFile, json_encode($jobData, JSON_PRETTY_PRINT));
            });
        }

        // Finaliza job
        $jobData['status'] = 'concluido';
        $jobData['progresso'] = 100;
        file_put_contents($newJobFile, json_encode($jobData, JSON_PRETTY_PRINT));

        // Move para concluídos
        rename($newJobFile, $concluidosDir . basename($newJobFile));

        CLI::write("Job {$jobId} concluído. CSV gerado em: {$resultadoCSV}", 'green');
    }
}
