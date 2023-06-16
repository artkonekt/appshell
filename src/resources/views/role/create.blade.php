@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new role') }}
@stop

@section('content')

    {!! Form::open(['route' => 'appshell.role.store']) !!}

    <x-appshell::card accent="success">
        <x-slot:title>{{ __('New Role Details') }}</x-slot:title>

        @include('appshell::role._form')

        <x-slot:footer>
            <x-appshell::create-button model-name="role" />
            <x-appshell::cancel-button />
        </x-slot:footer>
    </x-appshell::card>

    {!! Form::close() !!}

@endsection
