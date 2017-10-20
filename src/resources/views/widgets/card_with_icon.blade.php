<div class="card">
    <div class="card-block{{ isset($type) ? " text-white bg-$type" : '' }}">
        <div class="h1 text-muted text-right m-b-2">
            @if (isset($iconSlot))
                {{ $iconSlot }}
            @elseif (isset($icon))
                <i class="zmdi zmdi-{{ $icon }}"></i>
            @endif
        </div>
        <div class="h4 m-b-0 text-uppercase">
            {{ $slot }}
        </div>
        <small class="text-muted text-uppercase font-weight-bold">{{ $subtitle }}</small>
    </div>
</div>