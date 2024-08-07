@foreach($roles as $role)
    <div class="form-check form-switch">
        {{ Form::checkbox("roles[{$role->name}]", 1, $model->hasRole($role), ['class' => 'form-check-input', 'role' => 'switch', 'id' => '__role_' . $role->id]) }}
        <label class="form-check-label" for="__role_{{ $role->id }}">{{ $role->name }}</label>
    </div>
@endforeach

@if ($errors->has('roles'))
    <x-appshell::alert variant="danger">{{ $errors->first('roles') }}</x-appshell::alert>
@endif

