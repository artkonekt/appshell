@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new user') }}
@stop

@section('content')

@include('appshell::user._subnav', ['active' => 'users'])

{!! Form::model($user, ['route' => 'appshell.user.store', 'autocomplete' => 'off', 'class' => 'row']) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    <div class="card card-accent-success">
        <div class="card-header">{{ __('Enter Account Details') }}</div>

        <div class="card-body">
            @include('appshell::user._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Create user') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    <div class="card card-accent-success">

        <div class="card-header">{{ __('Roles') }}</div>
        <div class="card-body">
            @include('appshell::role._assignment', ['model' => $user])
        </div>
    </div>
</div>

{!! Form::close() !!}
@stop
