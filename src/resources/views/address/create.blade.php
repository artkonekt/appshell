@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new address') }}
@stop

@section('content')
    {!! Form::model($address, ['route' => 'appshell.address.store', 'autocomplete' => 'off']) !!}
    <x-appshell::card accent="success">
        <x-slot:title>{{ __('Address Details') }}</x-slot:title>

            @include('appshell::address._form')

            <x-slot:footer>
                <x-appshell::create-button :model-name="__('address')" />
                <x-appshell::cancel-button />
            </x-slot:footer>
    </x-appshell::card>
    {!! Form::close() !!}
@stop
