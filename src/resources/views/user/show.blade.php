@extends('appshell::layouts.private')

@section('title')
    {{ $user->name }}
@stop

@push('page-actions')
    @can('delete users')
        @if(Auth::id() === $user->id)
            <x-appshell::button tag="button" size="sm" variant="danger" disabled="disabled"
                :href="route('appshell.user.edit', $user)"
                :title="__('It would be quite unhealthy to delete yourself, so you can\'t')"
            >
                {{ __('Delete user') }}
            </x-appshell::button>
        @else
            {!! Form::open([
                    'route' => ['appshell.user.destroy', $user],
                    'method' => 'DELETE',
                    'data-confirmation-text' => __('Are you sure to delete poor :name?', ['name' => $user->name]),
                    'class' => "d-inline"
                    ])
            !!}

                <x-appshell::button variant="danger" type="submit" size="sm">
                    {{ __('Delete user') }}
                </x-appshell::button>
            {!! Form::close() !!}
        @endif
    @endcan

    @can('edit users')
        <x-appshell::button variant="light" size="sm" href="{{ route('appshell.user.edit', $user) }}"
            :title="__('Edit user')" icon="edit" />
    @endcan
@endpush

@section('content')

    <div class="row mb-3">
        <div class="col">
            <x-appshell::card-with-icon :type="$user->is_active ? 'success' : 'secondary'">
                {{ $user->name }}
                @if (!$user->is_active)
                    <x-appshell::badge variant="warning" font-size="6">{{ __('inactive') }}</x-appshell::badge>
                @endif

                <x-slot:icon-slot>
                    <img src="{{ avatar_image_url($user) }}"
                         alt="{{ $user->name }}"
                         class="img-avatar img-avatar-37"
                    >
                </x-slot:icon-slot>

                <x-slot:subtitle>
                    {{ __('Member since') }}
                    {{ show_date($user->created_at) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="security">
                {{ $user->type }}
                <x-slot:subtitle>
                    @if($user->roles->count())
                        {{ __('Roles') }}:
                        {{ $user->roles->take(3)->implode('name', ' | ') }}
                    @else
                        {{ __('no roles') }}
                    @endif

                    @if($user->roles->count() > 3)
                        | {{ __('+ :num more...', ['num' => $user->roles->count() - 3]) }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="star">
                {{ $user->login_count }} {{ __('logins') }}
                <x-slot:subtitle>
                    @if ($user->last_login_at)
                        {{ __('Last login') }}
                        {{ show_datetime($user->last_login_at) }}
                    @else
                        {{ __('never logged in') }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>

@stop
