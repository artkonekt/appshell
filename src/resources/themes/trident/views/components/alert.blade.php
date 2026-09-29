<?php
    $attrs = ['class' => "alert alert-$variant"];
    if ($dismissable ??= false) {
        $attrs['id'] = \Illuminate\Support\Str::ulid()->toBase58();
    }
?>
<{{$tag}} {{ $attributes->merge($attrs) }} {{ $attributes }}>{{ $slot }}
@if($dismissable)<button type="button" class="btn btn-xs btn-close" aria-label="Close"
                         onclick="const el = document.getElementById('{{ $attrs['id'] }}'); el.animate([{ opacity: 1 }, { opacity: 0 }], { duration: 300 }).onfinish = () => el.remove()">&nbsp;</button>@endif</{{$tag}}>
