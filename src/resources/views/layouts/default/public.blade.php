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
    <link href="{{ $appshell->useMix ? mix('/css/appshell3.css') : asset('/css/appshell3.css')  }}" media="all" type="text/css" rel="stylesheet" />

    @include('appshell::layouts.default._header_includes')

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
                <img src="{{ $appshell->logoUri }}" class="w-25" />
            </div>
            <h4 class="text-center text-uppercase text-white mt-4"
                style="font-weight: 300; letter-spacing: 2px">{{ $appshell->name }}</h4>
        </div>
        <div class="col-md-3"></div>

        @yield('content')

    </div>
</div>

<!-- Scripts -->
@yield('scripts')
<script src="{{ $appshell->useMix ? mix('/js/appshell.js') : asset('/js/appshell.js') }}"></script>

@include('appshell::layouts.default._footer_includes')
</body>
</html>
