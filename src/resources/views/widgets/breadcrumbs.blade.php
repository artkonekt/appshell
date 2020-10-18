<nav class="breadcrumb">
    @forelse ($breadcrumbs as $breadcrumb)
        @if ($breadcrumb->url && !$loop->last)
            <a class="breadcrumb-item"
               href="{{ $breadcrumb->url }}">@isset($breadcrumb->icon)
                    {!! icon($breadcrumb->icon) !!}
                @endisset{{ $breadcrumb->title }}
            </a>
        @else
            <span class="breadcrumb-item active">@isset($breadcrumb->icon)
                    {!! icon($breadcrumb->icon) !!}
                @endisset{{ $breadcrumb->title }}
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
