<ul class="nav">
    @unless(Auth::guest())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('appshell.user.index') }}">
                <i class="zmdi zmdi-accounts zmdi-hc-fw"></i>
                {{ __('Users') }}
            </a>
        </li>
    @endunless
</ul>
