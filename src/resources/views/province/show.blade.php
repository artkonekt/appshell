@extends('appshell::layouts.private')

@section('title')
    {{ $province->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions
        :model="$province"
        :name="$province->name"
        :edit-url="route('appshell.province.edit', [$country, $province])"
        :delete-url="route('appshell.province.destroy', [$country, $province])"
    />
@endpush

@section('content')
    <div class="row mb-3">
        <div class="col">
            <x-appshell::card-with-icon icon="plan" type="success">
                {{ $province->name }}

                <x-slot:subtitle>
                    {{ __('Province') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="password" type="info">
                {{ $province->code }}

                <x-slot:subtitle>
                    {{ __('Code') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>

        <div class="col">
            <x-appshell::card-with-icon icon="tag">
                {{ $province->type->label() }}

                <x-slot:subtitle>
                    {{ __('Type') }}
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>

    <div class="row">
        <div class="col flex">
            <x-appshell::card class="col-md-6">
                <x-slot:title>{{ __('Parent') }}</x-slot:title>

                @if ($province->parent)
                    <a href="{{ route('appshell.province.show', [$country, $province->parent]) }}" class="d-block mb-3">
                        <button class="btn btn-sm btn-secondary" type="button">
                            {{ $province->parent->name }}
                        </button>
                    </a>
                @else
                    <p class="mb-3">{{ __('No parent available.') }}</p>
                @endif
            </x-appshell::card>

            <x-appshell::card class="col-md-6">
                <x-slot:title>{{ __('Children') }}</x-slot:title>

                @if ($province->children && $province->children->count() > 0)
                    @foreach ($province->children as $child)
                        <a href="{{ route('appshell.province.show', [$country, $child]) }}">
                            <button class="btn btn-sm btn-secondary mb-2" type="button">
                                {{ $child->name }}
                            </button>
                        </a>
                    @endforeach
                @else
                    <p class="mb-3">{{ __('No children available.') }}</p>
                @endif
            </x-appshell::card>
        </div>
    </div>
@stop
