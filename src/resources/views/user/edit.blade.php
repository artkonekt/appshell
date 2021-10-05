@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $user->name }}
@stop

@section('content')

{!! Form::model($user, [
    'route' => ['appshell.user.update', $user],
    'method' => 'PUT',
    'autocomplete' => 'off',
    'id' => 'user-form',
    'class' => 'row'
]) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title'){{ __('User Account Data') }}@endslot

        @include('appshell::user._form')

        @slot('footer')
            <button class="btn btn-primary">{{ __('Save') }}</button>
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
