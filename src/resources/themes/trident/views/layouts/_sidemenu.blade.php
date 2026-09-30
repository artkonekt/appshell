<nav id="nav-sidebar-menu">
    <h2 class="nav-menu-title">CRM</h2>
    <nav class="nav-menu">
        <div class="nav-menu-item nav-menu-group">
            @unless(Auth::guest())
                @foreach($appshellMenu->items->roots() as $item)
                    @if ($item->hasLink() && $item->isAllowed())
                        <a class="{{ $item->link->attr('class') }}" href="{!! $item->url() !!}">
                            @if($item->data('icon'))
                                {!! icon($item->data('icon')) !!}
                            @endif
                            {!! $item->title !!}
                        </a>
                    @else
                        @if($item->hasChildren())
                            @if($item->childrenAllowed()->count())
                                <span class="nav-item nav-dropdown{{ $item->hasActiveChild() ? ' open' : '' }}">
                        <a href="#sidebar-submenu-{{$item->name}}" class="nav-link nav-dropdown-toggle"
                           data-bs-toggle="collapse" aria-expanded="{{ $item->hasActiveChild() ? 'true' : 'false' }}">
                            @if($item->data('icon'))
                                {!! icon($item->data('icon')) !!}
                            @endif
                            {!! $item->title !!}
                        </a>
                        <div class="nav-dropdown-items collapse{{ $item->hasActiveChild() ? ' show' : '' }}"
                             id="sidebar-submenu-{{$item->name}}">
                            @foreach($item->children() as $childItem)
                                @if($childItem->isAllowed())
                                    <span class="nav-item {{ $childItem->attr('class') }}">
                                        <a class="nav-link {{ $childItem->link->attr('class') }}"
                                           href="{!! $childItem->url() !!}">
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
                            <span class="nav-menu-group-title">
                                @if($item->data('icon'))
                                    {!! icon($item->data('icon')) !!}
                                @endif
                                {!! $item->title !!}
                            </span>
                        @endif
                    @endif
                @endforeach
            @endunless
        </div>
    </nav>
</nav>
