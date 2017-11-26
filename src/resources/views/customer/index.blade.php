@extends('appshell::layouts.default')

@section('title')
    {{ __('Customers') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create customers')
                <a href="{{ route('appshell.customer.create') }}" class="btn btn-sm btn-outline-success float-right">
                    <i class="zmdi zmdi-plus"></i>
                    {{ __('Create Customer') }}
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
                @foreach($customers as $customer)
                    <tr>
                        <td>
                            @can('view customers')
                            <a href="{{ route('appshell.customer.show', $customer) }}">{{ $customer->name() }}</a>
                            @else
                                {{ $customer->name() }}
                            @endcan
                        </td>
                        <td><i class="zmdi zmdi-{{ enum_icon($customer->type) }}"
                               title="{{ $customer->type->label() }}"></i></td>
                        <td>{{ $customer->created_at->diffForHumans() }}</td>
                        <td>
                            @can('edit customers')
                                <a href="{{ route('appshell.customer.edit', $customer) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                            @endcan

                            @can('delete customers')
                                <a href="{{ route('appshell.customer.destroy', $customer) }}"
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