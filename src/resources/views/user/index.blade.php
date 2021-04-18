@extends('appshell::layouts.private')

@section('title')
    {{ __('Users') }}
@stop

@section('content')

    @include('appshell::user._subnav', ['active' => 'users'])

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create users')
                <a href="{{ route('appshell.user.create') }}" class="btn btn-sm btn-outline-success float-right">
                    {!! icon('+') !!}
                    {{ __('New User') }}
                </a>
                @endcan
            </div>

        </div>

        <div class="card-body">
            {!! $table->render($users) !!}
        </div>
    </div>

@stop
