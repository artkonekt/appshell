@extends('appshell::layouts.private')

@section('title')
    {{ $user->name }}
@stop

@section('page-actions')
    @can('edit users')
        <x-appshell::button variant="outline-primary" size="sm" href="{{ route('appshell.user.edit', $user) }}">
            {{ __('Edit user') }}
        </x-appshell::button>
    @endcan

    @can('delete users')
        @if(Auth::id() == $user->id)
            <x-appshell::button tag="button" variant="outline-danger" size="sm" disabled="disabled" href="{{ route('appshell.user.edit', $user) }}" title="{{ __('It would be quite unhealthy to delete yourself, so you can\'t') }}">
                {{ __('Delete user') }}
            </x-appshell::button>
        @else
            {!! Form::open([
                    'route' => ['appshell.user.destroy', $user],
                    'method' => 'DELETE',
                    'data-confirmation-text' => __('Are you sure to delete poor :name?', ['name' => $user->name]),
                    'class' => "inline-block"
                    ])
            !!}

            <x-appshell::button tag="button" variant="outline-danger" type="submit" size="sm">
                {{ __('Delete user') }}
            </x-appshell::button>
            {!! Form::close() !!}
        @endif
    @endcan
@stop

@section('content')

    <div class="row my-3">
        <div class="col">
            <x-appshell:card-with-icon
                icon="{{ $user->is_active ? 'user-active' : 'user-inactive' }}"
                type="{{ $user->is_active ? 'success' : 'warning' }}"
            >
                {{ $user->name }}
                @if (!$user->is_active)
                    <small>
                        <span class="badge rounded-pill bg-light">
                            {{ __('inactive') }}
                        </span>
                    </small>
                @endif
                <x-slot:subtitle>
                    {{ __('Member since') }}
                    {{ show_date($user->created_at) }}
                </x-slot:subtitle>

            </x-appshell:card-with-icon>
        </div>

        <div class="col">
        @component(theme_widget('card_with_icon'), [
                'icon' => 'security',
                'type' => 'info'
        ])
            {{ $user->type }}

            @slot('subtitle')
                @if($user->roles->count())
                    {{ __('Roles') }}:
                    {{ $user->roles->take(3)->implode('name', ' | ') }}
                @else
                    {{ __('no roles') }}
                @endif

                @if($user->roles->count() > 3)
                    | {{ __('+ :num more...', ['num' => $user->roles->count() - 3]) }}
                @endif
            @endslot
        @endcomponent
        </div>

        <div class="col">
        @component(theme_widget('card_with_icon'), ['icon' => 'star'])
            {{ $user->login_count }} {{ __('logins') }}

            @slot('subtitle')
                @if ($user->last_login_at)
                    {{ __('Last login') }}
                    {{ show_datetime($user->last_login_at) }}
                @else
                    {{ __('never logged in') }}
                @endif

            @endslot
        @endcomponent
        </div>

    </div>

@stop
