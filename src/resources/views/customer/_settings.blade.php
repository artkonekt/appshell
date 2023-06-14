<div class="my-3">
    {{ Form::text('timezone', null, [
            'class' => 'form-control' . ($errors->has('timezone') ? ' is-invalid' : ''),
            'placeholder' => __('Timezone')
        ])
    }}
    @if ($errors->has('timezone'))
        <div class="invalid-feedback">{{ $errors->first('timezone') }}</div>
    @endif
</div>

<div class="mb-3">
    {{ Form::select('currency', $currencies, null, ['class' => 'form-control' . ($errors->has('currency') ? ' is-invalid' : ''), 'placeholder' => __('Currency')]) }}
    @if ($errors->has('currency'))
        <div class="invalid-feedback">{{ $errors->first('currency') }}</div>
    @endif
</div>

<div class="mb-3">
    {{ Form::number('ltv', null, [
            'class' => 'form-control' . ($errors->has('ltv') ? ' is-invalid' : ''),
            'placeholder' => __('Lifetime Sales in :cur', ['cur' => $customer->currency])
        ])
    }}
    @if ($errors->has('ltv'))
        <div class="invalid-feedback">{{ $errors->first('ltv') }}</div>
    @endif
</div>
