<div class="mb-3">
    <div @class(['input-group input-group-lg', 'has-validation' => $errors->has('name')])>
        <span class="input-group-text">{!! icon('globe') !!}</span>
        <x-appshell::floating-label :label="__('Name')" :is-invalid="$errors->has('name')">
            {{ Form::text('name', null, [
                    'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''),
                    'placeholder' => __('Name of the country')
                ])
            }}
        </x-appshell::floating-label>
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3 row">
    <label for="id" class="col-form-label col-form-label-sm col-md-2">{{ __('Country Code') }}</label>
    <div class="col-md-10">
        {{ Form::text('id', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('id') ? ' is-invalid': ''),
                'placeholder' => __('Enter the 2-letter country code (e.g., US, UK, IN)'),
                'id' => 'id',
                'oninput' => 'this.value = this.value.toUpperCase()',
                'maxlength' => '2',
            ])
        }}
        @if ($errors->has('id'))
            <div class="invalid-feedback">{{ $errors->first('id') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label for="phonecode" class="col-form-label col-form-label-sm col-md-2">{{ __('Phone Code') }}</label>
    <div class="col-md-10">
        {{ Form::text('phonecode', null, [
                'class' => 'form-control form-control-sm' . ($errors->has('phonecode') ? ' is-invalid': ''),
                'pattern' => "[0-9]*",
                'inputmode' => 'numeric',
                'oninput' => 'this.value = this.value.replace(/[^0-9]/g, "")',
                'maxlength' => '4',
                'placeholder' => __('Enter the country phone code (e.g., 33, 7)'),
                'id' => 'phonecode',
            ])
        }}
        @if ($errors->has('phonecode'))
            <div class="invalid-feedback">{{ $errors->first('phonecode') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label for="is_eu_member" class="col-form-label col-form-label-sm col-md-2">
        {{ __('EU Member State') }}
        <x-appshell::badge variant="secondary" size="sm">
            {{ __('deprecated') }}
        </x-appshell::badge>
    </label>
    <div class="col-md-10">
        <input type="hidden" name="is_eu_member" value="0"/>

        <div class="form-check form-switch">
            {!! Form::checkbox(
                    'is_eu_member', 1, null, [
                    'class' => 'form-check-input',
                    'id' => 'is_eu_member',
                    'role' => 'switch',
                ])
            !!}
        </div>

        @if ($errors->has('is_eu_member'))
            <div class="invalid-feedback">{{ $errors->first('is_eu_member') }}</div>
        @endif
    </div>
</div>


