@extends('appshell::layouts.private')

@section('title')
    {{ __('Users') }}
@stop

@section('page-actions')
    @can('create users')
        <x-appshell::button variant="success" size="sm" icon="+" href="{{ route('appshell.user.create') }}">
            {{ __('New User') }}
        </x-appshell::button>
    @endcan
@stop

@section('content')

    @include('appshell::user._subnav', ['active' => 'users'])

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>

        {!! $table->render($users) !!}

    </x-appshell::card>
@stop
