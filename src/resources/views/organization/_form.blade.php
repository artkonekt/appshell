<div class="form-group{{ $errors->has('organization.name') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-group-work"></i>
        </span>
        {{ Form::text('organization[name]', null, ['class' => 'form-control form-control-lg', 'placeholder' => __('Name')]) }}
    </div>
    @if ($errors->has('organization.name'))
        <div class="form-control-feedback">{{ $errors->first('organization.name') }}</div>
    @endif
</div>

<div class="form-group{{ $errors->has('organization.tax_nr') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-toll"></i>
        </span>
        {{ Form::text('organization[tax_nr]', null, ['class' => 'form-control', 'placeholder' => __('Tax no.')]) }}
    </div>
    @if ($errors->has('organization.tax_nr'))
        <div class="form-control-feedback">{{ $errors->first('organization.tax_nr') }}</div>
    @endif
</div>

<div class="form-group{{ $errors->has('organization.registration_nr') ? ' has-danger' : '' }}">

    {{ Form::text('organization[registration_nr]', null, ['class' => 'form-control', 'placeholder' => __('Reg. no.')]) }}

    @if ($errors->has('organization.registration_nr'))
        <div class="form-control-feedback">{{ $errors->first('organization.registration_nr') }}</div>
    @endif
</div>
