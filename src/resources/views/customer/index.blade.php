@extends('appshell::layouts.private')

@section('title')
    {{ __('Customers') }}
@stop

@section('content')

    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title')@yield('title')@endslot

        @slot('actionbar')
            @can('create customers')
                <a href="{{ route('appshell.customer.create') }}" class="btn btn-sm btn-outline-success float-right">
                    {!! icon('+') !!}
                    {{ __('Create Customer') }}
                </a>
            @endcan

            {!! $filters->render()  !!}
        @endslot

        {!! $table->render($customers) !!}

    @endcomponent

    <div class="my-4">
        {!! $customers->links() !!}
    </div>

@stop
