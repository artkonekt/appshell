@extends('appshell::layouts.default')

@section('title')
    {{ __('Settings') }}
@stop

@section('content')

    {!! Form::open(['route' => 'appshell.settings.update', 'method' => 'PUT']) !!}
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
                @foreach($tab->groups() as $group)
                    @component('appshell::widgets.group', ['accent' => 'secondary'])
                        @slot('title'){{ $group->label() }}@endslot
                        @foreach($group->settings() as $setting)
                                @component('appshell::widgets.form.text', [
                                    'name'  => sprintf('settings[%s]', $setting->key()),
                                    'label' => $setting->label(),
                                    'value' => setting($setting)
                                ])
                                @endcomponent
                        @endforeach
                    @endcomponent
                @endforeach
            </div>
            @endif
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
