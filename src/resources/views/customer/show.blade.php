@extends('appshell::layouts.private')

@section('title')
    {{ $customer->getName() }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$customer" route="appshell.customer" :name="$customer->name" />
@endpush

@section('content')

    <div class="row my-3">
        <div class="col">
            <x-appshell::card-with-icon :icon="enum_icon($customer->type)" :type="$customer->is_active ? 'success' : 'warning'">
                {{ $customer->getName() }}
                @if (!$customer->is_active)
                    <x-appshell::badge variant="secondary" font-size="6">
                        {{ __('inactive') }}
                    </x-appshell::badge>
                @endif

                <x-slot:subtitle>
                    {{ $customer->type->label() }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="money" :type="$customer->last_purchase_at ? 'success' : null">
                {{ number_format($customer->ltv ?? 0) }} {{ $customer->currency }}
                <x-slot:subtitle>
                    {{ __('Lifetime Value') }} | {{ __('Last purchase') }}
                    {{ show_date($customer->last_purchase_at, __('never')) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="time" type="info">
                {{ __('Time zone') }}
                {{ $customer->timezone ?? config('app.timezone') }}
                <x-slot:subtitle>
                    {{ __('Customer since') }}
                    {{ show_date($customer->created_at) }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

    </div>

    @include('appshell::address._index', ['addresses' => $customer->addresses, 'of' => $customer])
@stop
