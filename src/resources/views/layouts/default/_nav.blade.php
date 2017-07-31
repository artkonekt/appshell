<ul class="nav">
    @unless(Auth::guest())
        @foreach($appshellMenu->items->roots() as $item)
            @if ($item->hasLink())
                <li class="nav-item {{ $item->attr('class') }}">
                    <a class="nav-link {{ $item->link->attr('class') }}" href="{!! $item->url() !!}">
                        @if($item->data('icon'))
                            <i class="zmdi zmdi-{{ $item->data('icon') }} zmdi-hc-fw"></i>
                        @endif
                        {!! $item->title !!}
                    </a>
                </li>
            @else
                @if($item->hasChildren())
                    <li class="nav-item nav-dropdown">
                        <a href="#" class="nav-link nav-dropdown-toggle">
                            @if($item->data('icon'))
                                <i class="zmdi zmdi-{{ $item->data('icon') }} zmdi-hc-fw"></i>
                            @endif
                            {!! $item->title !!}
                        </a>
                        <ul class="nav-dropdown-items">
                            @foreach($item->children() as $childItem)
                                <li class="nav-item {{ $childItem->attr('class') }}">
                                    <a class="nav-link {{ $childItem->link->attr('class') }}" href="{!! $childItem->url() !!}">
                                        @if($childItem->data('icon'))
                                            <i class="zmdi zmdi-{{ $childItem->data('icon') }} zmdi-hc-fw"></i>
                                        @endif
                                        {!! $childItem->title !!}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="nav-title">
                        @if($item->data('icon'))
                            <i class="zmdi zmdi-{{ $item->data('icon') }} zmdi-hc-fw"></i>
                        @endif
                        {!! $item->title !!}
                    </li>
                @endif
            @endif
        @endforeach
    @endunless
</ul>
