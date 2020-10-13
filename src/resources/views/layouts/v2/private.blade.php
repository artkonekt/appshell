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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" media="all" type="text/css" rel="stylesheet" />
    <link href="{{ asset('/css/appshell.css') }}" media="all" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" media="all" type="text/css" rel="stylesheet" integrity="sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=" crossorigin="anonymous" />

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div class="container-fluid app-body" id="app">
        @include('appshell::layouts.v2._sidebar')

        <!-- Main content -->
        <main class="main">
            @include('appshell::layouts.v2._header')
            @include('appshell::layouts.v2._breadcrumbs')

            <div class="container-fluid">
                @include('flash::message')
                @yield('content')
            </div>
            <!-- /.conainer-fluid -->
        </main>

    </div>

    <footer class="app-footer" style="display: none">
        @section('footer')
        &copy; {{ date('Y') }}&nbsp;<a href="{{ $appshell->url }}">{{ setting('appshell.ui.name') }}</a>
        @endsection
        @yield('footer')
    </footer>

<!-- Scripts -->
@include('appshell::layouts.v2._scripts')

<script src="{{ asset('/js/appshell.js') }}"></script>

@yield('scripts')
</body>
</html>
