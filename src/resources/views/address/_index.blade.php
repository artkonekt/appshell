@component(theme_widget('group'))
    @slot('title'){{ __('Addresses') }}@endslot

    <?php
        $for = shorten(get_class($of));
        $editTheParent = 'edit ' . Illuminate\Support\Str::plural($for);
    ?>

    @slot('actionbar')
        @can($editTheParent)
            @can('create addresses')
                <a href="{{ route('appshell.address.create') }}?for={{$for}}&forId={{ $of->id }}" class="btn btn-sm btn-outline-success float-right">
                    {!! icon('+') !!}
                    {{ __('New Address') }}
                </a>
            @endcan
        @endcan
    @endslot

    {!! widget('appshell::address.table')->render($addresses) !!}

@endcomponent
