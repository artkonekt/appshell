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
    <link href="{{ asset('/css/print.css') }}" media="all" type="text/css" rel="stylesheet" />
    {!! icon_theme_assets() !!}
</head>
<body class="has-toolbar">
<div class="noprint toolbar">
    <button onclick="window.print()" class="btn btn-primary">{{ __('Print') }}</button>
    <button onclick="window.history.back()" class="btn btn-dark">{{ __('Back') }}</button>
</div>

@yield('content')

</body>
</html>
