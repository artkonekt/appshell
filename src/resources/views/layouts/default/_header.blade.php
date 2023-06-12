<header class="appshell-header container-fluid">

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <nav>
            @stack('page-actions')
            @if ($appshell->quick_links['enabled'])
                <button class="btn btn-sm border-0 dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" id="quicklinks">
                    {!! icon('quick-links', 'muted') !!}
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="quicklinks">
                        <h6 class="dropdown-header my-2">{{ __('Quick links') }}</h6>
                        @foreach(helper('quickLinks')->links() as $item)
                            <a class="dropdown-item" href="{{ $item['link'] }}">{{ $item['label'] }}</a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                           href="{{ route('appshell.quicklinks.index') }}">{{  __('Add or remove quick links') }}
                            ...</a>
                    </div>
                </button>
            @endif
            <a href="#" id="hamburger">
                {!! icon('hamburger') !!}
            </a>
            <div id="mobile-menu">
                @include('appshell::layouts.default._nav')
            </div>
        </nav>
    </div>

{{--    <div class="row">--}}

{{--        <div class="col-md-6 col-lg-7">--}}
{{--            <div id="heading-container">--}}
{{--                <h1>@yield('title')</h1>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="col-md-6 col-lg-5 text-right">--}}
{{--            @stack('page-actions')--}}
{{--            @if ($appshell->quick_links['enabled'])--}}
{{--                <div class="dropdown float-end">--}}
{{--                    <a class="btn btn-none" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
{{--                       id="quicklinks">--}}
{{--                        <div class="appshell-header-user">--}}
{{--                            <h4>{!! icon('quick-links', 'muted') !!}</h4>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="quicklinks">--}}
{{--                        <h6 class="dropdown-header my-2">{{ __('Quick links') }}</h6>--}}
{{--                        @foreach(helper('quickLinks')->links() as $item)--}}
{{--                        <a class="dropdown-item" href="{{ $item['link'] }}">{{ $item['label'] }}</a>--}}
{{--                        @endforeach--}}
{{--                        <div class="dropdown-divider"></div>--}}
{{--                        <a class="dropdown-item"--}}
{{--                           href="{{ route('appshell.quicklinks.index') }}">{{  __('Add or remove quick links') }}--}}
{{--                            ...</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
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
{{--        </div>--}}

{{--    </div>--}}

</header>

@if ($appshell->isSearchEnabled())
    @include('appshell::layouts.default._search')
@endif
