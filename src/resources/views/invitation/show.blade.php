@extends('appshell::layouts.private')

@section('title')
    {{ __('Invitation of :email', ['email' => $invitation->email]) }}
@stop

@section('content')

@include('appshell::user._subnav', ['active' => 'invitations'])

    <div class="row my-3">
        <div class="col">
        @component(theme_widget('card_with_icon'), [
                'icon' => 'email',
                'type' => $invitation->isStillValid() ? 'success' : ($invitation->hasBeenUtilizedAlready() ? 'info' : 'warning')
        ])
            {{ $invitation->email }}
            @if ($invitation->isNoLongerValid())
                <small>
                        <span class="badge rounded-pill bg-light">
                            {{ __('invalid') }}
                        </span>
                </small>
            @endif
            @slot('subtitle')
                {{ $invitation->isExpired() ? __('Expired at') : __('Expires at') }}
                {{ show_datetime($invitation->expires_at) }}
            @endslot
        @endcomponent
        </div>

        <div class="col">
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
        </div>

        <div class="col">
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
        </div>

    </div>

    @yield('cards')

@if($invitation->hasNotBeenUtilizedYet())
    <div class="card">
        <div class="card-body">

            @can('edit invitations')
            <a href="{{ route('appshell.invitation.edit', $invitation) }}" class="btn btn-outline-primary">{{ __('Edit invitation') }}</a>
            @endcan

            <span id="__invitation_tooltip_{{ $invitation->id }}"
                  data-bs-toggle="tooltip"
                  title="{{ __('Invitation link for :email has been copied to the clipboard', ['email' => $invitation->email]) }}"
                  onclick="copyInvitationLinkToClipboard({{ $invitation->id }})"
                  style="cursor: pointer"
            >
                <btn class="btn btn-outline-info" type="button" title="{{ __('Copy Invitation Link') }}">
                    {!! icon('link', 'secondary') !!}
                </btn>
                <input type="text" class="invisible"
                       style="height: 0.5rem; width: 2rem; padding: 0;"
                       id="__invitation_link_{{ $invitation->id }}"
                       value="{{ route('appshell.public.invitation.show', $invitation->hash) }}"
                />
            </span>


            @can('delete invitations')
                {!! Form::open([
                        'route' => ['appshell.invitation.destroy', $invitation],
                        'method' => 'DELETE',
                        'data-confirmation-text' => __('Are you sure to cancel the invitation of :email?', ['email' => $invitation->email]),
                        'class' => "d-inline"
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

@once
@push('footer-scripts')
    <script>
        function copyInvitationLinkToClipboard(id) {
            var element = document.getElementById("__invitation_link_" + id);

            element.classList.remove('invisible');
            element.select();
            element.setSelectionRange(0, 99999); /* For mobile devices */
            document.execCommand('copy');
            element.classList.add('invisible');
            $('#__invitation_tooltip_' + id).tooltip('show');
            setTimeout(function () {
                $('#__invitation_tooltip_' + id).tooltip('hide');
            }, 1750)
        }
    </script>
@endpush
@push('onload-scripts')
    $('[data-bs-toggle="tooltip"]').tooltip({trigger: 'manual', placement: 'left'})
@endpush
@endonce

