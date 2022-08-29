@extends('appshell::layouts.private')

@section('title')
    {{ $customer->getName() }}
@stop

@section('content')

    <div class="row my-3">
        <div class="col">
        @component(theme_widget('card_with_icon'), [
                'icon' => enum_icon($customer->type),
                'type' => $customer->is_active ? 'success' : 'warning'
        ])
            {{ $customer->getName() }}
            @if (!$customer->is_active)
                <small>
                        <span class="badge rounded-pill bg-secondary">
                            {{ __('inactive') }}
                        </span>
                </small>
            @endif
            @slot('subtitle')
                {{ $customer->type->label() }}
            @endslot
        @endcomponent
        </div>

        <div class="col">
        @component(theme_widget('card_with_icon'), [
                'icon' => 'money',
                'type' => $customer->last_purchase_at ? 'success' : null
        ])
            {{ number_format($customer->ltv ?? 0) }} {{ $customer->currency }}
            @slot('subtitle')
                {{ __('Lifetime Value') }} | {{ __('Last purchase') }}
                {{ show_date($customer->last_purchase_at, __('never')) }}
            @endslot
        @endcomponent
        </div>

        <div class="col">
        @component(theme_widget('card_with_icon'), [
                'icon' => 'time',
                'type' => 'info'
        ])
            {{ __('Time zone') }}
            {{ $customer->timezone ?? config('app.timezone') }}

            @slot('subtitle')
                {{ __('Customer since') }}
                {{ show_date($customer->created_at) }}
            @endslot
        @endcomponent
        </div>

    </div>

    @include('appshell::address._index', ['addresses' => $customer->addresses, 'of' => $customer])

    @component(theme_widget('group'))
        @can('edit customers')
            <a href="{{ route('appshell.customer.edit', $customer) }}" class="btn btn-outline-primary">{{ __('Edit customer') }}</a>
        @endcan

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
    @endcomponent

@stop
