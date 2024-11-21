@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing :country', ['country' => $country->name]) }}
@stop

@section('content')
{!! Form::model($country, [
        'route'  => ['appshell.country.update', $country],
        'method' => 'PUT'
    ])
!!}

    <x-appshell::card variant="secondary">

        <x-slot:title>{{ __('Country Details') }}</x-slot:title>

        @include('appshell::country._form')

        <x-slot:footer>
            <x-appshell::save-button model-name="country" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
