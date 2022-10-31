@php
echo '<?php';
@endphp

namespace {{$namespace}};

use Illuminate\Database\Eloquent\Factories\Factory;

abstract class {{$factoryName}} extends Factory
{
    protected $model = {{$modelName}}::class;

    public function definition()
    {
        return [
            @foreach ($fields as $field)
                '{{$field->fieldName}}' => fake()->{{$field->fakerCustomValue ?? $field->fakerBuiltIn ?? ""}}(),
            @endforeach
        ];
    }
}
