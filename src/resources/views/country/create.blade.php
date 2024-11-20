@extends('appshell::layouts.private')

@section('title')
    {{ __('Create Country') }}
@stop

@section('content')
{!! Form::model($country, ['route' => 'appshell.country.store', 'autocomplete' => 'off']) !!}

    <x-appshell::card variant="success">

        <x-slot:title>{{ __('Country Details') }}</x-slot:title>

        @include('appshell::country._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="country" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
