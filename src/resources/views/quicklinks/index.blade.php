@extends('appshell::layouts.private')

@section('title')
    {{ __('Quick Links') }}
@stop

@section('content')

    @component(theme_widget('group'))
        {!! Form::open(['route' => 'appshell.quicklinks.update', 'method' => 'PUT']) !!}
        @foreach($links as $item)
            <div class="form-group row">
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
        <div class="form-group row">
            <div class="col">
                <input class="form-control" type="text" name="labels[]"
                       placeholder="Label">
            </div>
            <div class="col">
                <input class="form-control" type="text" name="links[]"
                       placeholder="Link">
            </div>
        </div>

        @slot('footer')
            <button class="btn btn-primary">{{ __('Save quick links') }}</button>
            <a class="btn btn-link" href="javascript:history.go(-1);">{{ __('Back without saving') }}</a>
        @endslot
        {!! Form::close() !!}
    @endcomponent
@stop
