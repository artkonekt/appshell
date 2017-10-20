<header class="appshell-header container-fluid">

    <div class="row">

        <div class="col-md-9">
            <h1>@yield('title')</h1>

        </div>

        <div class="col-md-3 dropdown text-right">
            <a class="btn dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
               id="account-dropdown-link">
                <img src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}.jpg?s=100" class="img-avatar">
                <div class="appshell-header-user">
                    <h4>{{ Auth::user()->name }}</h4>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="account-dropdown-link">
                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>

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
