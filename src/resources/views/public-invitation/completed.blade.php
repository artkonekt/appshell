@extends('appshell::layouts.public')

@section('title'){{ __('Just joined :appname', ['appname' => $appname]) }}@stop

@section('content')
    <div class="col-md-8 col-lg-6">
        <div class="card">

            <div class="card-body">
                <h2 class="text-center">{{ __('Welcome to :appname', ['appname' => $appname]) }}</h2>
                <p class="text-center">
                    {{ __('Congrats :name, you have successfully joined :appname.', ['name' => $user->name, 'appname' => $appname]) }}
                </p>
            </div>

            <div class="card-footer">
                <a href="{{ route($appshell->routes['login']) }}" class="btn btn-info btn-block">
                    {{ __('Go to login') }}
                </a>
            </div>

        </div>
    </div>
@endsection
