@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing') }} {{ $user->name }}
@stop

@section('content')

<div class="card card-accent-secondary">

    <div class="card-header">
        {{ __('User Account Data') }}
    </div>

    {!! Form::model($user, [
                    'route' => ['appshell.user.update', $user],
                    'method' => 'PUT',
                    'autocomplete' => 'off',
                    'id' => 'user-form'
                ])
    !!}

        <div class="card-block">
            @include('appshell::user._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}
</div>

@stop
