<header class="appshell-header container-fluid">

    <div class="row">

        <div class="col-md-6 col-lg-7">
            <h1>@yield('title')</h1>

        </div>

        <div class="col-md-6 col-lg-5 text-right">
            @if ($appshell->quick_links['enabled'])
                <div class="dropdown float-right">
                    <a class="btn btn-none" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       id="quicklinks">
                        <div class="appshell-header-user">
                            <h4><i class="zmdi zmdi-toys text-muted"></i></h4>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="quicklinks">
                        <h6 class="dropdown-header my-2">{{ __('Quick links') }}</h6>
                        @foreach(helper('quickLinks')->links() as $item)
                        <a class="dropdown-item" href="{{ $item['link'] }}"><i class="fa fa-user"></i> {{ $item['label'] }}</a>
                        @endforeach
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('appshell.quicklinks.index') }}"><i class="fa fa-user"></i> {{  __('Add or remove quick links') }}...</a>
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
                    <a class="dropdown-item" href="{{ route('appshell.account.display') }}"><i class="fa fa-user"></i> {{  __('Account') }}</a>

                    <a class="dropdown-item" href="{{ route('appshell.preferences.index') }}"><i class="fa fa-user"></i> {{  __('Preferences') }}</a>

                    <a class="dropdown-item" href="{{ route($appshell->routes['logout']) }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fa fa-lock"></i> {{ __('Logout') }}</a>

                    <form id="logout-form" action="{{ route($appshell->routes['logout']) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </div>

            </div>
        </div>

    </div>

</header>
