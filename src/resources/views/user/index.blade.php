@extends('appshell::layouts.default')

@section('content')

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
                    <td><a href="{{ route('appshell.user.show', $user) }}">{{ $user->email }}</a></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->created_at->diffForHumans() }}</td>
                    <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : __('never') }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>


@stop