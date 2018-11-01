@extends('appshell::layouts.default')

@section('title')
    {{ __('Settings') }}
@stop

@section('content')

    {!! Form::open(['route' => 'appshell.settings.update', 'method' => 'PUT']) !!}
    <ul class="nav nav-tabs" role="tablist">
        @foreach($tree->nodes() as $tab)
            <li class="nav-item">
                <a class="nav-link{{ $loop->first ? ' active show' : '' }}" data-toggle="tab" href="#{{ $tab->id() }}" role="tab"
                   aria-controls="{{ $tab->id() }}" aria-selected="true">{{ $tab->label() }}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach($tree->nodes() as $tab)
            <div id="{{ $tab->id() }}" class="tab-pane{{ $loop->first ? ' active show' : '' }}" role="tabpanel">
                @foreach($tab->children() as $group)
                    @component('appshell::widgets.group', ['accent' => 'secondary'])
                        @slot('title'){{ $group->label() }}@endslot
                        @foreach($group->items() as $item)
                                @component('appshell::widgets.form.' . $item->getWidget()->component(),
                                    array_merge([
                                        'name'  => sprintf('settings[%s]', $item->getKey()),
                                        'value' => $item->getValue(),
                                        'options' => $item->getSetting()->options()
                                    ], $item->getWidget()->attributes())
                                )
                                @endcomponent
                        @endforeach
                    @endcomponent
                @endforeach
            </div>
        @endforeach
    </div>

    <p>&nbsp;</p>

    <div class="card">
        <div class="card-block">
            <button class="btn btn-primary">{{ __('Save settings') }}</button>
            <a class="btn btn-link" href="javascript:history.go(-1);">{{ __('Back without saving') }}</a>
        </div>
    </div>
    {!! Form::close() !!}

@stop
