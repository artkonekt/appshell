@extends('appshell::layouts.public')

@section('title'){{ __('Reset Password') }}@stop

@section('content')
<div class="col-md-8 col-lg-6">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route($appshell->routes['password.email']) }}">
            @csrf

            <div class="card-body">
                <h2 class="text-center">{{ __('Reset Password') }}</h2>
                <hr>

                <div class="form-group">
                    <input id="email" type="email"
                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ old('email') }}"
                           placeholder="{{ __('E-Mail Address') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
</div>
@endsection
