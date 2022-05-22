<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &middot; {{ $appshell->name }}</title>

    @include('appshell::layouts.default._css')
    {!! icon_theme_assets() !!}

    @include('appshell::layouts.default._header_includes')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <!-- id=app is deprecated as of AppShell 3.0 and will be removed in v4.0  -->
    <div class="container-fluid app-body" id="app">
        @include('appshell::layouts.default._sidebar')

        <main class="main">
            @include('appshell::layouts.default._header')
            @include('appshell::layouts.default._breadcrumbs')

            <div class="container-fluid">
                @include('flash::message')
                @yield('content')
            </div>
        </main>
    </div>

<!-- Scripts -->
@stack('scripts')

@include('appshell::layouts.default._js')

@include('appshell::layouts.default._scripts')
@include('appshell::layouts.default._footer_includes')

@stack('footer-scripts')
</body>
</html>
