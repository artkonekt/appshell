<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &middot; {{ $appshell->name }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" media="all" type="text/css" rel="stylesheet" />
    <link href="{{ $appshell->useMix ? mix('/css/appshell.css') : asset('/css/appshell.css') }}" media="all" type="text/css" rel="stylesheet" />
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
@yield('scripts')

<script src="{{ $appshell->useMix ? mix('/js/appshell.js') : asset('/js/appshell.js') }}"></script>

@include('appshell::layouts.default._scripts')
@include('appshell::layouts.default._footer_includes')

@stack('footer-scripts')
</body>
</html>
