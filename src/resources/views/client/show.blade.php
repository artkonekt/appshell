@extends('appshell::layouts.default')

@section('title')
    {{ __('Viewing') }} {{ $client->name() }}
@stop

@section('content')

    <div class="row">
        <div class="col-sm-6 col-md-3">
            @component('appshell::widgets.card_with_icon', [
                    'icon' => enum_icon($client->type),
                    'type' => $client->is_active ? 'success' : 'warning'
            ])
                {{ $client->name() }}
                @if (!$client->is_active)
                    <small>
                        <span class="badge badge-default">
                            {{ __('inactive') }}
                        </span>
                    </small>
                @endif
                @slot('subtitle')
                    {{ $client->type->label() }}
                @endslot
            @endcomponent
        </div>

        <div class="col-sm-6 col-md-4">
            @component('appshell::widgets.card_with_icon', ['icon' => 'time-countdown'])
                {{ __('Last purchase') }}
                <span title="This is fake right now">{{ $client->updated_at->diffForHumans() }}</span>

                @slot('subtitle')
                    {{ __('Client since') }}
                    {{ $client->created_at->format(__('Y-m-d H:i')) }}
                @endslot
            @endcomponent
        </div>

    </div>

    <div class="card">
        <div class="card-block">
            @can('edit clients')
            <a href="{{ route('appshell.client.edit', $client) }}" class="btn btn-outline-primary">{{ __('Edit client')
            }}</a>
            @endcan

            @can('delete clients')
                {!! Form::open(['route' => ['appshell.client.destroy', $client], 'method' => 'DELETE', 'class' =>
                "float-right"]) !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete client') }}
                </button>
                {!! Form::close() !!}
            @endcan

        </div>
    </div>

@stop