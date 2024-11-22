@extends('appshell::layouts.private')

@section('title')
    {{ $country->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$country" route="appshell.country" :name="$country->name" />
@endpush

@section('content')

    <x-appshell::card>
        <x-slot:title>{{ __('Provinces') }}</x-slot:title>
        @include('appshell::province._index', [
            'provinces' => $country->provinces,
            'availableProvinceSeeders' => $availableProvinceSeeders,
        ])
    </x-appshell::card>

@stop
