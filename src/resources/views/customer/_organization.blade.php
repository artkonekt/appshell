<div class="mb-4">
    <div class="input-group input-group-lg {{ $errors->has('company_name') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('organization') !!}
        </span>
        <x-appshell::floating-label :label="__('Company name')" :is-invalid="$errors->has('company_name')">
        {{ Form::text('company_name', null, [
                'class' => 'form-control' . ($errors->has('company_name') ? ' is-invalid' : ''),
                'placeholder' => __('Company name')
            ])
        }}
        </x-appshell::floating-label>
        @if ($errors->has('company_name'))
            <div class="invalid-feedback">{{ $errors->first('company_name') }}</div>
        @endif
    </div>
</div>

<div class="mb-4">
    <div class="input-group {{ $errors->has('tax_nr') ? 'has-validation' : '' }}">
        <span class="input-group-text">
            {!! icon('tax') !!}
        </span>
        <x-appshell::floating-label :label="__('Tax number')" :is-invalid="$errors->has('tax_nr')">
            {{ Form::text('tax_nr', null, [
                    'class' => 'form-control' . ($errors->has('tax_nr') ? ' is-invalid' : ''),
                    'placeholder' => __('Tax no.')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('tax_nr'))
            <div class="invalid-feedback">{{ $errors->first('tax_nr') }}</div>
        @endif
    </div>
</div>

<div class="mb-4">
    <x-appshell::floating-label :label="__('Registration number')" :is-invalid="$errors->has('registration_nr')">
        {{ Form::text('registration_nr', null, [
                'class' => 'form-control' . ($errors->has('registration_nr') ? ' is-invalid' : ''),
                'placeholder' => __('Reg. no.')
            ])
        }}
    </x-appshell::floating-label>
    @if ($errors->has('registration_nr'))
        <div class="invalid-feedback">{{ $errors->first('registration_nr') }}</div>
    @endif
</div>
