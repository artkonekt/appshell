<div class="dropdown">

    <a class="btn btn-none border-0 href="#" data-bs-toggle="dropdown" aria-haspopup="true"
       aria-expanded="false" id="account-dropdown-link">
        <img src="{{ avatar_image_url(Auth::user(), 48) }}" class="img-avatar img-avatar-24" alt="{{ Auth::user()->name }}">
    </a>

    <div class="dropdown-menu" aria-labelledby="account-dropdown-link" style="font-size: 83%">
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
