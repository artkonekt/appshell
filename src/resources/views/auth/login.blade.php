@extends('appshell::layouts.public')

@section('title'){{ __('Login') }}@stop

@section('content')
<div class="col-md-8 col-lg-6">
    <div class="card">
        <form method="POST" action="{{ route($appshell->routes['login']) }}">
            @csrf
            <div class="card-body">
                <h2 class="text-center">{{ __('Login') }}</h2>
                <hr>
                <div class="form-group">

                    <input id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}"
                           placeholder="{{ __('E-Mail Address') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group">

                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password"
                           placeholder="{{ __('Password') }}" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Login') }}
                </button>

                <hr>

                <div class="text-right">
                    <a class="btn btn-link" href="{{ route($appshell->routes['password.request']) }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            </div>

        </form>

        </div>
</div>
@endsection
