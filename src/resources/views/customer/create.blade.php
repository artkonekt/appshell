@extends('appshell::layouts.default')

@section('title')
    {{ __('Create new customer') }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card card-accent-success">
                <div class="card-header">
                    {{ __('Enter Customer Details') }}
                </div>
                <div class="card-block">

                    {!! Form::model($customer, ['route' => 'appshell.customer.store', 'autocomplete' => 'off']) !!}

                    @include('appshell::customer._form')

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-success">{{ __('Create customer') }}</button>
                        <a href="{{ route('appshell.customer.index') }}" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>

@stop