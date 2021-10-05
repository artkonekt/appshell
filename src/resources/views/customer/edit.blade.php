@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $customer->getName() }}
@stop

@section('content')

    {!! Form::model($customer, ['route' => ['appshell.customer.update', $customer], 'method' => 'PUT']) !!}
    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title'){{ __('Customer Details') }}@endslot

        @include('appshell::customer._form')

        @slot('footer')
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        @endslot
    @endcomponent
    {!! Form::close() !!}

@stop
