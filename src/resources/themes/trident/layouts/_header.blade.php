<header class="page-header">
    <div class="page-header-titlebar">
        <h1 class="page-title">@yield('title')</h1>
        <div class="page-actionbar">
            @stack('page-actions')
        </div>
    </div>

    @include('trident::layouts._breadcrumbs')
</header>
