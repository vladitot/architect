<?php

namespace App\Generators\Laravel\DDV1\Config;

use Illuminate\Support\Facades\Blade;

class Method
{
    /**
     * @exclude
     * @var Controller|Service object
     */
    public Service|Controller $parent;
    /**
     * @var string
     */
    public string $methodName;

    /**
     * @var Parameter[]
     */
    public array $inputParameters;

    /**
     * @var Parameter[]
     */
    public array $outputParameters;

    public function __construct()
    {
        $this->outputParameters = [];
        $this->inputParameters = [];
    }


    public function renderInputParametersOrDtoOrRequest()
    {
        if ($this->parent instanceof Service) {
            //генерим входные для сервиса
            if (count($this->inputParameters)<3) {
                return $this->renderParams($this->inputParameters);
            } else {
                return $this->renderDto($this->inputParameters, 'Input');
            }
        } elseif ($this->parent instanceof Controller) {
            return $this->renderInputRequest();
        }
        throw new ('Not realized');
    }

    public function renderOutputParametersOrDtoOrResource()
    {
        if ($this->parent instanceof Service) {
            //генерим входные для сервиса
            if (count($this->outputParameters)<3) {
                return $this->renderParams($this->outputParameters);
            } else {
                return $this->renderDto($this->outputParameters, 'Output');
            }
        } elseif ($this->parent instanceof Controller) {
            return $this->renderOutputResource();
        }
        throw new ('Not realized');
    }

    /**
     * @param Parameter[] $param
     * @return array
     */
    private function renderParams(array $param): array
    {
        $convertedParams = [];
        foreach ($param as $parameter) {
            $convertedParams[$parameter->name] = $parameter->type;
        }

        return $convertedParams;
    }

    /**
     * @param array|Parameter[] $params
     * @return void
     */
    private function renderDto(array $params, string $postfix): array
    {
        $dtoTemplate = 'resources/views/laravel/ddv1/dto.blade.php';
        $namespace = 'Architect\\Modules\\'.ucfirst($this->parent->parent->domainProblemName).'\\Data';
        $name = ucfirst($this->methodName.$postfix.'Dto');

        $convertedParams = [];
        foreach ($params as $parameter) {
            $convertedParams[$parameter->name] = $parameter->type;
        }

        $renderedDto =  Blade::render(
            file_get_contents($dtoTemplate),
            ['fields'=>$convertedParams, 'namespace'=>$namespace, 'name'=>$name]
        );
        $renderedDtoFilePath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->parent->domainProblemName).'/Data/'.$name.'.php';
        shell_exec('mkdir -p '.dirname($renderedDtoFilePath));
        file_put_contents($renderedDtoFilePath, $renderedDto);
        $dtoFullName = '\\'.$namespace.'\\'.$name;
        return ['dto'=>$dtoFullName];
    }

    private function renderInputRequest(): array
    {
        $dtoName = $this->renderDto($this->inputParameters, 'Input')['dto'];

        $requestTemplatePath = 'resources/views/laravel/ddv1/request.blade.php';
        $namespace = 'Architect\\Modules\\'.ucfirst($this->parent->parent->domainProblemName).'\\Requests';
        $name = ucfirst($this->methodName.'Request');

        $fields = [];
        foreach ($this->inputParameters as $parameter) {
            $fields[$parameter->name] = ['type'=>$parameter->type, 'rule'=>$parameter->rule??""];
        }

        $renderedRequest =  Blade::render(
            file_get_contents($requestTemplatePath),
            ['fields'=>$fields, 'dtoClassName'=>$dtoName, 'name'=>$name, 'namespace'=>$namespace]
        );
        $renderedRequestFilePath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->parent->domainProblemName).'/Requests/'.$name.'.php';
        shell_exec('mkdir -p '.dirname($renderedRequestFilePath));
        file_put_contents($renderedRequestFilePath, $renderedRequest);
        $requestClassName = '\\'.$namespace.'\\'.$name;
        return ['request'=>$requestClassName];
    }

    private function renderOutputResource(): array
    {
        $dtoClassName = $this->renderDto($this->outputParameters, 'Output')['dto'];

        $resourceTemplate = 'resources/views/laravel/ddv1/resource.blade.php';
        $namespace = 'Architect\\Modules\\'.ucfirst($this->parent->parent->domainProblemName).'\\Resources';
        $name = ucfirst($this->methodName.'Resource');

        $resourceFields = [];
        foreach ($this->outputParameters as $parameter) {
            $resourceFields[$parameter->name] = $parameter->type;
        }

        $renderedResource = Blade::render(
            file_get_contents($resourceTemplate),
            ['dtoClassName'=>$dtoClassName, 'resourceFields'=>$resourceFields, 'resourceName'=>$name, 'namespace'=>$namespace]
        );
        $renderedResourceFilePath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->parent->domainProblemName).'/Resources/'.$name.'.php';
        shell_exec('mkdir -p '.dirname($renderedResourceFilePath));
        file_put_contents($renderedResourceFilePath, $renderedResource);
        $resourceFullName = '\\'.$namespace.'\\'.$name;
        return ['resource'=>$resourceFullName];
    }
}
