@extends('appshell::layouts.default')

@section('title')
    {{ __('Create new role') }}
@stop

@section('content')

<div class="card card-accent-success">

    <div class="card-header">
        {{ __('New Role Details') }}
    </div>

    {!! Form::open(['route' => 'appshell.role.store']) !!}

        <div class="card-block">
            @include('appshell::role._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Create role') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}
</div>

@stop
