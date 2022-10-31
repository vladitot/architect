@php
echo '<?php';
@endphp

namespace {{$namespace}};

use Tests\TestCase;

abstract class {{$testName}} extends TestCase
{

@foreach($methods as $method)

    public function dataProviderFor{{$method->methodName}}() {
        return [
        @foreach($cases as $case)
            '{{$case}}'=>[],
        @endforeach
        ];
    }

    /**
     * @dataprovider dataProviderFor{{$method->methodName}}
     */
    abstract public function test{{ucfirst($method->methodName)}}();
@endforeach
}
