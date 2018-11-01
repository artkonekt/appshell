@extends('appshell::layouts.default')

@section('title')
    {{ __('Create new address') }}
@stop

@section('content')
<div class="card card-accent-success">

    <div class="card-header">
        {{ __('Address Details') }}
    </div>

    {!! Form::model($address, ['route' => 'appshell.address.store', 'autocomplete' => 'off']) !!}

        <div class="card-block">
            @include('appshell::address._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('Create address') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>

    {!! Form::close() !!}

</div>
@stop
