@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing Role') }} {{ $role->name }}
@stop

@section('content')

    {!! Form::model($role, ['route' => ['appshell.role.update', $role], 'method' => 'PUT']) !!}

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Role Details') }}</x-slot:title>

        @include('appshell::role._form')

        <x-slot:footer>
            <x-appshell::button variant="primary">{{ __('Save') }}</x-appshell::button>
            <x-appshell::button type="button" onclick="history.back();" variant="link" class="text-muted">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>
    </x-appshell::card>

    {!! Form::close() !!}

@stop
