@extends('appshell::layouts.private')

@section('title')
    {{ __('Users') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="user" route="appshell.user.create" />
@endpush

@section('content')

    @include('appshell::user._subnav', ['active' => 'users'])

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>
        <x-slot:actions>{!! $filters->render()  !!}</x-slot:actions>

        {!! $table->render($users) !!}

    </x-appshell::card>

    <div class="my-4">
        {!! $users->links() !!}
    </div>

@stop
