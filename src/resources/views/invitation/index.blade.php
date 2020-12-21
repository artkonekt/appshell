@extends('appshell::layouts.private')

@section('title')
    {{ __('Pending Invitations') }}
@stop

@section('content')

    @include('appshell::user._subnav', ['active' => 'invitations'])

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create invitations')
                    <a href="{{ route('appshell.invitation.create') }}" class="btn btn-sm btn-outline-success float-right">
                        {{ __('Invite new user') }}
                    </a>
                @endcan
            </div>

        </div>

        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th colspan="2">{{ __('Invitation') }}</th>
                    <th>{{ __('Invited at') }}</th>
                    <th>{{ __('User Type') }}</th>
                    <th>{{ __('Roles') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($invitations as $invitation)
                    <tr>
                        <td>
                            <img src="{{ avatar_image_url($invitation, 100) }}" class="img-avatar img-avatar-50">
                        </td>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                                @can('view invitations')
                                    <a href="{{ route('appshell.invitation.show', $invitation) }}">{{ $invitation->email }}</a>
                                @else
                                    {{ $invitation->email }}
                                @endcan
                            </span>
                            <span id="__invitation_tooltip_{{ $invitation->id }}"
                                  data-toggle="tooltip"
                                  title="{{ __('Invitation link for :email has been copied to the clipboard', ['email' => $invitation->email]) }}"
                                  onclick="copyInvitationLinkToClipboard({{ $invitation->id }})"
                                  style="cursor: pointer"
                            >
                                <small title="{{ __('Copy Invitation Link') }}">
                                    {!! icon('link', 'secondary') !!}
                                </small>
                                <input type="text" class="invisible"
                                       style="height: 0.5rem; width: 2rem; padding: 0;"
                                       id="__invitation_link_{{ $invitation->id }}"
                                       value="{{ route('appshell.public.invitation.show', $invitation->hash) }}"
                                />
                            </span>
                            <div class="text-muted">
                                {{ $invitation->name }}

                            </div>
                        </td>
                        <td>
                            <span class="mb-3">
                                {{ show_date($invitation->created_at) }}
                            </span>
                            <div class="text-muted">
                                {{ __('Expires at') }}
                                {{ show_datetime($invitation->expires_at, __('never')) }}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                <span class="badge badge-pill badge-primary">{{ $invitation->type->label() }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @foreach($invitation->roles as $role)
                                    <span class="badge badge-pill badge-dark">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @if($invitation->isStillValid())
                                    <span class="badge badge-pill badge-success">{{ __('active') }}</span>
                                @elseif($invitation->isExpired())
                                    <span class="badge badge-pill badge-warning">{{ __('expired') }}</span>
                                @elseif($invitation->hasBeenUtilizedAlready())
                                    <span class="badge badge-pill badge-info">{{ __('utilized') }}</span>
                                @else
                                    <span class="badge badge-pill badge-danger">{{ __('invalid') }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @can('edit invitations')
                                    <a href="{{ route('appshell.invitation.edit', $invitation) }}"
                                       class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                                @endcan

                                @can('delete invitations')
                                    {!! Form::open(['route' => ['appshell.invitation.destroy', $invitation],
                                                'method' => 'DELETE',
                                                'data-confirmation-text' => __('Are you sure to cancel the invitationof :email?', ['email' => $invitation->email])
                                                ])
                                        !!}
                                    <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Cancel') }}</button>
                                    {!! Form::close() !!}
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

@stop

@section('scripts')
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

    $('document').ready(function () {
        $('[data-toggle="tooltip"]').tooltip({trigger: 'manual', placement: 'left'})
    })
</script>
@stop
