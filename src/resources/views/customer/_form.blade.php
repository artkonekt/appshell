<section x-data="{customerType: '{{ old('type') ?: $customer->type->value() }}'}">

    <div class="mb-4 mt-2 row">
    <label class="form-label col-md-2">{{ __('Customer type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <div class="form-check form-check-inline {{ $errors->has('type') ? ' is-invalid' : '' }}">
                {{ Form::radio('type', $key, $customer->type->value() == $key, ['id' => "type_$key", 'x-model' => 'customerType', 'class' => 'form-check-input' . ($errors->has('type') ? ' is-invalid' : '')]) }}
                <label class="form-check-label" for="type_{{ $key }}">{{ $value }}</label>
            </div>
        @endforeach

        @if ($errors->has('type'))
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="row">

    <div class="col-md-6">
        <div class="mb-4">
            <x-appshell::floating-label :label="__('First name')">
                {{ Form::text('firstname', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('firstname') ? ' is-invalid' : ''),
                    'placeholder' => __('First name')
                    ])
                }}

                @if ($errors->has('firstname'))
                    <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
                @endif
            </x-appshell::floating-label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-4">
            <x-appshell::floating-label :label="__('Last name')">
            {{ Form::text('lastname', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('lastname') ? ' is-invalid' : ''),
                    'placeholder' => __('Last name')
                ])
            }}

            @if ($errors->has('lastname'))
                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
            @endif
            </x-appshell::floating-label>
        </div>
    </div>

</div>

<div id="customer-organization" x-show="customerType == 'organization'">
    @include('appshell::customer._organization')
</div>

<hr>

<div class="mb-4 row">
    <label class="col-form-label col-md-2 pt-0">{{ __('Active') }}</label>
    <div class="col-md-10">
        {{ Form::hidden('is_active', 0) }}
        <div class="form-check form-switch">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'form-check-input', 'role' => 'switch']) }}
            <label class="form-check-label"></label>
        </div>

        @if ($errors->has('is_active'))
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
        @endif

    </div>
</div>
</section>
