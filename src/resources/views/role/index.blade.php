@extends('appshell::layouts.default')

@section('title')
    {{ __('Permissions & Roles') }}
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="card card-accent-secondary" id="roles">

                <div class="card-header">
                    {{ __('Roles') }}

                    <div class="card-actionbar">
                        @can('create roles')
                            <a href="{{ route('appshell.role.create') }}"
                               class="btn btn-sm btn-outline-success float-right">
                                <i class="zmdi zmdi-plus"></i>
                                {{ __('New Role') }}
                            </a>
                        @endcan
                    </div>

                </div>

                <div class="card-block">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Users') }}</th>
                            <th>{{ __('Last update') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>
                                    @can('view roles')
                                        <a href="{{ route('appshell.role.show', $role) }}">{{ $role->name }}</a>
                                    @else
                                        {{ $role->name }}
                                    @endcan
                                </td>
                                <td>{{ $role->users->count() }}</td>
                                <td>{{ $role->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-accent-secondary" id="permissions">

                <div class="card-header">
                    {{ __('Permissions') }}

                    <div class="card-actionbar">
                        @can('create permissions')
                            <a href="{{ route('appshell.permission.create') }}"
                               class="btn btn-sm btn-outline-success float-right">
                                <i class="zmdi zmdi-plus"></i>
                                {{ __('New Permission') }}
                            </a>
                        @endcan
                    </div>

                </div>

                <div class="card-block">
                    @foreach($permissions as $permission)
                        <div class="btn-group btn-group-sm" style="margin-bottom: 5px" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary">{{ $permission->name }}</button>
                            <button type="button" class="btn btn-secondary"><i class="zmdi zmdi-more-vert"></i></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop