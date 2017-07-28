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
                    <th>{{ __('E-mail') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Registered') }}</th>
                    <th>{{ __('Last login') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            @can('view users')
                            <a href="{{ route('appshell.user.show', $user) }}">{{ $user->email }}</a>
                            @else
                                {{ $user->email }}
                            @endcan
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : __('never') }}</td>
                        <td>
                            @can('edit users')
                                <a href="{{ route('appshell.user.edit', $user) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                            @endcan

                            @can('delete users')
                                <a href="{{ route('appshell.user.destroy', $user) }}"
                                   class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

@stop