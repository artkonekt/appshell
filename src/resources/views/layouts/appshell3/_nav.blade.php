@unless(Auth::guest())
    @foreach($appshellMenu->items->roots() as $item)
        @if ($item->hasLink() && $item->isAllowed())
            <a class="nav-item {{ $item->attr('class') }}">
                <a class="nav-link {{ $item->link->attr('class') }}" href="{!! $item->url() !!}">
                    @if($item->data('icon'))
                        {!! icon($item->data('icon')) !!}
                    @endif
                    {!! $item->title !!}
                </a>
            </a>
        @else
            @if($item->hasChildren())
                @if($item->childrenAllowed()->count())
                    <span class="nav-item nav-dropdown{{ $item->hasActiveChild() ? ' open' : '' }}">
                        <a href="#sidebar-submenu-{{$item->name}}" class="nav-link nav-dropdown-toggle" data-toggle="collapse" aria-expanded="{{ $item->hasActiveChild() ? 'true' : 'false' }}">
                            @if($item->data('icon'))
                                {!! icon($item->data('icon')) !!}
                            @endif
                            {!! $item->title !!}
                        </a>
                        <div class="nav-dropdown-items collapse{{ $item->hasActiveChild() ? ' show' : '' }}" id="sidebar-submenu-{{$item->name}}">
                            @foreach($item->children() as $childItem)
                                @if($childItem->isAllowed())
                                    <span class="nav-item {{ $childItem->attr('class') }}">
                                        <a class="nav-link {{ $childItem->link->attr('class') }}" href="{!! $childItem->url() !!}">
                                            @if($childItem->data('icon'))
                                                {!! icon($childItem->data('icon')) !!}
                                            @endif
                                            {!! $childItem->title !!}
                                        </a>
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </span>
                @endif
            @elseif ($item->isAllowed())
                <a class="nav-title">
                    @if($item->data('icon'))
                        {!! icon($item->data('icon')) !!}
                    @endif
                    {!! $item->title !!}
                </a>
            @endif
        @endif
    @endforeach
@endunless
