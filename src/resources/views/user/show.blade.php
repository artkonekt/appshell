@extends('appshell::layouts.default')

@section('title')
    {{ __('Viewing') }} {{ $user->name }}
@stop

@section('content')

    <div class="card">

        <div class="card-header">
            <i class="fa fa-user-circle-o"></i> {{ $user->name }}
            <small>{{ $user->email }}</small>
            <span class="badge badge-{{ $user->is_active ? 'success' : 'warning' }}">
                {{ $user->is_active ? __('active') : __('inactive') }}
            </span>
        </div>

        <div class="card-block">

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
        </div>
    </div>


@stop