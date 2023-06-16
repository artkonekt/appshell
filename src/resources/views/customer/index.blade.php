@extends('appshell::layouts.private')

@section('title')
    {{ __('Customers') }}
@stop

@push('page-actions')
    <x-appshell::create-action model-name="customer" route="appshell.customer.create" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">

        <x-slot:title>@yield('title')</x-slot:title>
        <x-slot:actions>{!! $filters->render()  !!}</x-slot:actions>

        {!! $table->render($customers) !!}

    </x-appshell::card>

    <div class="my-4">
        {!! $customers->links() !!}
    </div>

@stop
