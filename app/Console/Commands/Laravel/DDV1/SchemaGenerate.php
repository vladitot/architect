<?php

namespace App\Console\Commands\Laravel\DDV1;

use App\Generators\Laravel\DDV1\SchemaGenerator;
use Illuminate\Console\Command;

class SchemaGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schema:generate-ddv1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Schema';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $generator = new SchemaGenerator();
        $schema = $generator->generate(\App\Generators\Laravel\DDV1\Config\DomainProblem::class);

        file_put_contents(
            config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.config('laravel-ddv1.schema_path'),
            json_encode($schema, JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
