<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &middot; {{ setting('appshell.ui.name') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ asset('css/appshell.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
5. '.sidebar-compact'			  - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Footer options
1. '.footer-fixed'						- Fixed footer

-->
<body class="app sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <div class="app-body" id="app">
        <div class="sidebar">
            <nav class="appshell-logo">
                <a href="{{ $appshell->url }}">
                    <img src="/images/appshell/logo.svg" class="appshell-logo-img" />
                    <h4 class="appshell-logo-text">{{ setting('appshell.ui.name') }}</h4>
                </a>
            </nav>
            <nav class="sidebar-nav">
                @include('appshell::layouts.default._nav')
            </nav>
        </div>

        <!-- Main content -->
        <main class="main">
            @include('appshell::layouts.default._header')
            @include('appshell::layouts.default._breadcrumbs')

            <div class="container-fluid">
                @include('flash::message')
                @yield('content')
            </div>
            <!-- /.conainer-fluid -->
        </main>

    </div>

    <footer class="app-footer">
        @section('footer')
        &copy; {{ date('Y') }}&nbsp;<a href="{{ $appshell->url }}">{{ setting('appshell.ui.name') }}</a>
        @endsection
        @yield('footer')
    </footer>

<!-- Scripts -->
@include('appshell::layouts.default._scripts')
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
