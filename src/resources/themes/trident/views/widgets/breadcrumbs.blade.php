<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @forelse ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">@isset($breadcrumb->icon){!! icon($breadcrumb->icon) !!}@endisset{{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb-item active">@isset($breadcrumb->icon){!! icon($breadcrumb->icon) !!}@endisset{{ $breadcrumb->title }}</li>
            @endif
        @empty
            <li class="breadcrumb-item active">&nbsp;</li>
        @endforelse
    </ol>
</nav>
