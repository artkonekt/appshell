@isset($onlyIfCan)
@can($onlyIfCan)<a href="{{ $url }}">{!! $text !!}</a>@else{!! $text !!}@endcan
@else
<a href="{{ $url }}">{!! $text !!}</a>
@endisset
