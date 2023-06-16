@extends('appshell::layouts.private')

@section('title')
    {{ __('Create New Customer') }}
@stop

@section('content')
    {!! Form::model($customer, ['route' => 'appshell.customer.store', 'autocomplete' => 'off']) !!}
        <div class="row">

            <div class="col-md-8 col-lg-9">
                <x-appshell::card accent="success">
                    <x-slot:title>{{ __('Customer Details') }}</x-slot:title>

                    @include('appshell::customer._form')
                </x-appshell::card>
            </div>

            <div class="col-md-4 col-lg-3">
                <x-appshell::card accent="success">
                    <x-slot:title>{{ __('Settings') }}</x-slot:title>

                    @include('appshell::customer._settings')
                </x-appshell::card>
            </div>

        </div>

        <x-appshell::card>
            <x-appshell::create-button model-name="customer" />
            <x-appshell::cancel-button />
        </x-appshell::card>
    {!! Form::close() !!}
@stop
