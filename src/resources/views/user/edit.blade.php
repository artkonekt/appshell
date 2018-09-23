@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing') }} {{ $user->name }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card card-accent-secondary">
                <div class="card-header">
                    {{ __('User Account Data') }}
                </div>
                <div class="card-block">

                    {!! Form::model($user, ['route' => ['appshell.user.update', $user], 'method' => 'PUT']) !!}

                    @include('appshell::user._form')

                    <hr>
                    <div class="form-group">
                        <button class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="card-footer">
                    @can('delete users')
                        {!! Form::open(['route' => ['appshell.user.destroy', $user], 'method' => 'DELETE']) !!}
                        <button class="btn btn-outline-danger float-right">
                            {{ __('Delete user') }}
                        </button>
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>

    </div>


@stop
