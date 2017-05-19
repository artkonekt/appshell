@extends('appshell::layouts.default')

@section('title')
    {{ __('Editing') }} {{ $user->name }}
@stop

@section('content')

    <div class="row">

        <div class="col-xl-9">
            <div class="card">
                <div class="card-block">

                    {!! Form::open() !!}

                    @include('appshell::user._form')

                    <div class="form-group">
                        <button class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="card-footer">
                    <a href="{{ route('appshell.user.destroy', $user) }}"
                       class="btn btn-outline-danger float-right">{{ __('Delete user') }}</a>

                </div>
            </div>
        </div>

    </div>


@stop