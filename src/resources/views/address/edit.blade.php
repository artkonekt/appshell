@extends('appshell::layouts.private')

@section('title')
    {{ __('Edit Address') }}
@stop

@section('content')
{!! Form::model($address, ['route' => ['appshell.address.update', $address], 'method' => 'PUT', 'autocomplete' => 'off']) !!}
    <x-appshell::card accent="secondary">
        <x-slot:title>{{ __('Address Details') }}</x-slot:title>

        @include('appshell::address._form')

        <x-slot:footer>
            <x-appshell::save-button :text="__('Update address')" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>
{!! Form::close() !!}
@stop
