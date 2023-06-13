<!-- Breadcrumb -->
<div class="container-fluid mb-3">
@if (Breadcrumbs::exists())
    {!! Breadcrumbs::render() !!}
@else
    <nav class="breadcrumb">
        <span class="breadcrumb-item active">&nbsp;</span>
        <span class="breadcrumb-menu">
            @yield('breadcrumb-menu')
        </span>
    </nav>
@endif
</div>
