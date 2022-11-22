@extends('appshell::layouts.private')

@section('title')
    {{ __('Quick Links') }}
@stop

@section('content')

{!! Form::open(['route' => 'appshell.quicklinks.update', 'method' => 'PUT']) !!}
    <x-appshell::card>
        @foreach($links as $item)
            <div class="mb-3 row">
                <div class="col">
                    <input class="form-control" type="text" name="labels[]"
                           placeholder="Label" value="{{ $item['label'] }}">
                </div>
                <div class="col">
                    <input class="form-control" type="text" name="links[]"
                           placeholder="Link" value="{{ $item['link'] }}">
                </div>
            </div>
        @endforeach
        <div class="mb-3 row">
            <div class="col">
                <input class="form-control" type="text" name="labels[]"
                       placeholder="Label">
            </div>
            <div class="col">
                <input class="form-control" type="text" name="links[]"
                       placeholder="Link">
            </div>
        </div>

        <x-slot:footer>
            <x-appshell::button>{{ __('Save quick links') }}</x-appshell::button>
            <x-appshell::button type="link" href="javascript:history.go(-1);">{{ __('Back without saving') }}</x-appshell::button>
        </x-slot:footer>
    </x-appshell::card>
{!! Form::close() !!}

@stop
