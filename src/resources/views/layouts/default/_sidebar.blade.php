<div class="sidebar">
    <div class="sidebar-menu">
        <nav class="d-flex justify-content-between align-items-center p-3">
            <a href="{{ $appshell->url }}">
                <img src="{{ $appshell->logoUri }}" class="sidebar-logo-img" />
                <h4 class="sidebar-logo-text">{{ $appshell->name }}</h4>
            </a>
            @include('appshell::layouts.default._account_menu')

        </nav>
        <nav class="nav sidebar-nav flex-column" id="appshell-sidebar-nav">
            @include('appshell::layouts.default._nav')
        </nav>
        @include('appshell::layouts.default._sidebar_footer')
    </div>
</div>
