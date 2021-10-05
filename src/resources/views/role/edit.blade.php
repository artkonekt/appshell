@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing Role') }} {{ $role->name }}
@stop

@section('content')

    {!! Form::model($role, ['route' => ['appshell.role.update', $role], 'method' => 'PUT']) !!}

    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title'){{ __('Role Details') }}@endslot

        @include('appshell::role._form')

        @slot('footer')
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        @endslot
    @endcomponent

    {!! Form::close() !!}

@stop
