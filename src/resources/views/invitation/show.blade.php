@extends('appshell::layouts.private')

@section('title')
    {{ __('Invitation of :email', ['email' => $invitation->email]) }}
@stop

@push('page-actions')
    @if($invitation->hasNotBeenUtilizedYet())
        @can('edit invitations')
            <x-appshell::button :href="route('appshell.invitation.edit', $invitation)"
                                variant="light" size="sm" icon="edit"
                                :title="__('Edit invitation')"></x-appshell::button>
        @endcan

        @can('delete invitations')
            {!! Form::open([
                    'route' => ['appshell.invitation.destroy', $invitation],
                    'method' => 'DELETE',
                    'data-confirmation-text' => __('Are you sure to cancel the invitation of :email?', ['email' => $invitation->email]),
                    'class' => "d-inline"
                    ])
            !!}

            <x-appshell::button variant="danger" type="submit" size="sm">
                {{ __('Cancel invitation') }}
            </x-appshell::button>

            {!! Form::close() !!}
        @endcan

    @endif
@endpush

@section('content')

    @include('appshell::user._subnav', ['active' => 'invitations'])

    <div class="row my-3">
        <div class="col">
            <x-appshell::card-with-icon icon="email"
                :type="$invitation->isStillValid() ? 'success' : ($invitation->hasBeenUtilizedAlready() ? 'info' : 'secondary')"
            >
                {{ $invitation->email }}
                @if ($invitation->hasBeenUtilizedAlready())
                    <x-appshell::badge variant="success" font-size="6">{{ __('accepted') }}</x-appshell::badge>
                @elseif ($invitation->isNoLongerValid())
                    <x-appshell::badge variant="warning" font-size="6">{{ __('invalid') }}</x-appshell::badge>
                @endif

                <x-slot:subtitle>
                    {{ $invitation->isExpired() ? __('Expired at') : __('Expires at') }}
                    {{ show_datetime($invitation->expires_at) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="security">
                {{ $invitation->type->label() }}

                <x-slot:subtitle>
                    @if($invitation->roles->count())
                        {{ __('Roles') }}:
                        {{ $invitation->roles->take(3)->implode('name', ' | ') }}
                    @else
                        {{ __('no roles') }}
                    @endif

                    @if($invitation->roles->count() > 3)
                        | {{ __('+ :num more...', ['num' => $invitation->roles->count() - 3]) }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="user">
                @if ($invitation->hasBeenUtilizedAlready())
                    {{ __('Accepted at') }}
                    {{ show_datetime($invitation->utilized_at) }}
                @else
                    @if($invitation->isNotExpired())
                        {{ __('Not utilized yet') }}
                    @else
                        {{ __('Expired without utilization') }}
                    @endif
                @endif

                @if($invitation->getTheCreatedUser())
                        <x-slot:icon-slot>
                            <img src="{{ avatar_image_url($invitation->getTheCreatedUser()) }}"
                                 alt="{{ $invitation->getTheCreatedUser()->name }}"
                                 class="img-avatar img-avatar-37"
                            >
                        </x-slot:icon-slot>
                @endif

                <x-slot:subtitle>
                    @if ($invitation->hasBeenUtilizedAlready())
                        @can('view users')
                            @if($invitation->getTheCreatedUser())
                                <a href="{{ route('appshell.user.show', $invitation->getTheCreatedUser()) }}"
                                   class="text-muted">
                                    {{ __('Registered as :name', ['name' => $invitation->getTheCreatedUser()->name]) }}
                                </a>
                            @else
                                {{ __('User with id `:id` was created', ['id' => $invitation->user_id ?? 'NULL']) }}
                            @endif
                        @else
                            {{ __('Registered as :name', ['name' => $invitation->getTheCreatedUser()?->name]) }}
                        @endcan
                    @else
                        @if($invitation->isNotExpired())
                            {{ __('No user got registered yet') }}
                        @else
                            {{ __('No user got registered') }}
                        @endif
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

    </div>

    @if($invitation->isStillValid())
    <x-appshell::card>
        <strong>URL:</strong>
        <code class="rounded p-2 d-inline-block my-1 text-bg-dark" >{{ route('appshell.public.invitation.show', $invitation->hash) }}</code>
    </x-appshell::card>
    @endif

@stop
