<!-- Breadcrumb -->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('appshell.user.index') }}">{{ __('Users') }}</a></li>
    <li class="breadcrumb-item active">this.is.not.dynamic.yet.</li>

    <li class="breadcrumb-menu">
        @yield('breadcrumb-menu')
    </li>
</ol>