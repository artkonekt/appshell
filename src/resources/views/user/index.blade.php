@extends('appshell::layouts.private')

@section('title')
    {{ __('Users') }}
@stop

@section('content')

    @include('appshell::user._subnav', ['active' => 'users'])

    <x-appshell::group accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>
        <x-slot:actionbar>
            @can('create users')
                <x-appshell::button :url="route('appshell.user.create')" size="small" color="success" outline="1">
                    {!! icon('+') !!}
                    {{ __('New User') }}
                </x-appshell::button>
            @endcan
            {!! $filters->render()  !!}
        </x-slot:actionbar>

        {!! $table->render($users) !!}

    </x-appshell::group>
@stop
