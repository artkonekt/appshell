@extends('appshell::layouts.private')

@section('title')
    {{ __('Customers') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create customers')
                <a href="{{ route('appshell.customer.create') }}" class="btn btn-sm btn-outline-success float-right">
                    {!! icon('+') !!}
                    {{ __('Create Customer') }}
                </a>
                @endcan
            </div>

        </div>

        <div class="card-body">
            {!! $table->render($customers) !!}
        </div>
    </div>

@stop
