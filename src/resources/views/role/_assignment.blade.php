<h3>{{ __('Roles') }}</h3>

@foreach($roles as $role)
    <div class="custom-control custom-switch">
        {{ Form::checkbox("roles[{$role->name}]", 1, $model->hasRole($role), ['class' => 'custom-control-input', 'id' => '__role_' . $role->id]) }}
        <label class="custom-control-label" for="__role_{{ $role->id }}">{{ $role->name }}</label>
    </div>
@endforeach

@if ($errors->has('roles'))
    <div class="alert alert-danger">{{ $errors->first('roles') }}</div>
@endif

