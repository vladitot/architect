<?php

namespace App\Generators\Laravel\DDV1\Config;

use Illuminate\Support\Facades\Blade;

class Controller
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
     * @var Method[] $methods
     */
    public array $methods;

    public function render()
    {
        $interfaceFullName = $this->renderInterface();
        $this->parent->abstractions[] = $interfaceFullName;
        $controllerName = $this->renderController($interfaceFullName);
        $this->parent->abstractions[] = $controllerName;
        $testName = $this->renderTest();
        $this->parent->abstractions[] = $testName;
    }

    private function renderInterface(): string
    {
        $interfaceTemplatePath = 'resources/views/laravel/ddv1/interface.blade.php';

        $interfaceNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\ControllerInterfaces';
        $interfaceDestinationPath = 'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/ControllerInterfaces/Controller'.ucfirst($this->name).'Interface.php';

        $interfaceName = 'Controller'.ucfirst($this->name.'Interface');

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

    private function renderController(string $interfaceFullName)
    {
        $controllerName = 'Abstract'.ucfirst($this->name.'Controller');
        $controllerDestinationPath = 'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/Controllers/'.$controllerName.'.php';
        $controllerTemplatePath = 'resources/views/laravel/ddv1/controller.blade.php';
        $controllerNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\Controllers';


        $renderedService =  Blade::render(
            file_get_contents($controllerTemplatePath),
            ['namespace'=>$controllerNamespace, 'name'=>$controllerName, 'interfaceName'=>$interfaceFullName]
        );
        shell_exec('mkdir -p '.dirname($controllerDestinationPath));
        file_put_contents($controllerDestinationPath, $renderedService);

        return '\\'.$controllerNamespace.'\\'.$controllerName;
    }

    private function renderTest()
    {
        $testName = 'Abstract'.ucfirst($this->name.'ControllerTest');
        $testDestinationPath = 'src/Architect/Modules/'.ucfirst($this->parent->domainProblemName).'/ControllerTests/'.$testName.'.php';
        $testTemplatePath = 'resources/views/laravel/ddv1/abstractTest.blade.php';
        $testNamespace = 'Architect\\Modules\\'.ucfirst($this->parent->domainProblemName).'\\ControllerTests';

        $cases = [
            '200', '401', '404', '403', '500'
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
