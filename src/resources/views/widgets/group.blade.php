<div class="card{{ isset($accent) ? ' card-accent-' . $accent : '' }} mb-3">
    <div class="card-header">
        {{ $title }}
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
