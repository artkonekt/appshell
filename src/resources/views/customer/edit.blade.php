@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing') }} {{ $customer->getName() }}
@stop

@section('content')
<div class="card card-accent-secondary">
    <div class="card-header">
        {{ __('Customer Details') }}
    </div>

    {!! Form::model($customer, ['route' => ['appshell.customer.update', $customer], 'method' => 'PUT']) !!}

    <div class="card-block">
            @include('appshell::customer._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}
</div>
@stop
