@if($wrap ?? null)<{{$wrap}}@foreach($tagAttributes as $attrKey => $attrVal) {{ $attrKey }}="{{ $attrVal }}"@endforeach>@endif{{ $text }}@if($wrap ?? null)</{{$wrap}}>@endif
