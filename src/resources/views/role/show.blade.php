@extends('appshell::layouts.private')

@section('title')
    {{ ucfirst($role->name) }} {{ __('role') }}
@stop

@section('content')

    @component(theme_widget('group'), ['accent' => 'secondary'])
        @slot('title')
            {!! icon('security') !!}
            @yield('title')
            @component('appshell::role._user_count', ['count' => $role->users->count()]) @endcomponent
        @endslot

        <div class="mb-4">
            <legend>{{ __('Allows') }}</legend>
            @forelse($role->permissions as $permission)
                <span class="badge rounded-pill bg-success">
                        {!! icon('check') !!}
                    {{ $permission->name }}
                    </span>
            @empty
                <span class="badge rounded-pill bg-warning">
                        {!! icon(':(') !!}
                    {{ __('nothing') }}
                    </span>
            @endforelse
        </div>

        <?php $noperms = $permissions->diff($role->permissions); ?>
        <div class="mb-4">
            <legend>{{ __('Denies') }}</legend>
            @forelse($noperms as $permission)
                <span class="badge rounded-pill bg-danger">
                        {!! icon('warning') !!}
                    {{ $permission->name }}
                    </span>
            @empty
                <span class="badge rounded-pill bg-success">
                        {!! icon(':)') !!}
                    {{ __('nothing') }}
                    </span>
            @endforelse
        </div>

        <div class="mb-4">
            <legend>{{ __('Users having this role') }}</legend>
            @forelse($role->users as $user)
                <div class="btn-group btn-group-sm" style="margin-bottom: 5px" role="group">
                    @can('view users')
                        <a href="{{ route('appshell.user.show', $user) }}" class="btn btn-secondary">{{ $user->name }}</a>
                    @else
                        <button type="button" class="btn btn-secondary">{{ $user->name }}</button>
                    @endcan
                    <button type="button" class="btn btn-secondary">{!! icon('more-items') !!}</button>
                </div>
            @empty
                <a href="javascript:;" class="btn btn-sm btn-secondary" style="margin-bottom: 5px">{{ __('No user assigned so far') }}</a>
            @endforelse

            @can(['edit users'])
                <a href="{{ route('appshell.user.index') }}"
                   class="btn btn-sm btn-outline-success" style="margin-bottom: 5px">
                    {!! icon('+') !!}
                    {{ __('Assign to user') }}
                </a>

            @endcan

        </div>

        @slot('footer')
            @can('edit roles')
                <a href="{{ route('appshell.role.edit', $role) }}" class="btn btn-outline-primary">{{ __('Edit role') }}</a>
            @endcan

            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Back') }}</a>

            @can('delete roles')
                {!! Form::open(['route' => ['appshell.role.destroy', $role],
                                'method' => 'DELETE',
                                'class' => 'd-inline',
                                'data-confirmation-text' => __('Are you sure to delete the :name role?', ['name' => $role->name])
                                ])
                !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete role') }}
                </button>
                {!! Form::close() !!}
            @endcan
        @endslot

    @endcomponent

@stop
