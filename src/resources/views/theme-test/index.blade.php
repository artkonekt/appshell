@extends('appshell::theme-test.layout')

@section('content')
    <h1>AppShell Theme Tester</h1>
    <h2>Pick a Theme</h2>
    @foreach($themes as $id => $theme)
        <div style="margin: 1rem; padding: 1rem; background-color: #b2b2b2; border-radius: .5rem">
            <h2 style="margin: 0 0 1em;"><a style="color: {{ $theme->themeColorToHex('primary') }};" href="{{ route('appshell.dev.theme.page', [$id, 'dashboard']) }}">{{ $theme->getName() }}</a></h2>
            @foreach($colors as $id => $label)
                <span style="height: 1.25rem; width: 1.2rem; display: inline-block; margin-right: .5rem; background-color: {{ $theme->themeColorToHex($id) }}"
                      title="{{ $label }}"
                ></span>
            @endforeach
        </div>
    @endforeach
@endsection
