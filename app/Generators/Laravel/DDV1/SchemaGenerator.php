<?php

namespace App\Generators\Laravel\DDV1;

class SchemaGenerator
{
    public const PRIMITIVE_TYPES = ['string'=>'string','int'=>'number', 'bool'=>'boolean'];

    public function generate(string $baseClassName)
    {
        //сюда придет DomainProblem::class

        $smallProperties = [
            'type'=>'object',
            'properties'=>[]
        ];

        $smallProperties = $this->generatePropertiesArrayRecursively($baseClassName, $smallProperties);


        $schema = [
            '$schema'=>'http://json-schema.org/draft-06/schema#',
            'type'=>'object',
            "title"=> "DomainProblems",
            'properties'=> [
                'domainProblems'=>[
                    'type'=>'array',
                    'items'=>$smallProperties
                ]
            ]
        ];

        return $schema;
    }

    public function generatePropertiesArrayRecursively(string $className, $wholeProperties)
    {
        $propertiesInSchema = $wholeProperties['properties'] ?? [];
        $required = [];

        $reflectionClass = new \ReflectionClass($className);
        $reflectionProperties = $reflectionClass->getProperties();

        foreach ($reflectionProperties as $reflectionProperty) {
            $docComment = $reflectionProperty->getDocComment();

            if (!$reflectionProperty->isPublic()) {
                continue;
            }

            if (str_contains($docComment, '@exclude')) {
                continue;
            }

            $matches = [];
            preg_match('/@var\s*(.*?)\s/', $docComment, $matches);
            if (!isset($matches[1])) {
                throw new \Exception("Cant read variable type ".$className.", sorry");
            }
            $type = $matches[1];

            $matches = [];
            preg_match('/@description\s*(.*?)\s*\*/', $docComment, $matches);
            $description = trim($matches[1]??"");

            if (str_contains($docComment, '@required')) {
                $required[] = $reflectionProperty->getName();
            }

            if (in_array($type, self::PRIMITIVE_TYPES)) {
                $propertiesInSchema[$reflectionProperty->getName()] = [
                    'description'=>$description,
                    'type'=>$type
                ];
                continue;
            }
            if (preg_match('/\[]$/', $type)) {
                //it is array of type
                $type = substr($type, 0, strlen($type)-2);
                if (in_array($type, array_keys(self::PRIMITIVE_TYPES))) {
                    $propertiesInSchema[$reflectionProperty->name] = [
                        'type'=>'array',
                        'description'=>$description,
                        'items'=>[
                            'type'=>self::PRIMITIVE_TYPES[$type]
                        ]
                    ];
                    continue;
                }
                $type = $this->resolveTypeName($reflectionClass, $type);
                $smallProperties = [
                        'type'=>'object',
                        'properties'=>[]
                ];
                $smallProperties = $this->generatePropertiesArrayRecursively($type, $smallProperties);
                $dynamicProperties = [];
                if (method_exists($type, 'generateAdditionalProperties')) {
                    $dynamicProperties = call_user_func($type.'::generateAdditionalProperties');
                }
                $smallProperties['properties'] = array_merge($smallProperties['properties'], $dynamicProperties);
                $propertiesInSchema[$reflectionProperty->getName()] = [
                    'type'=>'array',
                    'description'=>$description,
                    'items'=>$smallProperties
                ];
                continue;
            }
//            //проверили, что не простой тип, проверили, что не массив простых типов или массив непростых типов
//            //теперь получается надо проверить вдруг ENUM
            if (str_ends_with($type, 'Enum')) {
                $type = $this->resolveTypeName($reflectionClass, $type);
                $enum = [];
                foreach (call_user_func($type.'::cases') as $enumValue) {
                    $enum[] = $enumValue;
                }
                $propertiesInSchema[$reflectionProperty->getName()] = [
                    'enum'=>$enum
                ];
                continue;
            }
//
//            //ну и теперь наконец мы узнали, что там в поле хранится объект, но один.

            $type = $this->resolveTypeName($reflectionClass, $type);
            $newObjectProperties = $this->generatePropertiesArrayRecursively($type, []);

            $dynamicProperties = [];
            if (method_exists($type, 'generateAdditionalProperties')) {
                $dynamicProperties = call_user_func($type.'::generateAdditionalProperties');
            }
            $newObjectProperties['properties'] = array_merge($newObjectProperties['properties'], $dynamicProperties);
            $propertiesInSchema[$reflectionProperty->getName()] = [
                'type'=>'object',
                'description'=>$description,
                'properties'=>$newObjectProperties
            ];
            continue;
        }
        $wholeProperties['properties'] = $propertiesInSchema;
        $wholeProperties['required'] = $required;
        return $wholeProperties;
    }

    private function resolveTypeName(\ReflectionClass $class, string $searchableClassName)
    {
        if (str_contains($searchableClassName, '\\')) {
            return $searchableClassName;
        } //nothing to upgrade

        $fileContent = file_get_contents($class->getFileName());
        $matches = [];
        preg_match('/use\s+(.*\\\\'.$searchableClassName.');/', $fileContent, $matches);
        if (isset($matches[1])) {
            return '\\'.$matches[1];
        }

        $matches = [];
        preg_match('/use\s+(.*)\s+as\s+'.$searchableClassName.';/', $fileContent, $matches);

        if (isset($matches[1])) {
            return '\\'.$matches[1];
        }

        //будем считать, что этот тип в том же пространстве имен

        return '\\'.$class->getNamespaceName().'\\'.$searchableClassName;
    }
}
