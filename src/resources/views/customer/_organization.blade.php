<div class="form-group{{ $errors->has('company_name') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-group-work"></i>
        </span>
        {{ Form::text('company_name', null, ['class' => 'form-control form-control-lg', 'placeholder' => __('Company name')]) }}
    </div>
    @if ($errors->has('company_name'))
        <div class="form-control-feedback">{{ $errors->first('company_name') }}</div>
    @endif
</div>

<div class="form-group{{ $errors->has('tax_nr') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-toll"></i>
        </span>
        {{ Form::text('tax_nr', null, ['class' => 'form-control', 'placeholder' => __('Tax no.')]) }}
    </div>
    @if ($errors->has('tax_nr'))
        <div class="form-control-feedback">{{ $errors->first('tax_nr') }}</div>
    @endif
</div>

<div class="form-group{{ $errors->has('registration_nr') ? ' has-danger' : '' }}">

    {{ Form::text('registration_nr', null, ['class' => 'form-control', 'placeholder' => __('Reg. no.')]) }}

    @if ($errors->has('registration_nr'))
        <div class="form-control-feedback">{{ $errors->first('registration_nr') }}</div>
    @endif
</div>
