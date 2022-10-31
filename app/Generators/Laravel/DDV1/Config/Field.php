<?php

namespace App\Generators\Laravel\DDV1\Config;

use ReflectionClass;

class Field
{
    /**
     * @required
     * @var string
     */
    public string $fieldName;

    /**
     * @var string
     */
    public string $fakerCustomValue;

    /**
     * @var FakerEnum
     */
    public FakerEnum $fakerBuiltIn;

    /**
     * @var bool
     */
    public bool $fakerUnique;

    /**
     * @required
     * @var MigrationFieldTypeEnum
     */
    public MigrationFieldTypeEnum $migrationType;


//    public static function generateAdditionalProperties() {
//        $propertiesForJson = [];
//        $reflectionBlueprint = new ReflectionClass(\Illuminate\Database\Schema\Blueprint::class);
//
//        foreach ($reflectionBlueprint->getMethods() as $reflectionMethod) {
//            $methodName = $reflectionMethod->getName();
    ////            if (isset($methodsBlackList[$methodName])) continue;
//
//            $methodProperties = [];
//            $parameters = $reflectionMethod->getParameters();
//            if (isset($parameters[0]) && $parameters[0]->getName()!='column') continue;
//            if (isset($parameters[0]) && str_starts_with($parameters[0]->getName(), 'drop')) continue;
//            foreach ($parameters as $parameter) {
//                if ($parameter->getName()=='column') continue;
//                if (in_array($parameter->getType(), array_keys(SpecGenerator::PRIMITIVE_TYPES))) {
//                    $type = SpecGenerator::PRIMITIVE_TYPES[$parameter->getType()];
//                } else {
//                    $type = 'string';
//                }
//
//                $methodProperties[$parameter->getName()] = [
//                    'type'=> $type,
//                ];
//            }
//
//            $matches = [];
//            preg_match('/\*\s+(.*?)\s+\*/', $reflectionMethod->getDocComment(), $matches);
//
//            $propertiesForJson[$methodName] = [
//                'type'=>'object',
//                'properties'=>$methodProperties,
//                'description'=>$matches[1]??""
//            ];
//        }
//
//        return $propertiesForJson;
//    }

//    public function __get(string $name)
//    {
//        return $this->additionalAttributes[$name];
//    }
//
//    public function setAdditionalAttributes(array $attributes)
//    {
//        return $this->additionalAttributes = $attributes;
//    }
}
