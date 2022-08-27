@extends('appshell::layouts.private')

@section('title')
    {{ __('Permissions & Roles') }}
@stop

@section('content')

    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title'){{ __('Roles') }}@endslot
        @slot('actionbar')
            @can('create roles')
                <a href="{{ route('appshell.role.create') }}"
                   class="btn btn-sm btn-outline-success float-right">
                    {!! icon('+') !!}
                    {{ __('New Role') }}
                </a>
            @endcan
        @endslot

        {!! widget('appshell::role.index.table')->render($roles) !!}

    @endcomponent

    @component(theme_widget('group'))
        @slot('title')
            {{ __('Permissions') }}
            {!! icon('help', 'info', ['title' => __("Permissions can not be edited, they are defined by System Modules")]) !!}
        @endslot

        {!! \Konekt\AppShell\Widgets::make('badges', ['color' => 'dark', 'text' => '$model.name'])->render($permissions) !!}

    @endcomponent
@stop
