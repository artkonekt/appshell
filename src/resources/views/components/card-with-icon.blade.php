<?php
    $type = $type ?? null;
    $secondaryStyle = 'opacity: .55';
    if ($type) {
        if (\Konekt\AppShell\Theme\ThemeColor::SECONDARY === $type) {
            $secondaryStyle = 'color: ' . coloring()->rgba(
                    coloring()->colorAsHex(\Konekt\AppShell\Theme\ThemeColor::TEXT), .5
                ) . '!important;';
        }
    }
?>
<div @class(['card', "text-bg-$type" => $type])>
    <div class="card-body {{ $cardBodyClass }}">
        <div class="fs-1 text-end {{$iconClass ?? ''}}" @unless(isset($iconSlot))style="{{$secondaryStyle}}"@endunless>
            @if (isset($iconSlot))
                {{ $iconSlot }}
            @elseif (isset($icon))
                {!! icon($icon) !!}
            @endif
        </div>
        <div class="fs-4 mb-0 fw-bold text-uppercase {{ $titleClass ?? '' }}">
            {{ $slot }}
        </div>
        <small class="text-uppercase fw-bold" style="{{$secondaryStyle}}">{{ $subtitle }}</small>
        {{ $body ?? '' }}
    </div>
</div>
