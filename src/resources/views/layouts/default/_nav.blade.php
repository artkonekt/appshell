<ul class="nav nav-sidebar">
    @unless(Auth::guest())
        <li>
            <a href="{{ route('appshell.user.index') }}">Users</a>
        </li>
    @endunless
</ul>
