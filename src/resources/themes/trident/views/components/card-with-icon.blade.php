<div @class(['card', "bg-$type-gradient" => $type, "card-accent-$type" => $type])>
    <div class="card-body {{ $cardBodyClass }}">
        <div class="d-flex gap-4">
            <div class="flex-shrink-0">
                <span class="{{$iconClass ?? ''}}">
                    @if (isset($iconSlot))
                        {{ $iconSlot }}
                    @elseif (isset($icon))
                        <span class="card-icon-bg bg-{{$type ?? 'light'}} ">
                        {!! icon($icon, $type ?? null, ['class' => 'card-icon']) !!}
                        </span>
                    @endif
                </span>
            </div>
            <div class="flex-grow-1">
                <div class="text-uppercase font-mono ls-01 font-xs text-color-default {{ $titleClass ?? '' }}">
                    {{ $slot }}
                </div>
                @isset($subtitleHtml)
                    {!! $subtitleHtml !!}
                @else
                    <small class="fw-medium text-color-lighter">{{ $subtitle }}</small>
                @endif
                {{ $body ?? '' }}
            </div>
        </div>
    </div>
</div>
@once
    <style>
        .card > .card-body > .d-flex > .flex-shrink-0 > span .img-avatar {
            width: 3rem!important;
            display: block;
        }
    </style>
@endonce
