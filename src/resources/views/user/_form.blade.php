<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('user') !!}
            </span>
        </div>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Full name')
            ])
        }}
        @if ($errors->has('name'))
            <div class="invalid-tooltip">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('email') !!}
            </span>
        </div>
        {{ Form::email('email', null, [
            'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
            'autocomplete' => 'off',
            'placeholder' => __('E-mail address')
            ])
        }}
        @if ($errors->has('email'))
            <div class="invalid-tooltip">{{ $errors->first('email') }}</div>
        @endif
    </div>
</div>

<div style="display: none">
    {{-- This block is to trick browser's autocompletion detection which is extremely pushy --}}
    <?php $fakeElementId = 'ooh' . uniqid(); ?>
    <input type="text" name="{{ $fakeElementId }}" id="{{ $fakeElementId }}" value="{{ uniqid() }}" />
</div>

<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('password') !!}
            </span>
        </div>
        <?php $passwordPlaceholderText = $user->exists ? __('Type new password if you want to change it') : __('Enter password') ?>
        {{ Form::password('password', [
            'class'        => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
            'autocomplete' => 'new-password',
            'placeholder'  => $passwordPlaceholderText
            ])
        }}
        @if ($errors->has('password'))
            <div class="invalid-tooltip">{{ $errors->first('password') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('User type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('type', $key, $user->type == $value, ['id' => "type_$key", 'v-model' => 'userType']) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('type'))
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
    <div class="col-md-10 offset-md-2" v-show="showCustomerSelection()">
        {{ Form::select('customer_id', $customers->pluck('name','id'), null, ['class' => 'form-control' . ($errors->has('customer_id') ? ' is-invalid' : ''), 'placeholder' => __('Customer')]) }}
    </div>
</div>

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
            userType: '{{ old('type') ?: $user->type->value() }}',
            showCustomerSelection() {
                const customerSelection = {!! is_array($customerSelection) ? '["' . implode('","', $customerSelection) . '"]' : ($customerSelection ? 'true' : 'false') !!};
                if ('boolean' === typeof(customerSelection)) {
                    return customerSelection;
                }
                return customerSelection.includes(this.userType);
            }
        }
    });
</script>
@endsection

@push('onload-scripts')
    setTimeout(function() {
        document.getElementById('{{ $fakeElementId }}').remove();
    }, 470);
@endpush
