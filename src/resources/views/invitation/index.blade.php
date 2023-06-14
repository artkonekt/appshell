@extends('appshell::layouts.private')

@section('title')
    {{ __('Pending Invitations') }}
@stop

@push('page-actions')
    @can('create invitations')
        <x-appshell::button variant="success" size="sm" icon="+" href="{{ route('appshell.invitation.create') }}">
            {{ __('Invite new user') }}
        </x-appshell::button>
    @endcan
@endpush

@section('content')

    @include('appshell::user._subnav', ['active' => 'invitations'])

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>
        {!! widget('appshell::invitation.index.table')->render($invitations) !!}
    </x-appshell::card>
@stop
