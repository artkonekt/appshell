@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing Role') }} {{ $role->name }}
@stop

@section('content')

<div class="card card-accent-secondary">
    <div class="card-header">
        {{ __('Role Details') }}
    </div>

    {!! Form::model($role, ['route' => ['appshell.role.update', $role], 'method' => 'PUT']) !!}

        <div class="card-block">
            @include('appshell::role._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}
</div>

@stop
