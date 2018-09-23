<header class="appshell-header container-fluid">

    <div class="row">

        <div class="col-md-6 col-lg-7">
            <h1>@yield('title')</h1>

        </div>

        <div class="col-md-6 col-lg-5 dropdown text-right">
            <a class="btn btn-none dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
               id="account-dropdown-link">
                <img src="{{ avatar_image_url(Auth::user(), 70) }}" class="img-avatar img-avatar-35">
                <div class="appshell-header-user">
                    <h4>{{ Auth::user()->name }}</h4>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="account-dropdown-link">
                <a class="dropdown-item" href="{{ route('appshell.account.display') }}"><i class="fa fa-user"></i> {{  __('Account') }}</a>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fa fa-lock"></i> {{ __('Logout') }}</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

            </div>

        </div>

    </div>

</header>
