@extends('appshell::layouts.default')

@section('title')
    {{ __('My Account') }}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-3">
            <div class="card card-accent-success">

                <div class="card-header">
                    {{ __('Profile Image') }}
                </div>

                <div class="card-body">
                    <img src="{{ avatar_image_url($user, 200) }}" class="img-avatar img-avatar-100">
                </div>

                <div class="card-footer">
                    <a href="https://en.gravatar.com/emails" target="_blank"
                       class="btn btn-secondary btn-sm">{{ __('Change...') }}</a>
                </div>

            </div>
        </div>

        <div class="col-sm-9">
            {!! Form::model($user, [
                    'class' => 'card card-accent-info',
                    'route' => ['appshell.account.save', $user],
                    'method' => 'PUT']
                    )
            !!}

                <div class="card-header">
                    {{ __('Account') }}
                </div>

                <div class="card-body">

                    @component('appshell::widgets.form.text', [
                        'label' => __('Display Name'),
                        'name' => 'name',
                        'value' => old('name') ?? $user->name,
                        'placeholder' => __('Your name (to be shown across the application)')
                    ])
                    @endcomponent

                    @component('appshell::widgets.form.password', [
                        'label' => __('New Password'),
                        'name' => 'password',
                        'placeholder' => __('Leave empty for no change')
                    ])
                    @endcomponent

                </div>

                <div class="card-footer">
                    <button class="btn btn-primary btn-sm">{{ __('Save') }}</button>
                </div>

            {!! Form::close() !!}

        </div>

    </div>

    <div class="card">
        <div class="card-block">
            @can('edit users')
                <a href="{{ route('appshell.user.edit', $user) }}"
                   class="btn btn-outline-primary">{{ __('Edit user') }}</a>
            @endcan

            @can('delete users')
                {!! Form::open(['route' => ['appshell.user.destroy', $user], 'method' => 'DELETE', 'class' => "float-right"]) !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete user') }}
                </button>
                {!! Form::close() !!}
            @endcan

        </div>
    </div>

@stop
