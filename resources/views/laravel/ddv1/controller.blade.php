@php
    echo '<?php';
@endphp

namespace {{ $namespace }};

use App\Http\Controller;

abstract class {{ $name }} extends Controller implements {{$interfaceName}} {

}
