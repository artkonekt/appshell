@extends('appshell::layouts.private')

@section('title')
    {{ __('Countries') }}
@stop

@push('page-actions')
    @if($countries->isEmpty())
        {!! Form::open(['route' => ['appshell.country.store', ['seed' => 1]], 'class' => 'd-inline']) !!}
        <x-appshell::button variant="outline-secondary" size="sm" route="appshell.country.create" icon="download">
            {{ __('Generate all countries') }}
        </x-appshell::button>
        {!! Form::close() !!}
    @endif
    <x-appshell::create-action model-name="country" route="appshell.country.create" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>@yield('title')</x-slot:title>

        {!! widget('appshell::country.table')->render($countries) !!}
    </x-appshell::card>

@stop
