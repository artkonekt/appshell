@extends('appshell::layouts.private')

@section('title')
    {{ __('Customers') }}
@stop

@push('page-actions')
    @can('create customers')
        <x-appshell::button variant="success" size="sm" icon="+" href="{{ route('appshell.customer.create') }}">
            {{ __('Add Customer') }}
        </x-appshell::button>
    @endcan
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
