@extends('appshell::layouts.private')

@section('title')
    {{ __('My Account') }}
@stop

@push('page-actions')
    @can('edit users')
        <x-appshell::button :href="route('appshell.user.edit', $user)" variant="outline-secondary" size="sm">
            {{ __('Edit on users page') }}
        </x-appshell::button>
    @endcan
@endpush

@section('content')

    <div class="row">

        <div class="col-sm-9">
            {!! Form::model($user, [
                    'route' => ['appshell.account.save', $user],
                    'method' => 'PUT']
                )
            !!}

            <x-appshell::card accent="info">
                <x-slot:title>{{ __('User Account') }}</x-slot:title>

                @component(theme_widget('form.text'), [
                        'label' => __('Display Name'),
                        'name' => 'name',
                        'value' => old('name') ?? $user->name,
                        'placeholder' => __('Your name (to be shown across the application)')
                    ])
                @endcomponent

                @component(theme_widget('form.password'), [
                    'label' => __('New Password'),
                    'name' => 'password',
                    'placeholder' => __('Leave empty for no change')
                ])
                @endcomponent

                <x-slot:footer>
                    <x-appshell::button variant="primary">{{ __('Save') }}</x-appshell::button>
                </x-slot:footer>

            </x-appshell::card>

            {!! Form::close() !!}
        </div>

        <div class="col-sm-3">
            <x-appshell::card accent="success">
                <x-slot:title>{{ __('Profile Image') }}</x-slot:title>
                <x-slot:actions>
                    <x-appshell::button href="https://en.gravatar.com/emails" target="_blank" size="sm" variant="outline-info">
                        {{ __('Change...') }}
                    </x-appshell::button>
                </x-slot:actions>

                <img src="{{ avatar_image_url($user, 200) }}" class="img-avatar img-avatar-100">
            </x-appshell::card>
        </div>

    </div>

@stop
