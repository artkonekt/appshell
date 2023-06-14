@extends('appshell::layouts.public')

@section('title'){{ __('Register') }}@stop

@section('content')
<div class="col-md-8 col-lg-6" xmlns:x-appshell="http://www.w3.org/1999/html">

    <x-appshell::card tag="form" method="POST" action="{{ route($appshell->routes['register']) }}">
        @csrf

        <h2 class="text-center">{{ __('Register') }}</h2>
        <hr>

        <div class="mb-4 row">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="mb-4 row">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                @endif
            </div>
        </div>

        <div class="mb-4 row">
            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                @endif
            </div>
        </div>

        <div class="mb-4 row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>

        <x-slot:footer>
            <div class="d-grid">
                <x-appshell::button variant="primary">{{ __('Register') }}</x-appshell::button>
            </div>
            <hr>
            <div class="text-end">
                <a href="{{ route($appshell->routes['login']) }}">{{ __('Or Try Login') }} </a>
            </div>
        </x-slot:footer>
    </x-appshell::card>
</div>
@endsection
