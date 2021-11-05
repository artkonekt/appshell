@extends('appshell::layouts.private')

@section('title')
    {{ __('Users') }}
@stop

@section('content')

    @include('appshell::user._subnav', ['active' => 'users'])

    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title')@yield('title')@endslot

        @slot('actionbar')
            @can('create users')
                <a href="{{ route('appshell.user.create') }}" class="btn btn-sm btn-outline-success float-right">
                    {!! icon('+') !!}
                    {{ __('New User') }}
                </a>
            @endcan

            {!! $filters->render()  !!}
        @endslot

        {!! $table->render($users) !!}

    @endcomponent

@stop
