@extends('appshell::layouts.default')

@section('title')
    {{ __('Clients') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create clients')
                <a href="{{ route('appshell.client.create') }}" class="btn btn-sm btn-outline-success float-right">
                    <i class="zmdi zmdi-plus"></i>
                    {{ __('Create Client') }}
                </a>
                @endcan
            </div>

        </div>

        <div class="card-block">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Registered') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($clients as $client)
                    <tr>
                        <td>
                            @can('view clients')
                            <a href="{{ route('appshell.client.show', $client) }}">{{ $client->name() }}</a>
                            @else
                                {{ $client->name() }}
                            @endcan
                        </td>
                        <td><i class="zmdi zmdi-{{ enum_icon($client->type) }}"
                               title="{{ $client->type->label() }}"></i></td>
                        <td>{{ $client->created_at->diffForHumans() }}</td>
                        <td>
                            @can('edit clients')
                                <a href="{{ route('appshell.client.edit', $client) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                            @endcan

                            @can('delete clients')
                                <a href="{{ route('appshell.client.destroy', $client) }}"
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