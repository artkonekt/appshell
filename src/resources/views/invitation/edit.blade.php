@extends('appshell::layouts.private')

@section('title')
    {{ __('Edit Invitation') }}
@stop

@section('content')

@include('appshell::user._subnav', ['active' => 'invitations'])

{!! Form::model($invitation, [
    'route' => ['appshell.invitation.update', $invitation],
    'method' => 'PUT',
    'autocomplete' => 'off',
    'class' => 'row'
]) !!}

<div class="col-12 col-md-6 col-lg-8 col-xl-9">
    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title'){{ __('Invitee Details') }}@endslot

        @include('appshell::invitation._form')

        @slot('footer')
            <button class="btn btn-success">{{ __('Update invitation') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        @endslot
    @endcomponent
</div>

<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title'){{ __('Roles') }}@endslot

        @include('appshell::role._assignment', ['model' => $invitation])
    @endcomponent
</div>

{!! Form::close() !!}
@stop
