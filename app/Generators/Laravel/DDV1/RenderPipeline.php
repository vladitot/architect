<?php

namespace App\Generators\Laravel\DDV1;

use App\Generators\Laravel\DDV1\Config\Base;

class RenderPipeline
{
    public function run(Base $config)
    {
        shell_exec('rm -rf src/Architect');
        shell_exec('rm -rf src/database/generatedMigrations');
        $abstractions = [];
        foreach ($config->domainProblems as $domainProblem) {
            foreach ($domainProblem->services as $service) {
                $service->render();
            }
            foreach ($domainProblem->controllers as $controller) {
                $controller->render();
            }
            foreach ($domainProblem->models as $model) {
                $model->render();
            }

            $abstractions = array_merge($domainProblem->abstractions);
        }

        $this->bakeAbstractions($abstractions);
    }

    public function bakeAbstractions(array $abstractions): void
    {
        $content = '<?php'."\nreturn [\n";

        foreach ($abstractions as $binding) {
            $content.=$binding.'::class,'."\n";
        }

        $content.="\n".'];';
        file_put_contents('config/abstractions.php', $content);
    }
}
