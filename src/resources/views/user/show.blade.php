@extends('appshell::layouts.default')

@section('content')
    <h1>{{ $user->name }}
        <small>
            <span class="label label-{{ $user->is_active ? 'success' : 'warning' }}">
                {{ $user->is_active ? __('active') : __('inactive') }}
            </span>
        </small>
    </h1>
    <h4>{{ $user->email }}</h4>

    <table class="table">
        <tbody>
            <tr>
                <th>{{ __('Id') }}:</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>{{ __('Registered') }}:</th>
                <td>{{ $user->created_at->format(__('Y-m-d H:i')) }}</td>
            </tr>
            <tr>
                <th>{{ __('Last update') }}:</th>
                <td>{{ $user->updated_at->format(__('Y-m-d H:i')) }}</td>
            </tr>
            <tr>
                <th>{{ __('Last login') }}:</th>
                <td>{{ $user->last_login_at ? $user->last_login_at->format(__('Y-m-d H:i')) : __('never') }}</td>
            </tr>
        </tbody>
    </table>
@stop