<ul class="nav">
    @unless(Auth::guest())
        @can('list users')
        <li class="nav-item">
            @foreach($appshellMenu->items as $item)
                <a class="nav-link" href="{!! $item->url() !!}">
                    @if($item->data('icon'))
                        <i class="zmdi zmdi-{{ $item->data('icon') }} zmdi-hc-fw"></i>
                    @endif
                    {!! $item->title !!}
                </a>
            @endforeach
        </li>
        @endcan
    @endunless
</ul>
