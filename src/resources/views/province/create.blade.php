@extends('appshell::layouts.private')

@section('title')
    {{ __('Add Province to :country', ['country' => $country->name]) }}
@stop

@section('content')
{!! Form::open(['url' => route('appshell.province.store', $country), 'autocomplete' => 'off']) !!}

    <x-appshell::card accent="success">

        <x-slot:title>{{ __('Province To Add') }}</x-slot:title>

        @include('appshell::province._form')

        <x-slot:footer>
            <x-appshell::create-button :text="__('Add to the country')" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
