@extends('appshell::layouts.default')

@section('title')
    {{ __('Viewing') }} {{ $user->name }}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-3">
            @component('appshell::widgets.card_with_icon', [
                    'icon' => $user->is_active ? 'account-circle' : 'account-o',
                    'type' => $user->is_active ? 'success' : 'warning'
            ])
                {{ $user->name }}
                @if (!$user->is_active)
                    <small>
                        <span class="badge badge-default">
                            {{ __('inactive') }}
                        </span>
                    </small>
                @endif
                @slot('subtitle')
                    {{ $user->email }}
                @endslot
            @endcomponent
        </div>

        <div class="col-sm-6 col-md-3">
            @component('appshell::widgets.card_with_icon', ['icon' => 'time-countdown'])
                @if ($user->last_login_at)
                    {{ __('Last login') }}
                    {{ $user->last_login_at->diffForHumans() }}
                @else
                    {{ __('never logged in') }}
                @endif

                @slot('subtitle')
                    {{ __('Member since') }}
                    {{ $user->created_at->format(__('Y-m-d H:i')) }}

                @endslot
            @endcomponent
        </div>

        <div class="col-sm-6 col-md-3">
            @component('appshell::widgets.card_with_icon', ['icon' => 'star-circle'])
                {{ $user->login_count }}
                @slot('subtitle')
                    {{ __('Login count') }}
                @endslot
            @endcomponent
        </div>

    </div>

    <div class="card">
        <div class="card-block">
            <a href="{{ route('appshell.user.edit', $user) }}" class="btn btn-outline-primary">{{ __('Edit user') }}</a>
        </div>
    </div>

@stop