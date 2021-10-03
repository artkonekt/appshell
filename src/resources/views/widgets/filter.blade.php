@switch($type)
    @case('switch')
    @break

    @case('checkbox')
    @break

    @case('select')
        {!! Form::select($id, $options ?? [], $criteria, ['class' => 'form-control form-control-sm', 'placeholder' => $placeholder]) !!}
    @break

    @case('multiselect')
        <select name="{{ $id . '[]' }}" class="form-control form-control-sm"
                multiple multiselect-select-all="true" size="1" placeholder="{{ $placeholder }}">
            @foreach($options as $value => $label)
                <option value="{{ $value }}"@if(in_array($value, $criteria ?? [])) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    @break

    @default
        {!! Form::text($id, $criteria, ['class' => 'form-control form-control-sm', 'placeholder' => $placeholder]) !!}
@endswitch
