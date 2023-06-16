@extends('appshell::layouts.private')

@section('title')
    {{ __('Preferences') }}
@stop

@section('content')

    {!! Form::open(['route' => 'appshell.preferences.update', 'method' => 'PUT']) !!}
    @component(theme_widget('tab_control'))
        @slot('tabs')
            @component(theme_widget('tab.tabs'))
                @foreach($tree->nodes() as $tab)
                    @component(theme_widget('tab.tab'), [
                        'id' => $tab->id(),
                        'active' => $loop->first,
                        'label' => $tab->label()
                    ])
                    @endcomponent
                @endforeach
            @endcomponent
        @endslot
        @slot('panes')
            @component(theme_widget('tab.panes'))
                @foreach($tree->nodes() as $tab)
                    @component(theme_widget('tab.pane'), [
                        'id' => $tab->id(),
                        'active' => $loop->first
                    ])
                        @foreach($tab->children() as $group)
                            <x-appshell::card accent="secondary">
                                <x-slot:title>{{ $group->label() }}</x-slot:title>
                                @foreach($group->items() as $item)
                                    @component(theme_widget('form.' . $item->getWidget()->component()),
                                        array_merge([
                                            'name'  => sprintf('preferences[%s]', $item->getKey()),
                                            'value' => $item->getValue(),
                                            'options' => $item->getPreference()->options()
                                        ], $item->getWidget()->attributes())
                                    )
                                    @endcomponent
                                @endforeach
                            </x-appshell::card>
                        @endforeach
                    @endcomponent
                @endforeach
            @endcomponent
        @endslot
    @endcomponent

    <x-appshell::card class="mt-3">
        <x-appshell::save-button :text="__('Save preferences')" />
        <x-appshell::cancel-button />
    </x-appshell::card>

    {!! Form::close() !!}

@stop
