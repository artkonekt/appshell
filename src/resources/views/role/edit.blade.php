@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing role') }} {{ $role->name }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card card-accent-secondary">
                <div class="card-header">
                    {{ __('Role Details') }}
                </div>
                <div class="card-block">

                    {!! Form::model($role, ['route' => ['appshell.role.update', $role], 'method' => 'PUT']) !!}

                    @include('appshell::role._form')

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="card-footer">
                    @can('delete roles')
                        {!! Form::open(['route' => ['appshell.role.destroy', $role], 'method' => 'DELETE']) !!}
                        <button class="btn btn-outline-danger float-right">
                            {{ __('Delete role') }}
                        </button>
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>

    </div>


@stop