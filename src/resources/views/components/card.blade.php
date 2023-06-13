<div {{ $attributes->class(['card', "card-accent-$accent" => $accent, 'mb-4']) }}>
    @if(isset($title) || isset($actions))
        <div class="card-header my-1    ">
            <h5 class="card-title pb-1" {{ $title->attributes }}>{{ $title }}</h5>
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
        <div class="card-footer py-2" {{ $footer->attributes }}>
            {!! $footer !!}
        </div>
    @endisset
</div>
