@extends('appshell::layouts.default')

@section('title')
    {{ __('Create new role') }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card card-accent-success">
                <div class="card-header">
                    {{ __('New Role Details') }}
                </div>
                <div class="card-block">

                    {!! Form::open(['route' => 'appshell.role.store']) !!}

                    @include('appshell::role._form')

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-success">{{ __('Create role') }}</button>
                        <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>

@stop