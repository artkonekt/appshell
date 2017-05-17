<ul class="nav">
    @unless(Auth::guest())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('appshell.user.index') }}">
                <i class="fa fa-user-circle-o"></i>
                {{ __('Users') }}
            </a>
        </li>
    @endunless
</ul>
