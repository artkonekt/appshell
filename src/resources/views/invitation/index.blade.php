@extends('appshell::layouts.private')

@section('title')
    {{ __('Pending Invitations') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="invitation" route="appshell.invitation.create" :button-text="__('Invite new user')" />
@endpush

@section('content')

    @include('appshell::user._subnav', ['active' => 'invitations'])

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>
        {!! widget('appshell::invitation.index.table')->render($invitations) !!}
    </x-appshell::card>
@stop
