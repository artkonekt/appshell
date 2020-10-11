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
                            @component(theme_widget('group'), ['accent' => 'secondary'])
                                @slot('title'){{ $group->label() }}@endslot
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
                            @endcomponent
                        @endforeach
                    @endcomponent
                @endforeach
            @endcomponent
        @endslot
    @endcomponent

    <p>&nbsp;</p>

    <div class="card">
        <div class="card-body">
            <button class="btn btn-primary">{{ __('Save preferences') }}</button>
            <a class="btn btn-link" href="javascript:history.go(-1);">{{ __('Back without saving') }}</a>
        </div>
    </div>
    {!! Form::close() !!}

@stop
