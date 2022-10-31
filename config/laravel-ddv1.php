<?php

return [
    'project_path_prefix'=>env('PROJECT_PATH_PREFIX', '/var/www/html'),
    'codegen_path' => env('CODEGEN_PATH', 'src/Architect'),
    'schema_path'=>env('SCHEMA_PATH', 'src/schema-laravel-ddv1.json'),
    'linter_config_path'=>env('LINTER_CONFIG_PATH', 'config/abstractions.php'),
    'architect_path'=>env('ARCHITECT_PATH', 'architect.yaml'),
];
