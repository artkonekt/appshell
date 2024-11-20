@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing :province', ['province' => $province->name]) }}
@stop

@section('content')
{!! Form::model($province, [
        'url'  => route('appshell.province.update', [$country, $province]),
        'method' => 'PUT'
    ])
!!}

    <x-appshell::card variant="secondary">

        <x-slot:title>{{ __('Province Details') }}</x-slot:title>

        @include('appshell::province._form')

        <x-slot:footer>
            <x-appshell::save-button model-name="province" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

{!! Form::close() !!}
@stop
