<div class="mb-4">
    <x-appshell::floating-label :label="__('Name of the role')">
    {{ Form::text('name', null, [
            'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
            'placeholder' => __('Name of the role')
        ])
    }}
    @if ($errors->has('name'))
        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
    @endif
    </x-appshell::floating-label>
</div>

<div class="mb-4 row">
    @foreach($permissions as $permission)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" style="overflow: hidden; white-space: nowrap;">
            <div class="form-check form-switch">
                {{ Form::checkbox("permissions[{$permission->name}]", 1, $role->hasPermissionTo($permission), ['class' => 'form-check-input', 'role' => 'switch', 'id' => '__permission_' . $permission->id]) }}
                <label class="form-check-label" for="__permission_{{ $permission->id }}">{{ $permission->name }}</label>
            </div>
        </div>
    @endforeach

    @if ($errors->has('permissions'))
        <div class="col-12">
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('permissions') }}</div>
        </div>
    @endif
</div>


