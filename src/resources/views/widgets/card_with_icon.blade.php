<div class="card{{ isset($type) ? " text-white bg-$type" : '' }}">
    <div class="card-body {{ $cardBodyClass ?? '' }}">
        <div class="h1 text-muted text-right {{ $iconClass ?? '' }}">
            @if (isset($iconSlot))
                {{ $iconSlot }}
            @elseif (isset($icon))
                {!! icon($icon) !!}
            @endif
        </div>
        <div class="h4 mb-0 text-uppercase {{ $titleClass ?? '' }}">
            {{ $slot }}
        </div>
        <small class="text-muted text-uppercase font-weight-bold">{{ $subtitle }}</small>
        {{ $body ?? '' }}
    </div>
</div>
