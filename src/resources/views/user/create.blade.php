@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new user') }}
@stop

@section('content')

{!! Form::model($user, ['route' => 'appshell.user.store', 'autocomplete' => 'off', 'class' => 'row mb-3']) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Enter Account Details') }}</x-slot:title>
        @include('appshell::user._form')
        <x-slot:footer>
            <x-appshell::button variant="success">{{ __('Create user') }}</x-appshell::button>
            <x-appshell::button type="button" onclick="history.back();" variant="link" class="text-muted">{{ __('Cancel') }}</x-appshell::button>
        </x-slot:footer>
    </x-appshell::card>
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Roles') }}</x-slot:title>
        @include('appshell::role._assignment', ['model' => $user])
    </x-appshell::card>
</div>

{!! Form::close() !!}
@stop
