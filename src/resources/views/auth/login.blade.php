@extends('appshell::layouts.public')

@section('title'){{ __('Login') }}@stop

@section('content')
    <div class="col-md-8 col-lg-6">
        <x-appshell::card tag="form" method="POST" :action="route($appshell->routes['login'])">
            @csrf

            <h2 class="text-center">{{ __('Login') }}</h2>
            <hr>
            <div class="mb-3">
                <x-appshell::floating-label :label="__('E-mail')" :is-invalid="$errors->has('email')">
                    <input id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}"
                           placeholder="{{ __('E-Mail Address') }}" required autofocus />
                </x-appshell::floating-label>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif

            </div>

            <div class="mb-3">

                <x-appshell::floating-label :label="__('Password')" :is-invalid="$errors->has('password')">
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password"
                           placeholder="{{ __('Password') }}" required />
                </x-appshell::floating-label>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif

            </div>

            <div class="mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} value="1" id="chk_remember_me">
                    <label class="form-check-label" for="chk_remember_me">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <x-slot:footer>
                <div class="d-grid">
                    <x-appshell::button variant="primary">
                        {{ __('Login') }}
                    </x-appshell::button>
                </div>

                <hr>

                <div class="text-end">
                    <a href="{{ route($appshell->routes['password.request']) }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            </x-slot:footer>

        </x-appshell::card>

    </div>
@endsection
