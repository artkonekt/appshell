<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">☰</button>
    <a class="navbar-brand" href="{{ url('/') }}"></a>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item">
            <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
        </li>
    </ul>

    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}.jpg?s=40" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="d-md-down-none">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-header text-center">
                    <strong>{{ __('Account') }}</strong>
                </div>

                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>

                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fa fa-lock"></i> Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link navbar-toggler aside-menu-toggler" href="#">☰</a>
        </li>

    </ul>
</header>
