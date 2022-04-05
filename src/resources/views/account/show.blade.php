@extends('appshell::layouts.private')

@section('title')
    {{ __('My Account') }}
@stop

@section('content')

    <div class="row">

        <div class="col-sm-9">
            {!! Form::model($user, [
                    'class' => 'card card-accent-info',
                    'route' => ['appshell.account.save', $user],
                    'method' => 'PUT']
                    )
            !!}

            @component(theme_widget('group'))
                @slot('title'){{ __('User Account') }}@endslot
                @slot('actionbar')
                    @can('edit users')
                        <a href="{{ route('appshell.user.edit', $user) }}"
                           class="btn btn-sm btn-outline-info">{{ __('Edit on users page') }}</a>
                    @endcan
                @endslot

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

                @slot('footer')
                    <button class="btn btn-primary">{{ __('Save') }}</button>
                @endslot

            @endcomponent

            {!! Form::close() !!}
        </div>

        <div class="col-sm-3">
            @component(theme_widget('group'), ['accent' => 'success'])
                @slot('title'){{ __('Profile Image') }}@endslot
                @slot('actionbar')
                    <a href="https://en.gravatar.com/emails" target="_blank"
                       class="btn btn-sm btn-outline-info">{{ __('Change...') }}</a>
                @endslot

                <img src="{{ avatar_image_url($user, 200) }}" class="img-avatar img-avatar-100">
            @endcomponent
        </div>

    </div>

@stop
