<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-account-circle"></i>
        </span>
        {{ Form::text('name', null, ['class' => 'form-control form-control-lg', 'placeholder' => __('Full name')]) }}
    </div>
    @if ($errors->has('name'))
        <div class="form-control-feedback">{{ $errors->first('name') }}</div>
    @endif
</div>


<hr>


<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-email"></i>
        </span>
        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('E-mail address')]) }}
    </div>
    @if ($errors->has('email'))
        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
    @endif
</div>

<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-lock"></i>
        </span>
        @if ($user->exists)
            {{ Form::password('password', [
                'class' => 'form-control',
                'autocomplete'  => 'new-password',
                'placeholder' => __('Type new password if you want to change it')
                ])
            }}
        @else
            {{ Form::password('password', [
                'class' => 'form-control',
                'autocomplete'  => 'new-password',
                'placeholder' => __('Enter password')
                ])
            }}
        @endif
    </div>
    @if ($errors->has('password'))
        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
    @endif
</div>

<hr>

<div class="form-group row{{ $errors->has('type') ? ' has-danger' : '' }}">
    <label class="form-control-label col-md-2">{{ __('User type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('type', $key, $user->type == $value, ['id' => "type_$key"]) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('type'))
            <div class="form-control-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<div class="form-group row{{ $errors->has('is_active') ? ' has-danger' : '' }}">
    <label class="form-control-label col-md-2">{{ __('Active') }}</label>
    <div class="col-md-10">
        {{ Form::hidden('is_active', 0) }}
        <label class="switch switch-icon switch-pill switch-primary">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'switch-input']) }}
            <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
            <span class="switch-handle"></span>
        </label>

        @if ($errors->has('is_active'))
            <div class="form-control-feedback">{{ $errors->first('is_active') }}</div>
        @endif

    </div>
</div>

<div class="form-group row{{ $errors->has('roles') ? ' has-danger' : '' }}">

    <div class="col-12">
        <legend>{{ __('Roles') }}</legend>
    </div>

    @foreach($roles as $role)
        <div class="col-6 col-sm-2 @unless(($loop->index + 5) % 5)offset-sm-2 @endunless">
            <label class="switch switch-icon switch-pill switch-primary">
                {{ Form::checkbox("roles[{$role->name}]", 1, $user->hasRole($role), ['class' => 'switch-input']) }}
                <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
                <span class="switch-handle"></span>
            </label>
            {{ $role->name }}
        </div>
    @endforeach

    @if ($errors->has('roles'))
        <div class="form-control-feedback">{{ $errors->first('roles') }}</div>
    @endif
</div>
