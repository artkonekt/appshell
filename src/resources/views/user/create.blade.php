@extends('appshell::layouts.private')

@section('title')
    {{ __('Create new user') }}
@stop

@section('content')

{!! Form::model($user, ['route' => 'appshell.user.store', 'autocomplete' => 'off', 'class' => 'row mb-3']) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    @component(theme_widget('group'), ['accent' => 'success'])
        @slot('title'){{ __('Enter Account Details') }}@endslot

        @include('appshell::user._form')

        @slot('footer')
                <button class="btn btn-success">{{ __('Create user') }}</button>
                <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        @endslot
    @endcomponent
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    @component(theme_widget('group'), ['accent' => 'success'])
        @slot('title'){{ __('Roles') }}@endslot
        @include('appshell::role._assignment', ['model' => $user])
    @endcomponent
</div>

{!! Form::close() !!}
@stop
