@extends('appshell::layouts.private')

@section('title')
    {{ __('Edit Address') }}
@stop

@section('content')
<div class="card card-accent-secondary">

    <div class="card-header">
        {{ __('Address Details') }}
    </div>

    {!! Form::model($address, ['route' => ['appshell.address.update', $address], 'method' => 'PUT', 'autocomplete' => 'off']) !!}

        <div class="card-body">
            @include('appshell::address._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}

</div>
@stop
