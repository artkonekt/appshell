@extends('appshell::layouts.private')

@section('title')
    {{ __('Invite new user') }}
@stop

@section('content')

{!! Form::model($invitation, ['route' => 'appshell.invitation.store', 'autocomplete' => 'off', 'class' => 'row']) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    @component(theme_widget('group'), ['accent' => 'success'])
        @slot('title'){{ __('Invitee Details') }}@endslot

        @include('appshell::invitation._form')

        @slot('footer')
            <button class="btn btn-success">{{ __('Create invitation') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        @endslot
    @endcomponent
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    @component(theme_widget('group'), ['accent' => 'success'])
        @slot('title'){{ __('Roles') }}@endslot

        @include('appshell::role._assignment', ['model' => $invitation])
    @endcomponent
</div>

{!! Form::close() !!}
@stop
