<header class="appshell-header container-fluid">

    <div class="row">

        <div class="col-md-6 col-lg-7">
            <div id="heading-container">
                <h1>@yield('title')</h1>
                <a href="#" id="hamburger">
                    <svg viewBox="0 0 18 15">
                        <path fill="{{ theme_color('text') }}" d="M18,1.484c0,0.82-0.665,1.484-1.484,1.484H1.484C0.665,2.969,0,2.304,0,1.484l0,0C0,0.665,0.665,0,1.484,0 h15.031C17.335,0,18,0.665,18,1.484L18,1.484z"/>
                        <path fill="{{ theme_color('text') }}" d="M18,7.516C18,8.335,17.335,9,16.516,9H1.484C0.665,9,0,8.335,0,7.516l0,0c0-0.82,0.665-1.484,1.484-1.484 h15.031C17.335,6.031,18,6.696,18,7.516L18,7.516z"/>
                        <path fill="{{ theme_color('text') }}" d="M18,13.516C18,14.335,17.335,15,16.516,15H1.484C0.665,15,0,14.335,0,13.516l0,0 c0-0.82,0.665-1.484,1.484-1.484h15.031C17.335,12.031,18,12.696,18,13.516L18,13.516z"/>
                    </svg>
                </a>
                <div id="mobile-menu">
                    @include('appshell::layouts.default._nav')
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-5 text-right">
            @if ($appshell->quick_links['enabled'])
                <div class="dropdown float-right">
                    <a class="btn btn-none" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       id="quicklinks">
                        <div class="appshell-header-user">
                            <h4>{!! icon('quick-links', 'muted') !!}</h4>
                        </div>
                    </a>
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
                </div>
            @endif
            <div class="dropdown float-right">
                <a class="btn btn-none dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                   id="account-dropdown-link">
                    <img src="{{ avatar_image_url(Auth::user(), 70) }}" class="img-avatar img-avatar-35">
                    <div class="appshell-header-user">
                        <h4>{{ Auth::user()->name }}</h4>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="account-dropdown-link">
                    <a class="dropdown-item"
                       href="{{ route('appshell.account.display') }}">{{  __('Account') }}</a>
                    <a class="dropdown-item"
                       href="{{ route('appshell.preferences.index') }}">{{  __('Preferences') }}</a>
                    <a class="dropdown-item" href="{{ route($appshell->routes['logout']) }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route($appshell->routes['logout']) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </div>

            </div>
        </div>

    </div>

</header>
