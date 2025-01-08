<!-- Breadcrumb -->
<div class="container-fluid">
@if (Breadcrumbs::exists())
    {!! Breadcrumbs::render() !!}
@else
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ $appshell->url }}">Home</a></li>
            @hasSection('breadcrumb-menu')
                @yield('breadcrumb-menu')
            @else
            <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            @endif
        </ol>
    </nav>
@endif
</div>
