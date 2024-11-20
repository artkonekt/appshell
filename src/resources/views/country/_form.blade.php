<div class="mb-3">
    <div @class(['input-group input-group-lg', 'has-validation' => $errors->has('name')])>
        <span class="input-group-text">{!! icon('zone') !!}</span>
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
                'placeholder' => __('Enter the country phone code (e.g., 36, 49)'),
                'id' => 'phonecode',
            ])
        }}
        @if ($errors->has('phonecode'))
            <div class="invalid-feedback">{{ $errors->first('phonecode') }}</div>
        @endif
    </div>
</div>

<div class="mb-3 row">
    <label for="is_eu_member" class="col-form-label col-form-label-sm col-md-2">{{ __('EU Member') }}</label>
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


