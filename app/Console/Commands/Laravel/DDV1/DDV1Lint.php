<?php

namespace App\Console\Commands\Laravel\DDV1;

use Illuminate\Console\Command;

class DDV1Lint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lint:laravel-ddv1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check, if application abstractions correctly connected by Service Providers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = Command::SUCCESS;

        foreach (config('abstractions') as $item) {
            try {
                app()->make($item);
            } catch (\Throwable $e) {
                echo "Abstraction ".$item." probably not bind \n";
                $result = Command::FAILURE;
            }
        }


        return $result;
    }
}
