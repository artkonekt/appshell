<div class="card">
    <div class="card-header">
        {{ __('Addresses') }}
        <?php $for = shorten(get_class($createFor)); ?>
        <div class="card-actionbar">
            @can('edit ' . str_plural($for))
                @can('create addresses')
                    <a href="{{ route('appshell.address.create') }}?for={{$for}}&forId={{ $createFor->id }}" class="btn btn-sm btn-outline-success float-right">
                        <i class="zmdi zmdi-plus"></i>
                        {{ __('New Address') }}
                    </a>
                @endcan
            @endcan
        </div>
    </div>
    <div class="card-block">
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Phone') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Country') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($addresses as $address)
                <tr>
                    <td>{{ $address->name }}</td>
                    <td>{{ $address->type->label() }}</td>
                    <td>{{ $address->phone }}</td>
                    <td>
                        @component('appshell::widgets.address.short_table_row', ['address' => $address])
                        @endcomponent
                    </td>
                    <td>{{ $address->country->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">{{ __('No addresses yet') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
