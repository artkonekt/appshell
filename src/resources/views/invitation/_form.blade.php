<div class="mb-4">
    <div class="input-group {{$errors->has('email') ? ' has-validation' : ''}}">
        <span class="input-group-text">
            {!! icon('email') !!}
        </span>
        <x-appshell::floating-label :label="__('E-mail')" :is-invalid="$errors->has('email')">
            {{ Form::email('email', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('email') ? ' is-invalid' : ''),
                'autocomplete' => 'off',
                'placeholder' => __('E-mail address')
                ])
            }}
        </x-appshell::floating-label>

        @if ($errors->has('email'))
            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-4">
    <div class="input-group {{$errors->has('name') ? ' has-validation' : ''}}">
        <span class="input-group-text">
            {!! icon('user') !!}
        </span>
        <x-appshell::floating-label :label="__('Full name (optional)')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control form-control-sm' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Full name (optional)')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<div style="display: none">
    {{-- This block is to trick browser's autocompletion detection which is extremely pushy --}}
    <?php $fakeElementId = 'ooh' . uniqid(); ?>
    <input type="text" name="{{ $fakeElementId }}" id="{{ $fakeElementId }}" value="{{ uniqid() }}" />
</div>

<hr>

<div class="mb-4 row">
    <label class="form-label col-md-2">{{ __('User type') }}</label>
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

@push('footer-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            console.log(document.getElementById('{{ $fakeElementId }}'));
            document.getElementById('{{ $fakeElementId }}').remove();
        }, 470);
    })
</script>
@endpush
