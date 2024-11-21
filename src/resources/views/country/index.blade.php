@extends('appshell::layouts.private')

@section('title')
    {{ __('Countries') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="country" route="appshell.country.create" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('appshell::country.table')->render($countries) !!}
    </x-appshell::card>

@stop
