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
    @foreach($appshell->assets['css'] as $key => $css)
        @if(is_numeric($key))
            <link href="{{ asset($css) }}" rel="stylesheet">
        @else
            <link href="{{ asset($key) }}" rel="stylesheet"
                @foreach($css as $attr => $value)
                    {{ $attr }}="{{$value}}"
                @endforeach
            />
        @endif
    @endforeach

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

@foreach($appshell->assets['js'] as $key => $js)
    @if(is_numeric($key))
        <script src="{{ asset($js) }}"></script>
    @else
        <script src="{{ asset($key) }}" @foreach($css as $attr => $value) {{ $attr }}="{{$value}}" @endforeach></script>
    @endif
@endforeach
@yield('scripts')
</body>
</html>
