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
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{ __('E-mail') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Registered') }}</th>
                    <th>{{ __('Last login') }}</th>
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
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

@stop