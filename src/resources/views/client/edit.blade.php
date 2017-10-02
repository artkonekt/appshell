@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing') }} {{ $client->name() }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card card-accent-secondary">
                <div class="card-header">
                    {{ __('Client Details') }}
                </div>
                <div class="card-block">

                    {!! Form::model($client, ['route' => ['appshell.client.update', $client], 'method' => 'PUT']) !!}

                    @include('appshell::client._form')

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="card-footer">
                    @can('delete clients')
                        {!! Form::open(['route' => ['appshell.client.destroy', $client], 'method' => 'DELETE']) !!}
                        <button class="btn btn-outline-danger float-right">
                            {{ __('Delete client') }}
                        </button>
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>

    </div>


@stop