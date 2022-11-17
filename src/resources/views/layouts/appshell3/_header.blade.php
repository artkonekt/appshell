<header class="page-header">
    <div class="page-header-titlebar">
        <h1 class="page-title">@yield('title')</h1>
        <div class="page-actionbar">
            @stack('page-actions')
        </div>
    </div>

    @include('appshell::layouts.appshell3._breadcrumbs')
</header>
