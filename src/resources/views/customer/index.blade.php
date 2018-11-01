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
                    <th>{{ __('Registered') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                                @can('view customers')
                                    <a href="{{ route('appshell.customer.show', $customer) }}">{{ $customer->getName() }}</a>
                                @else
                                    {{ $customer->getName() }}
                                @endcan
                            </span>
                            <div class="text-muted">
                                @if ($customer->getName() == $customer->company_name)
                                    {{ $customer->firstname }} {{ $customer->lastname }}
                                @else
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="mb-3">
                                {{ $customer->created_at->diffForHumans() }}
                            </span>
                            <div class="text-muted">
                                {{ __('Last purchase') }}
                                {{ $customer->last_purchase_at ? $customer->last_purchase_at->diffForHumans() : __('never') }}
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                <i class="zmdi zmdi-{{ enum_icon($customer->type) }}"
                               title="{{ $customer->type->label() }}"></i>
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @if($customer->is_active)
                                    <span class="badge badge-pill badge-success">{{ __('active') }}</span>
                                @else
                                    <span class="badge badge-pill badge-secondary">{{ __('inactive') }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="mt-2">
                                @can('edit customers')
                                    <a href="{{ route('appshell.customer.edit', $customer) }}"
                                       class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('Edit') }}</a>
                                @endcan

                                @can('delete customers')
                                    {!! Form::open(['route' => ['appshell.customer.destroy', $customer],
                                                'method' => 'DELETE',
                                                'data-confirmation-text' => __('Are you sure to delete :name?', ['name' => $customer->getName()])
                                                ])
                                        !!}
                                    <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</button>
                                    {!! Form::close() !!}
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
