@if($invitation->isExpired())
    <x-appshell::alert variant="warning">
        {{ __('This invitation has expired and no longer can be used.') }}
    </x-appshell::alert>
@elseif($invitation->hasBeenUtilizedAlready())
    <x-appshell::alert variant="info">
        {{ __('This invitation has been utilized already') }}
    </x-appshell::alert>
@else
    <x-appshell::alert variant="danger">
        {{ __('This invitation is invalid') }}
    </x-appshell::alert>
@endif
