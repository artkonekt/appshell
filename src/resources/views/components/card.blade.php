<div {{ $attributes->class(['card', "card-accent-$accent" => $accent, 'mb-3']) }}>
    @if(isset($title) || isset($actions))
        <div class="card-header">
            <h5 class="card-title" {{ $title->attributes }}>{{ $title }}</h5>
            @isset($actions)
                <div class="card-actionbar" {!! $actions->attributes !!}>
                    {!! $actions !!}
                </div>
            @endisset
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer" {{ $footer->attributes }}>
            {!! $footer !!}
        </div>
    @endisset
</div>
