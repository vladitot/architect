@php
    echo '<?php';
@endphp

namespace {{ $namespace }};
/**
 * @architect
 *
 */
final class {{ $name }} {

    public function __construct{{'('}}
@foreach ($fields as $field=>$type)
    public readonly {{ $type }} ${{ $field }},
@endforeach
{{ ')' }} {
    }
}
