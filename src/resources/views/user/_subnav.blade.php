<style>
    .subnav .nav-link.active {
        border-bottom: 1px solid {{ theme_color('success') }};
    }
</style>
<div class="mb-4 subnav">
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a class="nav-link @if('users' === $active)active @endif"
               href="{{ route('appshell.user.index') }}">{{ __('Users') }}</a>
        </li>
        @can('list invitations')
        <li class="nav-item">
            <a class="nav-link @if('invitations' === $active)active @endif"
               href="{{ route('appshell.invitation.index') }}">{{ __('Invitations') }}</a>
        </li>
        @endcan
    </ul>
</div>
