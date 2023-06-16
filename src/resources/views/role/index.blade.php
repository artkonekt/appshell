@extends('appshell::layouts.private')

@section('title')
    {{ __('Permissions & Roles') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="role" route="appshell.role.create" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Roles') }}</x-slot:title>

        {!! widget('appshell::role.index.table')->render($roles) !!}

    </x-appshell::card>

    <x-appshell::card>
        <x-slot:title>
            {{ __('Permissions') }}
            {!! icon('help', 'info', ['title' => __("Permissions can not be edited, they are defined by the system")]) !!}
        </x-slot:title>

        {!! \Konekt\AppShell\Widgets::make('badges', ['color' => 'dark', 'text' => '$model.name'])->render($permissions) !!}
    </x-appshell::card>
@stop
