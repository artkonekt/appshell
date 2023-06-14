@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $customer->getName() }}
@stop

@section('content')

    {!! Form::model($customer, ['route' => ['appshell.customer.update', $customer], 'method' => 'PUT']) !!}
        <div class="row">

            <div class="col-md-8 col-lg-9">
                <x-appshell::card accent="secondary">
                    <x-slot:title>{{ __('Customer Details') }}</x-slot:title>

                    @include('appshell::customer._form')
                </x-appshell::card>
            </div>

            <div class="col-md-4 col-lg-3">
                <x-appshell::card accent="secondary">
                    <x-slot:title>{{ __('Settings') }}</x-slot:title>

                    @include('appshell::customer._settings')
                </x-appshell::card>
            </div>

        </div>

        <x-appshell::card>
            <x-appshell::button variant="primary">{{ __('Save') }}</x-appshell::button>
            <x-appshell::button variant="link" href="#" onclick="history.back();" class="text-secondary">{{ __('Cancel') }}</x-appshell::button>
        </x-appshell::card>

    {!! Form::close() !!}

@stop
