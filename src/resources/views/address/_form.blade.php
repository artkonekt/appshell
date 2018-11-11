@if($for)
    <div class="form-group row">
        <label class="form-control-label col-md-2">{{ __('Address for') }}:</label>

        <div class="col-md-10">
            <strong>{{ $for->name }}</strong>
        </div>
        {{ Form::hidden('for', shorten(get_class($for))) }}
        {{ Form::hidden('forId', $for->id) }}
    </div>
@endif

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('Address type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('type', $key, $address->type->value() == $key, ['id' => "type_$key", 'v-model' =>
                'addressType']) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group">
    {{ Form::text('name', null, [
            'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
            'placeholder' => __('Name')
        ])
    }}

    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="row">
    <div class="col-md-6">
        <label class="form-control-label">{{ __('Country') }}</label>
        <div class="form-group">
            {{ Form::select(
                        'country_id',
                        $countries->pluck('name', 'id'),
                        $address->country_id ?: setting('appshell.default.country'),
                        ['class' => 'form-control' . ($errors->has('country_id') ? ' is-invalid' : '')]
                    )
            }}

            @if ($errors->has('country_id'))
                <div class="invalid-feedback">{{ $errors->first('country_id') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-control-label">{{ __('State/Province') }}</label>
        <div class="form-group">
            {{ Form::select('province_id', [], null, [
                    'class' => 'form-control' . ($errors->has('province_id') ? ' is-invalid' : '')
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
        <label class="form-control-label">{{ __('City') }}</label>
        <div class="form-group">
            {{ Form::text('city', null, ['class' => 'form-control' . ($errors->has('city') ? ' is-invalid' : '')]) }}

            @if ($errors->has('city'))
                <div class="invalid-feedback">{{ $errors->first('city') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-control-label">{{ __('Postal/Zip Code') }}</label>
        <div class="form-group">
            {{ Form::text('postalcode', null, ['class' => 'form-control' . ($errors->has('postalcode') ? ' is-invalid' : '')]) }}

            @if ($errors->has('postalcode'))
                <div class="invalid-feedback">{{ $errors->first('postalcode') }}</div>
            @endif
        </div>
    </div>

</div>

<label class="form-control-label">{{ __('Address') }}</label>
<div class="form-group">
    {{ Form::text('address', null, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : '')]) }}

    @if ($errors->has('address'))
        <div class="invalid-feedback">{{ $errors->first('address') }}</div>
    @endif
</div>
