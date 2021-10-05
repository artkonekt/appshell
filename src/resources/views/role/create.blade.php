@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new role') }}
@stop

@section('content')

    {!! Form::open(['route' => 'appshell.role.store']) !!}

        @component(theme_widget('group'), ['accent' => 'success'])
            @slot('title'){{ __('New Role Details') }}@endslot

            @include('appshell::role._form')

            @slot('footer')
                <button class="btn btn-success">{{ __('Create role') }}</button>
                <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
            @endslot
        @endcomponent

    {!! Form::close() !!}

@endsection
