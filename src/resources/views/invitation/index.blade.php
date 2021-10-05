@extends('appshell::layouts.private')

@section('title')
    {{ __('Pending Invitations') }}
@stop

@section('content')

    @include('appshell::user._subnav', ['active' => 'invitations'])

    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title')@yield('title')@endslot
        @slot('actionbar')
            @can('create invitations')
                <a href="{{ route('appshell.invitation.create') }}" class="btn btn-sm btn-outline-success float-right">
                    {{ __('Invite new user') }}
                </a>
            @endcan
        @endslot

        {!! widget('appshell::invitation.index.table')->render($invitations) !!}
    @endcomponent

@stop
