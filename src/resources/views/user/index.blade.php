@extends('appshell::layouts.private')

@section('title')
    {{ __('Users') }}
@stop

@push('page-actions')
    @can('create users')
        <x-appshell::button variant="success" size="sm" icon="+" href="{{ route('appshell.user.create') }}">
            {{ __('New User') }}
        </x-appshell::button>
    @endcan
@endpush

@section('content')

    @include('appshell::user._subnav', ['active' => 'users'])

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>

        {!! $table->render($users) !!}

    </x-appshell::card>

    <div class="my-4">
        {!! $users->links() !!}
    </div>

@stop
