@extends('appshell::layouts.default')

@section('title')
    {{ __('Settings') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">

            </div>

        </div>

        <div class="card-block">
            Settings

        </div>
    </div>

@stop
