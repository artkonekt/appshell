@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new user') }}
@stop

@section('content')
<div class="card card-accent-success">
    <div class="card-header">
        {{ __('Enter Account Details') }}
    </div>

    {!! Form::model($user, ['route' => 'appshell.user.store', 'autocomplete' => 'off']) !!}

        <div class="card-body">
            @include('appshell::user._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Create user') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}

</div>
@stop
