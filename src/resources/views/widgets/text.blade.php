<?php
if ($bold) {
    $tagAttributes['class'] = ($tagAttributes['class'] ?? '') . 'font-weight-bold';
}
?>
@if($wrap ?? null)<{{$wrap}}@foreach($tagAttributes as $attrKey => $attrVal) {{ $attrKey }}="{{ $attrVal }}"@endforeach>@endif{{ $prefix }}{{ $text }}{{ $suffix }}@if($wrap ?? null)</{{$wrap}}>@endif
