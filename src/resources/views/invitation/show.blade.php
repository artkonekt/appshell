@extends('appshell::layouts.private')

@section('title')
    {{ __('Viewing Invitation of :email', ['email' => $invitation->email]) }}
@stop

@section('content')

@include('appshell::user._subnav', ['active' => 'invitations'])

    <div class="card-deck mb-3">
        @component(theme_widget('card_with_icon'), [
                'icon' => 'email',
                'type' => $invitation->isStillValid() ? 'success' : ($invitation->hasBeenUtilizedAlready() ? 'info' : 'warning')
        ])
            {{ $invitation->email }}
            @if ($invitation->isNoLongerValid())
                <small>
                        <span class="badge badge-default">
                            {{ __('invalid') }}
                        </span>
                </small>
            @endif
            @slot('subtitle')
                {{ $invitation->isExpired() ? __('Expired at') : __('Expires at') }}
                {{ show_datetime($invitation->expires_at) }}
            @endslot
        @endcomponent

        @component(theme_widget('card_with_icon'), [
                'icon' => 'security',
                'type' => 'info'
        ])
            {{ $invitation->type->label() }}

            @slot('subtitle')
                @if($invitation->roles->count())
                    {{ __('Roles') }}:
                    {{ $invitation->roles->take(3)->implode('name', ' | ') }}
                @else
                    {{ __('no roles') }}
                @endif

                @if($invitation->roles->count() > 3)
                    | {{ __('+ :num more...', ['num' => $invitation->roles->count() - 3]) }}
                @endif
            @endslot
        @endcomponent

        @component(theme_widget('card_with_icon'), [
            'icon' => 'user',
            'type' => $invitation->hasBeenUtilizedAlready() ? 'success' : ($invitation->isExpired() ? 'warning' : null)
        ])
            @if ($invitation->hasBeenUtilizedAlready())
                {{ __('Utilized at') }}
                {{ show_datetime($invitation->utilized_at) }}
            @else
                @if($invitation->isNotExpired())
                    {{ __('Not utilized yet') }}
                @else
                    {{ __('Expired without utilization') }}
                @endif
            @endif

            @slot('subtitle')
                @if ($invitation->hasBeenUtilizedAlready())
                    @can('view users')
                        <a href="{{ route('appshell.user.show', $invitation->getTheCreatedUser()) }}" class="text-muted">
                            {{ __('Registered as :name', ['name' => $invitation->getTheCreatedUser()->name]) }}
                        </a>
                    @else
                        {{ __('Registered as :name', ['name' => $invitation->getTheCreatedUser()->name]) }}
                    @endcan
                @else
                    @if($invitation->isNotExpired())
                        {{ __('No user got registered yet') }}
                    @endif
                @endif
            @endslot
        @endcomponent

        @yield('widgets')

    </div>

    @yield('cards')

@if($invitation->hasNotBeenUtilizedYet())
    <div class="card">
        <div class="card-body">

            @can('edit invitations')
            <a href="{{ route('appshell.invitation.edit', $invitation) }}" class="btn btn-outline-primary">{{ __('Edit invitation') }}</a>
            @endcan


            @can('delete invitations')
                {!! Form::open([
                        'route' => ['appshell.invitation.destroy', $invitation],
                        'method' => 'DELETE',
                        'data-confirmation-text' => __('Are you sure to cancel the invitationof :email?', ['email' => $invitation->email]),
                        'class' => "float-right"
                        ])
                !!}

                    <button class="btn btn-outline-danger">
                        {{ __('Cancel invitation') }}
                    </button>

                {!! Form::close() !!}
            @endcan

        </div>
    </div>
@endif
@stop
