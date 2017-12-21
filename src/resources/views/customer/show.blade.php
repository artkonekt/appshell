@extends('appshell::layouts.default')

@section('title')
    {{ __('Viewing') }} {{ $customer->getName() }}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-6">
            @component('appshell::widgets.card_with_icon', [
                    'icon' => enum_icon($customer->type),
                    'type' => $customer->is_active ? 'success' : 'warning'
            ])
                {{ $customer->getName() }}
                @if (!$customer->is_active)
                    <small>
                        <span class="badge badge-default">
                            {{ __('inactive') }}
                        </span>
                    </small>
                @endif
                @slot('subtitle')
                    {{ $customer->type->label() }}
                @endslot
            @endcomponent
        </div>

        <div class="col-sm-6">
            @component('appshell::widgets.card_with_icon', ['icon' => 'time-countdown'])
                {{ __('Last purchase') }}
                <span title="This is fake right now">{{ $customer->updated_at->diffForHumans() }}</span>

                @slot('subtitle')
                    {{ __('Customer since') }}
                    {{ $customer->created_at->format(__('Y-m-d H:i')) }}
                @endslot
            @endcomponent
        </div>

        @yield('widgets')

    </div>

    @yield('cards')

    <div class="card">
        <div class="card-header">
            {{ __('Addresses') }}
            <div class="card-actionbar">
                @can('edit customers')
                    <a href="{{ route('appshell.address.create') }}?for=customer&forId={{ $customer->id }}" class="btn btn-sm btn-outline-success float-right">
                        <i class="zmdi zmdi-plus"></i>
                        {{ __('New Address') }}
                    </a>
                @endcan
            </div>
        </div>
        <div class="card-block">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Country') }}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($customer->addresses as $address)
                    <tr>
                        <td>{{ $address->name }}</td>
                        <td>{{ $address->type->label() }}</td>
                        <td>{{ $address->phone }}</td>
                        <td>
                            @component('appshell::widgets.address.short_table_row', ['address' => $address])
                            @endcomponent
                        </td>
                        <td>{{ $address->country->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center">{{ __('Customer has no addresses yet') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="card">
        <div class="card-block">
            @can('edit customers')
            <a href="{{ route('appshell.customer.edit', $customer) }}" class="btn btn-outline-primary">{{ __('Edit customer')
            }}</a>
            @endcan

            @yield('actions')

            @can('delete customers')
                {!! Form::open(['route' => ['appshell.customer.destroy', $customer], 'method' => 'DELETE', 'class' =>
                "float-right"]) !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete customer') }}
                </button>
                {!! Form::close() !!}
            @endcan

        </div>
    </div>

@stop
