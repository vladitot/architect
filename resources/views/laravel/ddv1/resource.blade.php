@php
echo '<?php';
@endphp

namespace {{ $namespace }};

use App\Http\Api\Shared\Resources\Resource;

@if ($dtoClassName)
/** @property {{ $dtoClassName }} $resource */
@endif
class {{ $resourceName }} extends Resource
{
    public function toArray($request)
    {
        return [
        @foreach ($resourceFields as $key=>$value)
            '{{ $key }}' => $this->resource->{{ $key }}
        @endforeach
        ];
    }
}
