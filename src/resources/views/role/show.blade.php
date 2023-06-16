@extends('appshell::layouts.private')

@section('title')
    {{ ucfirst($role->name) }} {{ __('role') }}
@stop

@push('page-actions')
    <x-appshell::standard-actions :model="$role" route="appshell.role" :name="$role->name" />
@endpush

@section('content')

    <x-appshell::card accent="secondary">
        <x-slot:title>
            {!! icon('security') !!}
            @yield('title')
            @component('appshell::role._user_count', ['count' => $role->users->count()]) @endcomponent
        </x-slot:title>

        <div class="mb-4">
            <legend>{{ __('Allows') }}</legend>
            @forelse($role->permissions as $permission)
                <x-appshell::badge variant="success">
                    {!! icon('check') !!} {{ $permission->name }}
                </x-appshell::badge>
            @empty
                <x-appshell::badge variant="warning">
                    {!! icon(':(') !!} {{ __('nothing') }}
                </x-appshell::badge>
            @endforelse
        </div>

        <?php $noperms = $permissions->diff($role->permissions); ?>
        <div class="mb-4">
            <legend>{{ __('Denies') }}</legend>
            @forelse($noperms as $permission)
                <x-appshell::badge variant="light">
                    {!! icon('cross') !!} {{ $permission->name }}
                </x-appshell::badge>
            @empty
                <x-appshell::badge variant="light">
                    {!! icon(':)') !!} {{ __('nothing') }}
                </x-appshell::badge>
            @endforelse
        </div>

        <div class="mb-4">
            <legend>{{ __('Users having this role') }}</legend>
            @forelse($role->users as $user)
                @can('view users')
                    <x-appshell::button variant="secondary" size="sm" :href="route('appshell.user.show', $user)">
                        {{ $user->name }}
                    </x-appshell::button>
                @else
                    <x-appshell::badge variant="secondary">{{ $user->name }}</x-appshell::badge>
                @endcan
            @empty
                <x-appshell::badge variant="light">{{ __('No user assigned so far') }}</x-appshell::badge>
            @endforelse
        </div>

        <x-slot:footer>
            <x-appshell::cancel-button :text="__('Back')" />
        </x-slot:footer>

    </x-appshell::card>
@stop
