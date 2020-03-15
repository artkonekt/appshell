<div class="card{{ isset($accent) ? ' card-accent-' . $accent : '' }}">
    <div class="card-header">
        {{ $title }}
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
