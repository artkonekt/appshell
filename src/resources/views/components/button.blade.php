<?php $btag = $tag ?? ($attributes->has('href') ? 'a' : 'button') ?>
<{{$btag}} {{ $attributes->class(["btn-$size" => $size, "btn-$float" => $float])->merge(['class' => "btn btn-$variant"]) }} {{ $attributes }}
>@isset($icon)@if('before' === $iconPosition){!! icon($icon) !!}@endif @endisset{{ $slot }}@isset($icon)@if('before' !== $iconPosition) {!! icon($icon) !!}@endif @endisset</{{$btag}}>
