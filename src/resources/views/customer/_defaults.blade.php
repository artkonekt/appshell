<div class="my-3">
    <x-appshell::floating-label :label="__('Default Billing Address')" :is-invalid="$errors->has('default_billing_address_id')">
        {!! Form::select('default_billing_address_id', $customer->billingAddresses()->keyBy('id'), $customer->default_billing_address_id,
                ['class' => 'form-control' . ($errors->has('default_billing_address_id') ? ' is-invalid' : ''), 'placeholder' => __('--')])
        !!}
        @if ($errors->has('default_billing_address_id'))
            <div class="invalid-feedback">{{ $errors->first('default_billing_address_id') }}</div>
        @endif
    </x-appshell::floating-label>
</div>


<div class="my-3">
    <x-appshell::floating-label :label="__('Default Shipping Address')" :is-invalid="$errors->has('default_shipping_address_id')">
        {!! Form::select('default_shipping_address_id', $customer->shippingAddresses()->keyBy('id'), $customer->default_shipping_address_id,
                ['class' => 'form-control' . ($errors->has('default_shipping_address_id') ? ' is-invalid' : ''), 'placeholder' => __('--')])
        !!}
        @if ($errors->has('default_shipping_address_id'))
            <div class="invalid-feedback">{{ $errors->first('default_shipping_address_id') }}</div>
        @endif
    </x-appshell::floating-label>
</div>
