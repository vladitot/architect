<?php

namespace App\Generators\Laravel\DDV1\Config;

use Illuminate\Support\Facades\Blade;

class Model
{
    /**
     * @exclude
     * @var DomainProblem
     */
    public DomainProblem $parent;

    /**
     * @required
     * @var string
     */
    public string $modelName;

    /**
     * @var string
     */
    public string $tableName;

    /**
     * @var string
     */
    public ?string $extends;

    /**
     * @required
     * @var Field[]
     */
    public array $fields;

    public function render()
    {
        $this->renderMigration();
        $modelName = $this->renderModel();
        $this->parent->abstractions[] = $modelName;
        $factoryName = $this->renderFactory($modelName);
        $this->parent->abstractions[] = $factoryName;
    }

    private function renderMigration()
    {
        $migrationName = ucfirst($this->modelName.'Migration');
        $migrationDestinationPath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'database/generatedMigrations/'.ucfirst($this->parent->domainProblemName).'-'.$migrationName.'.php';
        $migrationTemplatePath = 'resources/views/laravel/ddv1/migration.blade.php';

        $renderedFileContent =  Blade::render(
            file_get_contents($migrationTemplatePath),
            ['tableName'=>$this->tableName??strtolower($this->modelName), 'fields'=>$this->fields]
        );
        shell_exec('mkdir -p '.dirname($migrationDestinationPath));
        file_put_contents($migrationDestinationPath, $renderedFileContent);
    }

    private function renderModel()
    {
        $modelName = 'Abstract'.ucfirst($this->modelName.'Model');
        $modelDestinationPath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/Models/'.$modelName.'.php';
        $modelTemplatePath = 'resources/views/laravel/ddv1/abstractModel.blade.php';
        $modelNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\Models';


        $extends = $this->extends??'\\Illuminate\\Database\\Eloquent\\Model';
        $renderedFileContent =  Blade::render(
            file_get_contents($modelTemplatePath),
            ['table'=>$this->tableName??strtolower($this->modelName), 'extends'=>$extends, 'namespace'=>$modelNamespace, 'modelName'=>$modelName]
        );
        shell_exec('mkdir -p '.dirname($modelDestinationPath));
        file_put_contents($modelDestinationPath, $renderedFileContent);

        return '\\'.$modelNamespace.'\\'.$modelName;
    }

    private function renderFactory(string $modelName)
    {
        $factoryName = 'Abstract'.ucfirst($this->modelName.'Factory');
        $factoryDestinationPath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/Factories/'.$factoryName.'.php';
        $factoryTemplatePath = 'resources/views/laravel/ddv1/abstractFactory.blade.php';
        $factoryNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\Factories';

        $renderedFileContent =  Blade::render(
            file_get_contents($factoryTemplatePath),
            ['factoryName'=>$factoryName, 'namespace'=>$factoryNamespace, 'modelName'=>$modelName, 'fields'=>$this->fields]
        );
        shell_exec('mkdir -p '.dirname($factoryDestinationPath));
        file_put_contents($factoryDestinationPath, $renderedFileContent);

        return '\\'.$factoryNamespace.'\\'.$factoryName;
    }
}
