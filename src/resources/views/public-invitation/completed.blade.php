@extends('appshell::layouts.public')

@section('title'){{ __('Just joined :appname', ['appname' => $appname]) }}@stop

@section('content')
    <div class="col-md-8 col-lg-6" xmlns:x-appshell="http://www.w3.org/1999/html">
        <x-appshell::card>

            <h2 class="text-center">{{ __('Welcome to :appname', ['appname' => $appname]) }}</h2>
            <p class="text-center">
                {{ __('Congrats :name, you have successfully joined :appname.', ['name' => $user->name, 'appname' => $appname]) }}
            </p>

            <x-slot:footer>
                <div class="d-grid">
                    <x-appshell::button href="{{ route($appshell->routes['login']) }}" variant="info">
                        {{ __('Go to login') }}
                    </x-appshell::button>
                </div>
            </x-slot:footer>

        </x-appshell::card>
    </div>
@endsection
