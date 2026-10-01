<nav id="sidebar-menu">
    <h2 class="sidebar-menu-title">CRM</h2>
    <nav class="sidebar-menu">
        <div class="sidebar-menu-item sidebar-menu-group">
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
                                <span
                                    class="sidebar-item sidebar-collapse-group{{ $item->hasActiveChild() ? ' open' : '' }}">
                        <a href="#sidebar-submenu-{{$item->name}}" class="sidebar-link sidebar-collapse-group-toggle"
                           data-bs-toggle="collapse" aria-expanded="{{ $item->hasActiveChild() ? 'true' : 'false' }}">
                            @if($item->data('icon'))
                                {!! icon($item->data('icon')) !!}
                            @endif
                            <span>{!! $item->title !!}</span>
                            {!! icon('>', null, ['class' => 'sidebar-collapse-group-indicator']) !!}
                        </a>
                        <div class="sidebar-collapse-group-items {{ $item->hasActiveChild() ? ' show' : '' }}"
                             id="sidebar-submenu-{{$item->name}}">
                            @foreach($item->children() as $childItem)
                                @if($childItem->isAllowed())
                                    <span class="sidebar-item {{ $childItem->attr('class') }}">
                                        <a class="sidebar-link {{ $childItem->link->attr('class') }}"
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
                            <span class="sidebar-menu-group-title">
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
