<?php

namespace App\Console\Commands\Laravel\DDV1;

use Illuminate\Console\Command;

class CodeGen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'codegen:laravel-ddv1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Code';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $baseConfig = \App\Generators\Laravel\DDV1\LoadConfig::load(
            config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.config('laravel-ddv1.architect_path')
        );

        $render = new \App\Generators\Laravel\DDV1\RenderPipeline();

        $render->run($baseConfig);

        return Command::SUCCESS;
    }
}
