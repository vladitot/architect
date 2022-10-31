<?php

namespace App\Generators\Laravel\DDV1\Config;

use Illuminate\Support\Facades\Blade;

class Service
{
    /**
     * @exclude
     * @var DomainProblem
     */
    public DomainProblem $parent;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string[] $injects
     */
    public array $injects;

    /**
     * @var Method[] $methods
     */
    public array $methods;

    public function render()
    {
        $interfaceFullName = $this->renderInterface();
        $this->parent->abstractions[] = $interfaceFullName;
        $serviceName = $this->renderService($interfaceFullName);
        $this->parent->abstractions[] = $serviceName;
        $testName = $this->renderTest();
        $this->parent->abstractions[] = $testName;
    }

    private function renderInterface(): string
    {
        $interfaceTemplatePath = 'resources/views/laravel/ddv1/interface.blade.php';

        $interfaceNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\Interfaces';
        $interfaceDestinationPath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/Interfaces/'.ucfirst($this->name).'Interface.php';

        $interfaceName = ucfirst($this->name.'Interface');

        $interfaceMethods = [];
        foreach ($this->methods as $method) {
            $methodName = $method->methodName;
            $interfaceMethods[$methodName]=[];

            $inlineInputParams ='';
            foreach ($method->renderInputParametersOrDtoOrRequest() as $param=> $type) {
                $inlineInputParams .= $type.' $'.$param.',';
            }
            $inlineInputParams = rtrim($inlineInputParams, ',');
            $interfaceMethods[$methodName]['inputParams']=$inlineInputParams;

            $interfaceMethods[$methodName]['outputParams']=$method->renderOutputParametersOrDtoOrResource();
        }
        $renderedInterface =  Blade::render(
            file_get_contents($interfaceTemplatePath),
            ['interfaceMethods'=>$interfaceMethods, 'namespace'=>$interfaceNamespace, 'name'=>$interfaceName]
        );

        shell_exec('mkdir -p '.dirname($interfaceDestinationPath));
        file_put_contents($interfaceDestinationPath, $renderedInterface);


        return '\\'.$interfaceNamespace.'\\'.$interfaceName;
    }

    private function renderService(string $interfaceFullName)
    {
        $serviceName = 'Abstract'.ucfirst($this->name.'Service');
        $serviceDestinationPath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/Services/'.$serviceName.'.php';
        $interfaceTemplatePath = 'resources/views/laravel/ddv1/service.blade.php';
        $serviceNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\Services';


        $renderedService =  Blade::render(
            file_get_contents($interfaceTemplatePath),
            ['namespace'=>$serviceNamespace, 'name'=>$serviceName, 'interfaceName'=>$interfaceFullName],
            deleteCachedView: true
        );
        shell_exec('mkdir -p '.dirname($serviceDestinationPath));
        file_put_contents($serviceDestinationPath, $renderedService);

        return '\\'.$serviceNamespace.'\\'.$serviceName;
    }

    private function renderTest()
    {
        $testName = 'Abstract'.ucfirst($this->name.'ServiceTest');
        $testDestinationPath = config('laravel-ddv1.project_path_prefix').DIRECTORY_SEPARATOR.
            'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/ServiceTests/'.$testName.'.php';
        $testTemplatePath = 'resources/views/laravel/ddv1/abstractTest.blade.php';
        $testNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\ServiceTests';

        $cases = [
            'good', 'bad', 'exception'
        ];

        $renderedService =  Blade::render(
            file_get_contents($testTemplatePath),
            ['namespace'=>$testNamespace, 'testName'=>$testName, 'cases'=>$cases, 'methods'=>$this->methods]
        );
        shell_exec('mkdir -p '.dirname($testDestinationPath));
        file_put_contents($testDestinationPath, $renderedService);

        return '\\'.$testNamespace.'\\'.$testName;
    }
}
