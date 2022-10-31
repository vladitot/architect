@php
    echo '<?php';
@endphp

namespace {{ $namespace }};

use Illuminate\Foundation\Http\FormRequest;


/**
 * @architect
 *
 */
class {{ $name }} extends FormRequest
{
    public function rules(): array
    {
        return [
                @foreach ($fields as $key=>$value)
                    '{{$key}}' => {!! $value['rule'] !!},
                @endforeach
        ];
    }
    public function toDto(): {{ $dtoClassName }}
    {
        return new {{ $dtoClassName }}(
            @foreach ($fields as $key=>$value)
                $this->input('{{$key}}'),
            @endforeach
        {{ ')'}};
    }
}
