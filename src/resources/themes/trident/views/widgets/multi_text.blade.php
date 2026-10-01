{!! $primary->render($model) !!}
@foreach($extras as $extra)
  {!! $extra->render($model) !!}
@endforeach
{!! $secondary->render($model) !!}
