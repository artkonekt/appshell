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

    <x-appshell::card>
        <x-slot:title>
            {{ __('Purchases') }} <span class="badge bg-secondary">{{ $purchasesCount }}</span>
        </x-slot:title>

        <x-slot:actions>
            {!! Form::open(['url' => route('appshell.customer.show', $customer), 'method' => 'GET', 'class' => 'd-flex gap-1 flex-row align-items-center flex-wrap']) !!}
                <div>
                    {{ Form::date('start_date', $period->start, [
                        'class' => 'form-control form-control-sm' . ($errors->has('start_date') ? ' is-invalid' : ''),
                    ])}}

                    @if ($errors->has('start_date'))
                        <div class="invalid-feedback">{{ $errors->first('start_date') }}</div>
                    @endif
                </div>

                <div>
                    {{ Form::date('end_date', $period->end, [
                        'class' => 'form-control form-control-sm' . ($errors->has('end_date') ? ' is-invalid' : ''),
                    ])}}

                    @if ($errors->has('end_date'))
                        <div class="invalid-feedback">{{ $errors->first('end_date') }}</div>
                    @endif
                </div>

                <div>
                    {{ Form::select('resolution', $resolutions, request('resolution'), [
                        'class' => 'form-select form-select-sm' . ($errors->has('resolution') ? ' is-invalid' : '')
                    ]) }}
                    @if ($errors->has('resolution'))
                        <div class="invalid-feedback">{{ $errors->first('resolution') }}</div>
                    @endif
                </div>

                <x-appshell::button size="sm">
                    {{ __('Filter') }}
                </x-appshell::button>
            {!! Form::close() !!}
        </x-slot:actions>

        <div id="purchasesChart" style="height:350px"></div>
    </x-appshell::card>

    @include('appshell::address._index', ['addresses' => $customer->addresses, 'of' => $customer])
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const purchasesChart = echarts.init(document.getElementById('purchasesChart'));

            window.addEventListener('resize', function () {
                purchasesChart.resize();
            });

            purchasesChart.setOption({
                xAxis: {
                    type: 'category',
                    data: @json($customerPurchases->keys()),
                },
                yAxis: {
                    type: 'value'
                },
                series: [
                    {
                        name: 'Total purchase',
                        type: 'bar',
                        data: @json($customerPurchases->values()),
                        itemStyle: {
                            color: '{{ theme_color(\Konekt\AppShell\Theme\ThemeColor::PRIMARY) }}',
                            borderRadius: 6,
                        }
                    },
                ],
                tooltip: {
                    formatter(params) {
                        return `<p>${params.name}</p>${params.marker}${params.seriesName}<span style="float: right; margin-left: 10px"><b>${params.value.toFixed(2)} {{$customer->currency}}</b></span>`;
                    },
                },
                legend: false,
                grid: {
                    left: 40,
                    top: 30,
                    right: 20,
                    bottom: 20,
                },
            });
        });
    </script>
@endsection
