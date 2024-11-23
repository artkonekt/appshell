@extends('appshell::layouts.private')

@section('title')
    {{ $province->name }}
@stop

@push('page-actions')
    <x-appshell::standard-actions
        :model="$province"
        :name="$province->name"
        :edit-url="route('appshell.province.edit', [$province->country, $province])"
        :delete-url="route('appshell.province.destroy', [$province->country, $province])"
    />
@endpush

@section('content')
    <div class="row mb-3">
        <div class="col">
            <x-appshell::card-with-icon icon="flag" type="success">
                {{ $province->name }}

                <x-slot:subtitle>
                    {{ $province->type->label() }}
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
                @if (null !== $province->parent)
                    <?php
                        $parentName = match(auth()->user()?->can('view provinces')) {
                            true => sprintf('<a href="%s">%s</a>', route('appshell.province.show', [$province->country, $province->parent]), $province->parent->name),
                            default => $province->parent->name,
                        };
                    ?>
                    {!! __('Subunit of :parent', ['parent' => $parentName]) !!}
                @else
                    <span title="{{ __('This :type is not a subdivision of another province', ['type' => $province->type->label()]) }}">{{ __('No higher level') }}</span>
                @endif

                <x-slot:subtitle>
                    @if($province->children->count())
                        {{ __('Subdivisions') }}:
                        {{ $province->children->take(3)->implode('name', ' | ') }}
                    @else
                        {{ __('no subordinate provinces') }}
                    @endif

                    @if($province->children->count() > 3)
                        | {{ __('+ :num more...', ['num' => $province->children->count() - 3]) }}
                    @endif
                </x-slot:subtitle>
            </x-appshell::card-with-icon>
        </div>
    </div>
@stop
