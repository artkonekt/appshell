<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('organization') !!}
            </span>
        </div>
        {{ Form::text('company_name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('company_name') ? ' is-invalid' : ''),
                'placeholder' => __('Company name')
            ])
        }}
        @if ($errors->has('company_name'))
            <div class="invalid-tooltip" style="width: auto">{{ $errors->first('company_name') }}</div>
        @endif
    </div>

</div>

<div class="form-group">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                {!! icon('tax') !!}
            </span>
        </div>
        {{ Form::text('tax_nr', null, [
                'class' => 'form-control' . ($errors->has('tax_nr') ? ' is-invalid' : ''),
                'placeholder' => __('Tax no.')
            ])
        }}
        @if ($errors->has('tax_nr'))
            <div class="invalid-feedback">{{ $errors->first('tax_nr') }}</div>
        @endif
    </div>
</div>

<div class="form-group">
    {{ Form::text('registration_nr', null, [
            'class' => 'form-control' . ($errors->has('registration_nr') ? ' is-invalid' : ''),
            'placeholder' => __('Reg. no.')
        ])
    }}
    @if ($errors->has('registration_nr'))
        <div class="invalid-feedback">{{ $errors->first('registration_nr') }}</div>
    @endif
</div>
