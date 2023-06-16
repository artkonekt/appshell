@extends('appshell::layouts.private')

@section('title')
    {{ __('Edit Invitation') }}
@stop

@section('content')

@include('appshell::user._subnav', ['active' => 'invitations'])

{!! Form::model($invitation, [
    'route' => ['appshell.invitation.update', $invitation],
    'method' => 'PUT',
    'autocomplete' => 'off',
    'class' => 'row'
]) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Invitee Details') }}</x-slot:title>
        @include('appshell::invitation._form')

        <x-slot:footer>
            <x-appshell::save-button :text="__('Update invitation')" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Roles') }}</x-slot:title>
        @include('appshell::role._assignment', ['model' => $invitation])
    </x-appshell::card>
</div>

{!! Form::close() !!}
@stop
