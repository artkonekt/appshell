<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-shield-security"></i>
        </span>
        {{ Form::text('name', null, ['class' => 'form-control form-control-lg', 'placeholder' => __('Name of the role')]) }}
    </div>
    @if ($errors->has('name'))
        <div class="form-control-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>

<div class="form-group row {{ $errors->has('permissions') ? ' has-danger' : '' }}">

    @foreach($permissions as $permission)
        <div class="col-6 col-sm-2 @unless(($loop->index + 5) % 5)offset-sm-1 @endunless">
            {{ $permission->name }}
            <label class="switch switch-icon switch-pill switch-primary">
                {{ Form::checkbox("permissions[{$permission->name}]", 1, $role->hasPermissionTo($permission), ['class' => 'switch-input']) }}
                <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
                <span class="switch-handle"></span>
            </label>
        </div>
    @endforeach

    @if ($errors->has('permissions'))
        <div class="form-control-feedback">{{ $errors->first('permissions') }}</div>
    @endif

</div>


