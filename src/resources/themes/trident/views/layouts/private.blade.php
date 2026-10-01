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
    <link href="{{ $appshell->useMix ? mix('/build/trident.css') : asset('/build/trident.css') }}" media="all" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" href="https://use.typekit.net/utx1hrc.css">
    <script src="https://kit.fontawesome.com/f2a94220aa.js" crossorigin="anonymous"></script>

    {!! icon_theme_assets() !!}
    @include('appshell::layouts.default._header_includes')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="appshell-layout">

    @include('trident::layouts._apps')
    @include('trident::layouts._sidemenu')

    <main id="appshell-main">
        @include('trident::layouts._header')
        <section class="content">
            @include('flash::message')
            <div class="content-workspace">
                @yield('content')
            </div>
        </section>
    </main>

    <script src="{{ $appshell->useMix ? mix('/build/trident.js') : asset('/build/trident.js') }}"></script>

</body>

@stack('footer-scripts')
@include('appshell::layouts.default._footer_includes')
@yield('scripts')
@stack('bottom')
</body>
</html>
