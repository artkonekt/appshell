@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $customer->getName() }}
@stop

@section('content')

    {!! Form::model($customer, ['route' => ['appshell.customer.update', $customer], 'method' => 'PUT']) !!}
        <div class="row">

            <div class="col-md-8 col-lg-9">
                @component(theme_widget('group'), ['accent' => 'secondary'])
                    @slot('title'){{ __('Customer Details') }}@endslot

                    @include('appshell::customer._form')
                @endcomponent
            </div>

            <div class="col-md-4 col-lg-3">
                @component(theme_widget('group'), ['accent' => 'secondary'])
                    @slot('title'){{ __('Settings') }}@endslot

                    @include('appshell::customer._settings')
                @endcomponent
            </div>

        </div>

        @component(theme_widget('group'))
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        @endcomponent
    {!! Form::close() !!}

@stop
