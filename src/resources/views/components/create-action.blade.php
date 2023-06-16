@can($permission)
    <x-appshell::button size="sm" variant="outline-success" :icon="$icon" :href="$url" size="sm">
        {{ $buttonText }}
    </x-appshell::button>
@endcan
