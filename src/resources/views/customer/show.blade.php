@extends('appshell::layouts.default')

@section('title')
    {{ __('Viewing') }} {{ $customer->name() }}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-6">
            @component('appshell::widgets.card_with_icon', [
                    'icon' => enum_icon($customer->type),
                    'type' => $customer->is_active ? 'success' : 'warning'
            ])
                {{ $customer->name() }}
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

    </div>

    <div class="card">
        <div class="card-block">
            @can('edit customers')
            <a href="{{ route('appshell.customer.edit', $customer) }}" class="btn btn-outline-primary">{{ __('Edit customer')
            }}</a>
            @endcan

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