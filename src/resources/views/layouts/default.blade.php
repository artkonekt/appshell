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
    @foreach($appshell->assets->stylesheets('header') as $stylesheet)
        {!! $stylesheet->renderHtml() !!}
    @endforeach

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @foreach($appshell->assets->scripts('header') as $script)
        {!! $script->renderHtml() !!}
    @endforeach
</head>
<body>

    <div class="container-fluid app-body" id="app">
        @include('appshell::layouts.default._sidebar')

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

@foreach($appshell->assets->stylesheets('footer') as $stylesheet)
    {!! $stylesheet->renderHtml() !!}
@endforeach

<!-- Scripts -->
@include('appshell::layouts.default._scripts')

@foreach($appshell->assets->scripts('footer') as $script)
    {!! $script->renderHtml() !!}
@endforeach
@yield('scripts')
</body>
</html>
