@if($for)
    <div class="mb-2 row">
        <label class="col-form-label col-md-2">{{ __('Address for') }}:</label>

        <div class="col-md-10 col-form-label fw-bold">{{ $for->name }}</div>
        {{ Form::hidden('for', shorten(get_class($for))) }}
        {{ Form::hidden('forId', $for->id) }}
    </div>
@endif

<div class="mb-3 row">
    <label class="form-label col-md-2">{{ __('Address type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <div class="form-check form-check-inline {{ $errors->has('type') ? ' is-invalid' : '' }}">
                {{ Form::radio('type', $key, ($address->type->value() === $key), ['id' => "type_$key", 'class' => 'form-check-input' . ($errors->has('type') ? ' is-invalid' : '')]) }}
                <label class="form-check-label" for="type_{{ $key }}">{{ $value }}</label>
            </div>
        @endforeach

        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="mb-3">
    <x-appshell::floating-label :label="__('Name')">
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Name')
            ])
        }}
        @if ($errors->has('name'))
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        @endif
    </x-appshell::floating-label>
</div>

<div class="row">
    <div class="col-md-6">
        <label class="form-label">{{ __('Country') }}</label>
        <div class="mb-3">
            {{ Form::select(
                        'country_id',
                        $countries->pluck('name', 'id'),
                        $address->country_id ?: setting('appshell.default.country'),
                        ['class' => 'form-select' . ($errors->has('country_id') ? ' is-invalid' : '')]
                    )
            }}

            @if ($errors->has('country_id'))
                <div class="invalid-feedback">{{ $errors->first('country_id') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">{{ __('State/Province') }}</label>
        <div class="mb-3">
            {{ Form::select('province_id', [], null, [
                    'class' => 'form-select' . ($errors->has('province_id') ? ' is-invalid' : '')
                ])
            }}

            @if ($errors->has('province_id'))
                <div class="invalid-feedback">{{ $errors->first('province_id') }}</div>
            @endif
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-6">
        <label class="form-label">{{ __('City') }}</label>
        <div class="mb-3">
            {{ Form::text('city', null, ['class' => 'form-control' . ($errors->has('city') ? ' is-invalid' : '')]) }}

            @if ($errors->has('city'))
                <div class="invalid-feedback">{{ $errors->first('city') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">{{ __('Postal/Zip Code') }}</label>
        <div class="mb-3">
            {{ Form::text('postalcode', null, ['class' => 'form-control' . ($errors->has('postalcode') ? ' is-invalid' : '')]) }}

            @if ($errors->has('postalcode'))
                <div class="invalid-feedback">{{ $errors->first('postalcode') }}</div>
            @endif
        </div>
    </div>

</div>

<label class="form-label">{{ __('Address') }}</label>
<div class="mb-3">
    {{ Form::text('address', null, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : '')]) }}

    @if ($errors->has('address'))
        <div class="invalid-feedback">{{ $errors->first('address') }}</div>
    @endif
</div>
