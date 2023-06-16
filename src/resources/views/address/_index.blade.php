<x-appshell::card>
    <x-slot:title>{{ __('Addresses') }}</x-slot:title>

    <?php
        $for = shorten(get_class($of));
        $editTheParent = 'edit ' . Illuminate\Support\Str::plural($for);
    ?>

    <x-slot:actions>
        @can($editTheParent)
            @can('create addresses')
                <x-appshell::button href="{{ route('appshell.address.create') }}?for={{$for}}&forId={{ $of->id }}"
                    size="sm" variant="outline-success" icon="+">
                    {{ __('New Address') }}
                </x-appshell::button>
            @endcan
        @endcan
    </x-slot:actions>

    {!! widget('appshell::address.table')->render($addresses) !!}
</x-appshell::card>
