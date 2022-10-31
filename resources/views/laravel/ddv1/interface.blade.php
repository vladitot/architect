@php
echo '<?php';
@endphp

namespace {{ $namespace }};

interface {{ $name }} {

@foreach($interfaceMethods as $methodName=>$value)

    public function {{$methodName}}{{ '(' }}{{$value['inputParams']}}{{ '): ' }}{{ reset($value['outputParams']) }};

@endforeach

}
