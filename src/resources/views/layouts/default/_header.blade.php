<header class="appshell-header container-fluid">

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <nav>
            @stack('page-actions')
            @if ($appshell->quick_links['enabled'])
                <span class="text-secondary mx-1">&nbsp;</span>
                <button class="btn btn-sm border-0 dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" id="quicklinks" type="button">
                    {!! icon('quick-links', 'muted') !!}
                </button>

                <ul class="dropdown-menu" aria-labelledby="quicklinks">
                    <li><h6 class="dropdown-header my-2">{{ __('Quick links') }}</h6></li>
                    @foreach(helper('quickLinks')->links() as $item)
                        <li><a class="dropdown-item" href="{{ $item['link'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('appshell.quicklinks.index') }}">{{  __('Add or remove quick links') }}...</a></li>
                </ul>
            @endif
            <a href="#" id="hamburger">
                {!! icon('hamburger') !!}
            </a>
{{--            <div id="mobile-menu">--}}
{{--                @include('appshell::layouts.default._nav')--}}
{{--            </div>--}}
        </nav>
    </div>


{{--            @if ($appshell->isSearchEnabled())--}}
{{--                <button class="btn btn-none float-end" type="button" data-bs-toggle="modal"--}}
{{--                        data-bs-target="#appshell-search-modal" id="appshell-search-button"--}}
{{--                        title="{{ __('Search [SHIFT SHIFT]') }}"--}}
{{--                >--}}
{{--                    <div class="appshell-header-user">--}}
{{--                        <h4>{!! icon('search', 'muted') !!}</h4>--}}
{{--                    </div>--}}
{{--                </button>--}}
{{--            @endif--}}

</header>

@if ($appshell->isSearchEnabled())
    @include('appshell::layouts.default._search')
@endif
