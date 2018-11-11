@extends('appshell::layouts.default')

@section('title')
    {{ __('Users') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create users')
                <a href="{{ route('appshell.user.create') }}" class="btn btn-sm btn-outline-success float-right">
                    <i class="zmdi zmdi-plus"></i>
                    {{ __('New User') }}
                </a>
                @endcan
            </div>

        </div>

        <div class="card-block">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Registered') }}</th>
                    <th>{{ __('Roles') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <img src="{{ avatar_image_url($user, 100) }}" class="img-avatar img-avatar-50">
                        </td>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                                @can('view users')
                                    <a href="{{ route('appshell.user.show', $user) }}">{{ $user->name }}</a>
                                @else
                                    {{ $user->name }}
                                @endcan
                            </span>
                            <div class="text-muted">
                                {{ $user->email }}
                            </div>
                        </td>
                        <td>
                            <span class="mb-3">
                                {{ $user->created_at->diffForHumans() }}
                            </span>
                            <div class="text-muted">
                                {{ __('Last login') }}
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : __('never') }}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @foreach($user->roles as $role)
                                    <span class="badge badge-pill badge-dark">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @if($user->is_active)
                                    <span class="badge badge-pill badge-success">{{ __('active') }}</span>
                                @else
                                    <span class="badge badge-pill badge-secondary">{{ __('inactive') }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @can('edit users')
                                    <a href="{{ route('appshell.user.edit', $user) }}"
                                       class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                                @endcan

                                @can('delete users')
                                    @if(Auth::user()->id == $user->id)
                                        <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right" disabled="disabled"
                                                title="{{ __("It would be quite unhealthy to delete yourself, so you can't") }}">
                                            {{ __('Delete') }}
                                        </button>
                                    @else
                                        {!! Form::open(['route' => ['appshell.user.destroy', $user],
                                                    'method' => 'DELETE',
                                                    'data-confirmation-text' => __('Are you sure to delete poor :name?', ['name' => $user->name])
                                                    ])
                                            !!}
                                        <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</button>
                                        {!! Form::close() !!}
                                    @endif
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
