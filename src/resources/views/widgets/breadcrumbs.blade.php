<nav class="breadcrumb">
    @forelse ($breadcrumbs as $breadcrumb)
        @if (!$breadcrumb->last)
            <a class="breadcrumb-item" href="{{ $breadcrumb->url }}">
                @if ( isset($breadcrumb->icon) )
                    <i class="fa {{ $breadcrumb->icon }}"></i>
                @endif
                {{ $breadcrumb->title }}
            </a>
        @else
            <span class="breadcrumb-item active">
                @if ( isset($breadcrumb->icon) )
                    <i class="fa {{ $breadcrumb->icon }}"></i>
                @endif
                {{ $breadcrumb->title }}
            </span>
        @endif
    @empty
        <span class="breadcrumb-item active">
            &nbsp;
        </span>
    @endforelse

    <span class="breadcrumb-menu">
        @yield('breadcrumb-menu')
    </span>
</nav>