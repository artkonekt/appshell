<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('email') !!}
            </span>
        </div>
        {{ Form::email('email', null, [
            'class' => 'form-control form-control-lg' . ($errors->has('email') ? ' is-invalid' : ''),
            'autocomplete' => 'off',
            'placeholder' => __('E-mail address')
            ])
        }}
        @if ($errors->has('email'))
            <div class="invalid-tooltip">{{ $errors->first('email') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('user') !!}
            </span>
        </div>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Full name (optional)')
            ])
        }}
        @if ($errors->has('name'))
            <div class="invalid-tooltip">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div style="display: none">
    {{-- This block is to trick browser's autocompletion detection which is extremely pushy --}}
    <?php $fakeElementId = 'ooh' . uniqid(); ?>
    <input type="text" name="{{ $fakeElementId }}" id="{{ $fakeElementId }}" value="{{ uniqid() }}" />
</div>

<hr>

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('User type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('type', $key, $invitation->type->value() == $key, ['id' => "type_$key"]) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('type'))
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#{{ $fakeElementId }}').remove();
        }, 470);
    });
</script>
@endsection
