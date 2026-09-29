<?php $classes = "alert alert-$variant"; $classes .= ($dismissable ?? false) ? ' alert-dismissible fade show' : ''; ?>
<{{$tag}} {{ $attributes->merge(['class' => $classes]) }} {{ $attributes }}>{{ $slot }}@if($dismissable ?? false)<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>@endif</{{$tag}}>
