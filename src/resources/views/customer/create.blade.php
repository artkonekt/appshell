@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new customer') }}
@stop

@section('content')
<div class="card card-accent-success">

    <div class="card-header">
        {{ __('Enter Customer Details') }}
    </div>

    {!! Form::model($customer, ['route' => 'appshell.customer.store', 'autocomplete' => 'off']) !!}

        <div class="card-body">
            @include('appshell::customer._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Create customer') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}
</div>
@stop
