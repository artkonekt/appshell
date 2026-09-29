<div @class(['card', "bg-$type-gradient" => $type, "card-accent-$type" => $type])>
    <div class="card-body {{ $cardBodyClass }}">
        <div class="fs-1 text-end {{$iconClass ?? ''}}" @unless(isset($iconSlot))style="opacity: .55"@endunless>
            @if (isset($iconSlot))
                {{ $iconSlot }}
            @elseif (isset($icon))
                {!! icon($icon) !!}
            @endif
        </div>
        <div class="fs-4 mb-0 fw-bold text-uppercase {{ $titleClass ?? '' }}">
            {{ $slot }}
        </div>
        <small class="text-uppercase fw-bold">{{ $subtitle }}</small>
        {{ $body ?? '' }}
    </div>
</div>
