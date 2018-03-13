@extends('appshell::layouts.default')

@section('title')
    {{ __('Settings') }}
@stop

@section('content')

    <ul class="nav nav-tabs" role="tablist">
        @foreach($tabs as $tab)
            @if ($tab->allowed())
            <li class="nav-item">
                <a class="nav-link{{ $loop->first ? ' active show' : '' }}" data-toggle="tab" href="#{{ $tab->id() }}" role="tab"
                   aria-controls="{{ $tab->id() }}" aria-selected="true">{{ $tab->label() }}</a>
            </li>
            @endif
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($tabs as $tab)
            @if ($tab->allowed())
            <div id="{{ $tab->id() }}" class="tab-pane{{ $loop->first ? ' active show' : '' }}" role="tabpanel">
                {{$tab->label()}}

            </div>
            @endif
        @endforeach
    </div>
@stop
