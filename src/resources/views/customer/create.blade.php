@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new customer') }}
@stop

@section('content')

    {!! Form::model($customer, ['route' => 'appshell.customer.store', 'autocomplete' => 'off']) !!}
    @component(theme_widget('group'), ['accent' => 'success'])
        @slot('title'){{ __('Enter Customer Details') }}@endslot

        @include('appshell::customer._form')

        @slot('footer')
            <button class="btn btn-success">{{ __('Create customer') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        @endslot
    @endcomponent
    {!! Form::close() !!}
@stop
