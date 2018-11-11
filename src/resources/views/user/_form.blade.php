<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-account-circle"></i>
        </span>
        {{ Form::text('name', null, [
                'class' => 'form-control form-control-lg' . ($errors->has('name') ? ' is-invalid' : ''),
                'placeholder' => __('Full name')
            ])
        }}
        @if ($errors->has('name'))
            <div class="invalid-tooltip">{{ $errors->first('name') }}</div>
        @endif
    </div>
</div>

<hr>

<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-email"></i>
        </span>
        {{ Form::email('email', null, [
            'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
            'autocomplete' => 'off',
            'placeholder' => __('E-mail address')
            ])
        }}
        @if ($errors->has('email'))
            <div class="invalid-tooltip">{{ $errors->first('email') }}</div>
        @endif
    </div>
</div>

<div style="display: none">
    {{-- This block is to trick browser's autocompletion detection which is extremely pushy --}}
    <?php $fakeElementId = 'ooh' . uniqid(); ?>
    <input type="text" name="{{ $fakeElementId }}" id="{{ $fakeElementId }}" value="{{ uniqid() }}" />
</div>

<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-lock"></i>
        </span>
        <?php $passwordPlaceholderText = $user->exists ? __('Type new password if you want to change it') : __('Enter password') ?>
        {{ Form::password('password', [
            'class'        => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
            'autocomplete' => 'new-password',
            'placeholder'  => $passwordPlaceholderText
            ])
        }}
        @if ($errors->has('password'))
            <div class="invalid-tooltip">{{ $errors->first('password') }}</div>
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

        @if ($errors->has('type'))
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('type') }}</div>
        @endif
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

        @if ($errors->has('is_active'))
            <input type="text" hidden class="form-control is-invalid">
            <div class="invalid-feedback">{{ $errors->first('is_active') }}</div>
        @endif

    </div>
</div>

<div class="form-group row">

    <div class="col-12">
        <legend>{{ __('Roles') }}</legend>
    </div>

    @foreach($roles as $role)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" style="overflow: hidden; white-space: nowrap;">
            <label class="switch switch-icon switch-pill switch-primary">
                {{ Form::checkbox("roles[{$role->name}]", 1, $user->hasRole($role), ['class' => 'switch-input']) }}
                <span class="switch-label" data-on="&#xf26b;" data-off="&#xf136;"></span>
                <span class="switch-handle"></span>
            </label>
            {{ $role->name }}
        </div>
    @endforeach

    @if ($errors->has('roles'))
        <input type="text" hidden class="form-control is-invalid">
        <div class="invalid-feedback">{{ $errors->first('roles') }}</div>
    @endif
</div>


@section('scripts')
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#{{ $fakeElementId }}').remove();
        }, 470);
    });
</script>
@endsection
