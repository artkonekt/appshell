<?php
if ($bold) {
    $tagAttributes['class'] = ($tagAttributes['class'] ?? '') . 'fw-bold';
}
if (!$color->themeColor->isNone() ) {
    $tagAttributes['class'] = ($tagAttributes['class'] ?? '') . 'text-' . $color->themeColor->value();
}
?>
@if($wrap ?? null)<{{$wrap}}@foreach($tagAttributes as $attrKey => $attrVal) {{ $attrKey }}="{{ $attrVal }}"@endforeach>@endif{{ $prefix }}{{ $text }}{{ $suffix }}@if($wrap ?? null)</{{$wrap}}>@endif
