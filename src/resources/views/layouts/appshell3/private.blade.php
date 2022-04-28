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
    <link href="{{ $appshell->useMix ? mix('/css/appshell3.css') : asset('/css/appshell3.css') }}" media="all" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" href="https://use.typekit.net/utx1hrc.css">
    <script src="https://kit.fontawesome.com/f2a94220aa.js" crossorigin="anonymous"></script>

    {!! icon_theme_assets() !!}
    @include('appshell::layouts.appshell3._header_includes')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="appshell-layout">

    @include('appshell::layouts.appshell3._apps')
    @include('appshell::layouts.appshell3._sidemenu')

    <main id="appshell-main">
        @include('appshell::layouts.appshell3._header')
        <section class="content">
            <div class="filters">
                <button class="btn btn-sm btn-secondary">Inactives</button>
            </div>
            <div class="content-workspace">
                @yield('content')
            </div>
        </section>
    </main>

    <script src="{{ $appshell->useMix ? mix('/js/appshell3.js') : asset('/js/appshell3.js') }}"></script>

</body>

{{--<body>--}}

{{--    <div class="container-fluid app-body" id="app">--}}
{{--        @include('appshell::layouts.default._sidebar')--}}

{{--        <!-- Main content -->--}}
{{--        <main class="main">--}}
{{--            @include('appshell::layouts.default._header')--}}
{{--            @include('appshell::layouts.default._breadcrumbs')--}}

{{--            <div class="container-fluid">--}}
{{--                @include('flash::message')--}}
{{--                @yield('content')--}}
{{--            </div>--}}
{{--            <!-- /.container-fluid -->--}}
{{--        </main>--}}

{{--    </div>--}}

{{--    <footer class="app-footer">--}}
{{--        @section('footer')--}}
{{--        &copy; {{ date('Y') }}&nbsp;<a href="{{ $appshell->url }}">{{ $appshell->name }}</a>--}}
{{--        @endsection--}}
{{--        @yield('footer')--}}
{{--    </footer>--}}

{{--<!-- Scripts -->--}}
{{--<script src="{{ $appshell->useMix ? mix('/js/appshell.js') : asset('/js/appshell.js') }}"></script>--}}

{{--@include('appshell::layouts.default._scripts')--}}

{{--@include('appshell::layouts.default._footer_includes')--}}

{{--@yield('scripts')--}}
{{--@stack('footer-scripts')--}}
</body>
</html>
