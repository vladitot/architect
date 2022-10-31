<?php

namespace App\Generators\Laravel\DDV1\Config;

class DomainProblem
{
    /**
     * @description name of domain problem
     * @var string $domainProblemName
     */
    public string $domainProblemName;

    /**
     * @description controllers defined in this domain
     * @var Controller[] $controllers
     */
    public array $controllers;
//
    /**
     * @description models, defined in this domain
     * @var Model[] $domainProblems
     */
    public array $models;

    /**
     * @description services, defined in this domain
     * @var Service[] $services
     */
    public array $services;

    /**
     * @exclude
     * @var string[]
     */
    public array $abstractions;

    public function __construct()
    {
        $this->abstractions = [];
        $this->services = [];
        $this->models = [];
        $this->controllers = [];
    }
}
