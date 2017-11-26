@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing') }} {{ $customer->name() }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card card-accent-secondary">
                <div class="card-header">
                    {{ __('Customer Details') }}
                </div>
                <div class="card-block">

                    {!! Form::model($customer, ['route' => ['appshell.customer.update', $customer], 'method' => 'PUT']) !!}

                    @include('appshell::customer._form')

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('appshell.customer.index') }}" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="card-footer">
                    @can('delete customers')
                        {!! Form::open(['route' => ['appshell.customer.destroy', $customer], 'method' => 'DELETE']) !!}
                        <button class="btn btn-outline-danger float-right">
                            {{ __('Delete customer') }}
                        </button>
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>

    </div>


@stop