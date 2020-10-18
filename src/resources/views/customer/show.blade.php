@extends('appshell::layouts.private')

@section('title')
    {{ __('Viewing') }} {{ $customer->getName() }}
@stop

@section('content')

    <div class="card-deck mb-3">
        @component(theme_widget('card_with_icon'), [
                'icon' => enum_icon($customer->type),
                'type' => $customer->is_active ? 'success' : 'warning'
        ])
            {{ $customer->getName() }}
            @if (!$customer->is_active)
                <small>
                        <span class="badge badge-secondary">
                            {{ __('inactive') }}
                        </span>
                </small>
            @endif
            @slot('subtitle')
                {{ $customer->type->label() }}
            @endslot
        @endcomponent

        @component(theme_widget('card_with_icon'), [
                'icon' => 'time',
                'type' => $customer->last_purchase_at ? 'success' : null
        ])
            {{ __('Last purchase') }}
            {{ show_datetime($customer->last_purchase_at, __('never')) }}

            @slot('subtitle')
                {{ __('Customer since') }}
                {{ show_date($customer->created_at) }}
            @endslot
        @endcomponent

        @yield('widgets')

    </div>

    @yield('cards')

    @include('appshell::address._index', ['addresses' => $customer->addresses, 'of' => $customer])

    <div class="card">
        <div class="card-body">
            @can('edit customers')
            <a href="{{ route('appshell.customer.edit', $customer) }}" class="btn btn-outline-primary">{{ __('Edit customer')
            }}</a>
            @endcan

            @yield('actions')

            @can('delete customers')
                {!! Form::open(['route' => ['appshell.customer.destroy', $customer],
                                            'method' => 'DELETE',
                                            'data-confirmation-text' => __('Are you sure to delete :name?', ['name' => $customer->getName()]),
                                            'class' => 'float-right'
                                           ])
                !!}
                    <button class="btn btn-outline-danger">
                        {{ __('Delete customer') }}
                    </button>
                {!! Form::close() !!}
            @endcan

        </div>
    </div>

@stop
