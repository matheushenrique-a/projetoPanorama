<?php

chdir(__DIR__ . '/../../');
require 'vendor/autoload.php';

use App\Commands\ProcessJobs;
use Config\Services;

// Inicializa o ambiente mínimo do CI4
$app = Services::codeigniter();
$app->initialize();

// Cria a instância do comando passando logger e comandos como o CI faz
$logger = service('logger');
$commands = service('commands');
$job = new ProcessJobs($commands, $logger);

// Executa o comando
$job->run([]);
