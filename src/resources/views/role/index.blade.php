@extends('appshell::layouts.default')

@section('title')
    {{ __('Permissions & Roles') }}
@stop

@section('content')

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
                    <th>{{ __('Last update') }}</th>
                    <th class="text-right">{{ __('Users') }}</th>
                    <th style="width: 10%">&nbsp;</th>
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
                        <td>{{ $role->updated_at->diffForHumans() }}</td>
                        <td class="text-right">@component('appshell::role._user_count', ['count' => $role->users->count()]) @endcomponent</td>
                        <td>
                            @can('edit roles')
                                <a href="{{ route('appshell.role.edit', $role) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                            @endcan

                            @can('delete roles')
                                    {!! Form::open(['route' => ['appshell.role.destroy', $role],
                                            'method' => 'DELETE',
                                            'data-confirmation-text' => __('Are you sure to delete the :name role?', ['name' => $role->name])
                                            ])
                                    !!}
                                    <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</button>
                                    {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

    <div class="card card-accent-secondary" id="permissions">

        <div class="card-header">{{ __('Permissions') }}
            <i class="zmdi zmdi-info text-info" title="{{ __("Permissions can not be edited, they are defined by System Modules") }}"></i>
        </div>

        <div class="card-block">
            @foreach($permissions as $permission)
                <span class="badge badge-success badge-pill">{{ $permission->name }}</span>
            @endforeach
        </div>
    </div>

@stop
