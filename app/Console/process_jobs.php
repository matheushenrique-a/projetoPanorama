<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "[START] Executando ProcessJobs...\n";

chdir(__DIR__ . '/../../');

require 'vendor/autoload.php';

define('ENVIRONMENT', 'production');

require_once 'app/Config/Paths.php';

$paths = new Config\Paths();
require_once rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

$context = APPPATH . 'Config/Boot/' . ENVIRONMENT . '.php';
if (file_exists($context)) {
    require_once $context;
}

use App\Commands\ProcessJobs;
use Config\Services;

try {
    echo "[INFO] CodeIgniter carregado. Criando instâncias...\n";

    $logger   = service('logger');
    $commands = service('commands');

    echo "[INFO] Executando comando ProcessJobs...\n";

    $job = new ProcessJobs($logger, $commands);
    $job->run([]);

    echo "[SUCCESS] Comando finalizado.\n";
} catch (Throwable $e) {
    echo "[ERROR] " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
