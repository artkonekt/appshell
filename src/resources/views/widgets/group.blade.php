<?php $accent = $accent ?? null ?>
<div @class(['card mb-4 mt-4', "card-accent-$accent" => $accent])>
    @isset($title)
        <div class="card-header">
            <h5 @class(['card-title', 'mb-0' => isset($actionbar)])>{{ $title }}</h5>
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
