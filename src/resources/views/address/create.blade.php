@extends('appshell::layouts.default')

@section('title')
    {{ __('Create new address') }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card card-accent-success">
                <div class="card-header">
                    {{ __('Address Details') }}
                </div>
                <div class="card-block">

                    {!! Form::model($address, ['route' => 'appshell.address.store', 'autocomplete' => 'off']) !!}

                    @include('appshell::address._form')

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-success">{{ __('Create address') }}</button>
                        <a href="{{ route('appshell.customer.index') }}" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>

@stop
