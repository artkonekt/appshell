@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $user->name }}
@stop

@section('content')

{!! Form::model($user, [
    'route' => ['appshell.user.update', $user],
    'method' => 'PUT',
    'autocomplete' => 'off',
    'id' => 'user-form',
    'class' => 'row'
]) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('User Account Data') }}</x-slot:title>
        @include('appshell::user._form')
        <x-slot:footer>
            <x-appshell::button variant="primary">{{ __('Save') }}</x-appshell::button>
            <x-appshell::button onclick="history.back();" variant="link" class="text-muted">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>
    </x-appshell::card>
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Roles') }}</x-slot:title>
        @include('appshell::role._assignment', ['model' => $user])
    </x-appshell::card>
</div>

{!! Form::close() !!}

@stop
