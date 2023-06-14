@extends('appshell::layouts.private')

@section('title')
    {{ __('Invite new user') }}
@stop

@section('content')

{!! Form::model($invitation, ['route' => 'appshell.invitation.store', 'autocomplete' => 'off', 'class' => 'row']) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9" xmlns:x-appshell="http://www.w3.org/1999/html">
    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Invitee Details') }}</x-slot:title>
        @include('appshell::invitation._form')

        <x-slot:footer>
            <x-appshell::button variant="success">{{ __('Create invitation') }}</x-appshell::button>
            <x-appshell::button type="button" onclick="history.back();" variant="link" class="text-muted">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>
    </x-appshell::card>
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Roles') }}</x-slot:title>
        @include('appshell::role._assignment', ['model' => $invitation])
    </x-appshell::card>
</div>

{!! Form::close() !!}
@stop
