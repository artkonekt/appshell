<{{$tag}} {{ $attributes->class(["btn-$size" => $size])->merge(['class' => "btn btn-$variant"]) }} {{ $attributes }}
>@isset($icon)@if('before' === $iconPosition){!! icon($icon) !!}@endif @endisset{{ $slot }}@isset($icon)@if('before' !== $iconPosition) {!! icon($icon) !!}@endif @endisset</{{$tag}}>
