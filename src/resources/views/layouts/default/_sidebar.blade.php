<div class="sidebar">
    <div class="sidebar-menu">
        <nav class="sidebar-header p-3 clearfix">
            <a href="{{ $appshell->url }}">
                <img src="{{ setting('appshell.ui.logo_uri') }}" class="appshell-logo-img" />
                <h4 class="appshell-logo-text">{{ setting('appshell.ui.name') }}</h4>
            </a>
        </nav>
        <nav class="nav sidebar-nav flex-column" id="appshell-sidebar-nav">
            @include('appshell::layouts.default._nav')
        </nav>
    </div>
</div>
