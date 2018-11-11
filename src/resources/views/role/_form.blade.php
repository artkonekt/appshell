<div class="form-group">
    {{ Form::text('name', null, [
            'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
            'placeholder' => __('Name of the role')
        ])
    }}
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="form-group row">
    @foreach($permissions as $permission)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" style="overflow: hidden; white-space: nowrap;">
            <label class="switch switch-icon switch-pill switch-primary">
                {{ Form::checkbox("permissions[{$permission->name}]", 1, $role->hasPermissionTo($permission), ['class' => 'switch-input']) }}
                <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
                <span class="switch-handle"></span>
            </label>
            {{ $permission->name }}
        </div>
    @endforeach

    @if ($errors->has('permissions'))
        <div class="col-12">
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('permissions') }}</div>
        </div>
    @endif
</div>


