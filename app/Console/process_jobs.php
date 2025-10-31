<?php

// Força exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "[START] Executando ProcessJobs...\n";

// Garante que o script rode na raiz do projeto
chdir(__DIR__ . '/../../');

// Inclui autoload e inicialização do CodeIgniter
require 'vendor/autoload.php';
require_once 'app/Config/Paths.php';

$paths = new Config\Paths();
require_once rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

// Define ambiente de execução
$context = APPPATH . 'Config/Boot/production.php';
if (file_exists($context)) {
    require_once $context;
}

use App\Commands\ProcessJobs;
use Config\Services;

try {
    echo "[INFO] CodeIgniter carregado. Criando instâncias...\n";

    // Instancia serviços necessários para o comando
    $commands = service('commands');
    $logger   = service('logger');

    echo "[INFO] Executando comando ProcessJobs...\n";

    // Cria o comando com os serviços obrigatórios
    $job = new ProcessJobs($logger, $commands);
    $job->run([]);

    echo "[SUCCESS] Comando finalizado.\n";
} catch (Throwable $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
