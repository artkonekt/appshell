@switch($type)
    @case('switch')
    @break

    @case('checkbox')
    @break

    @case('select')
        {!! Form::select($id, $options ?? [], null, ['class' => 'form-control form-control-sm', 'placeholder' => $title]) !!}
        &nbsp;
    @break

    @case('multiselect')
        @php
            $multiSelectId = 'filter' . \Illuminate\Support\Str::studly($id) . mt_rand();
        @endphp
        <small class="font-weight-normal">{{ $title }}:&nbsp;</small>
        {!! Form::select($id . '[]', $options, null,
                [
                    'id' => $multiSelectId,
                    'class' => 'form-control form-control-sm',
                    'multiple' => 'multiple',
                    'multiselect-select-all' => 'true',
                    'size' => 1,
                ]
            )
        !!}
        &nbsp;
    @break

    @default
        {!! Form::text($id, null, ['class' => 'form-control form-control-sm', 'placeholder' => $title]) !!}
        &nbsp;
@endswitch
