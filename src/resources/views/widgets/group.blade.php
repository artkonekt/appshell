<div class="card{{ isset($accent) ? ' card-accent-' . $accent : '' }} mb-3">
    @isset($title)
    <div class="card-header">
        {{ $title }}
        @isset($actionbar)
            <div class="card-actionbar">
                {!! $actionbar !!}
            </div>
        @endisset
    </div>
    @endisset
    <div class="card-body">
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer">
            {!! $footer !!}
        </div>
    @endisset
</div>
