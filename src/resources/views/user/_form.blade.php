<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-account-circle"></i>
        </span>
        {{ Form::text('name', null, ['class' => 'form-control form-control-lg', 'placeholder' => __('Full name')]) }}
    </div>
</div>


<hr>


<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-email"></i>
        </span>
        {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => __('E-mail address')]) }}
    </div>
</div>

<div class="form-group">
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
</div>

<hr>

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('User type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('type', $key, $user->type == $value, ['id' => "type_$key"]) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach
    </div>
</div>

<div class="form-group row">
    <label class="form-control-label col-md-2">{{ __('Active') }}</label>
    <div class="col-md-10">
        {{ Form::hidden('is_active', 0) }}
        <label class="switch switch-icon switch-pill switch-primary">
            {{ Form::checkbox('is_active', 1, null, ['class' => 'switch-input']) }}
            <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
            <span class="switch-handle"></span>
        </label>
    </div>
</div>
