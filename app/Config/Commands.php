<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Commands extends BaseConfig
{
    // Registra os comandos CLI personalizados
    public $commands = [
        'mailing:process' => \App\Commands\ProcessJobs::class,
    ];
}
