@extends('appshell::layouts.default')

@section('title')
    {{ __('Viewing') }} {{ $user->name }}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-4">
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
                    {{ __('Member since') }}
                    {{ $user->created_at->format(__('Y-m-d H:i')) }}
                @endslot
            @endcomponent
        </div>

        <div class="col-sm-6 col-md-4">
            @component('appshell::widgets.card_with_icon', [
                    'icon' => 'shield-security',
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

        <div class="col-sm-6 col-md-4">
            @component('appshell::widgets.card_with_icon', ['icon' => 'star-circle'])
                {{ $user->login_count }} {{ __('logins') }}

                @slot('subtitle')
                    @if ($user->last_login_at)
                        {{ __('Last login') }}
                        {{ $user->last_login_at->diffForHumans() }}
                    @else
                        {{ __('never logged in') }}
                    @endif

                @endslot
            @endcomponent
        </div>

    </div>

    <div class="card">
        <div class="card-block">
            @can('edit users')
            <a href="{{ route('appshell.user.edit', $user) }}" class="btn btn-outline-primary">{{ __('Edit user') }}</a>
            @endcan

            @can('delete users')
                @if(Auth::user()->id == $user->id)
                    <button class="btn btn-outline-danger float-right" disabled="disabled"
                            title="{{ __("It would be quite unhealthy to delete yourself, so you can't") }}">
                        {{ __('Delete user') }}
                    </button>
                @else
                    {!! Form::open([
                            'route' => ['appshell.user.destroy', $user],
                            'method' => 'DELETE',
                            'data-confirmation-text' => __('Are you sure to delete poor :name?', ['name' => $user->name]),
                            'class' => "float-right"
                            ])
                    !!}

                        <button class="btn btn-outline-danger">
                            {{ __('Delete user') }}
                        </button>

                    {!! Form::close() !!}
                @endif
            @endcan

        </div>
    </div>

@stop
