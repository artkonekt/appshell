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
                <x-appshell::button variant="success">{{ __('Create address') }}</x-appshell::button>
                <x-appshell::button variant="link" href="#" onclick="history.back();" class="text-secondary">{{ __('Cancel') }}</x-appshell::button>
            </x-slot:footer>
    </x-appshell::card>
    {!! Form::close() !!}
@stop
