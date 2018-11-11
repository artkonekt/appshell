<div class="form-group row{{ $errors->has('type') ? ' has-danger' : '' }}">
    <label class="form-control-label col-md-2">{{ __('Customer type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('type', $key, $customer->type->value() == $key, ['id' => "type_$key", 'v-model' =>
                'customerType']) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('type'))
            <div class="form-control-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            {{ Form::text('firstname', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('firstname') ? ' is-invalid' : ''),
                    'placeholder' => __('First name')
                ])
            }}

            @if ($errors->has('firstname'))
                <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {{ Form::text('lastname', null, [
                    'class' => 'form-control form-control-lg' . ($errors->has('lastname') ? ' is-invalid' : ''),
                    'placeholder' => __('Last name')
                ])
            }}

            @if ($errors->has('lastname'))
                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
            @endif
        </div>
    </div>

</div>

<div id="customer-organization" v-show="customerType == 'organization'">
    @include('appshell::customer._organization')
</div>

<hr>

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('Active') }}</label>
    <div class="col-md-10">
        {{ Form::hidden('is_active', 0) }}
        <label class="switch switch-icon switch-pill switch-primary">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'switch-input']) }}
            <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
            <span class="switch-handle"></span>
        </label>

        @if ($errors->has('is_active'))
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
        @endif

    </div>
</div>


@section('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                customerType: '{{ old('type') ?: $customer->type->value() }}'
            }
        });
    </script>
@stop
