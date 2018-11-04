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
    @foreach($appshell->assets->stylesheets() as $stylesheet)
        {!! $stylesheet->renderHtml() !!}
    @endforeach

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    </head>
<body class="app flex-row bg-dark">

<div class="container">
    <div class="row justify-content-center">

        @include('flash::message')

        <div class="col-md-6 offset-md-3 text-center p-4">
            <div>
                <img src="/images/appshell/logo.svg" class="w-25" />
            </div>
            <h4 class="text-center text-uppercase text-white mt-4"
                style="font-weight: 300; letter-spacing: 2px">{{ setting('appshell.ui.name') }}</h4>
        </div>
        <div class="col-md-3"></div>

        @yield('content')

    </div>
</div>

<!-- Scripts -->
@foreach($appshell->assets->scripts() as $script)
    {!! $script->renderHtml() !!}
@endforeach
@yield('scripts')
</body>
</html>
