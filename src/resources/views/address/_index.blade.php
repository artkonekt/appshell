<div class="card">
    <div class="card-header">
        {{ __('Addresses') }}
        <?php
        $for = shorten(get_class($of));
            $editTheParent = 'edit ' . Illuminate\Support\Str::plural($for);
        ?>
        <div class="card-actionbar">
            @can($editTheParent)
                @can('create addresses')
                    <a href="{{ route('appshell.address.create') }}?for={{$for}}&forId={{ $of->id }}" class="btn btn-sm btn-outline-success float-right">
                        {!! icon('+') !!}
                        {{ __('New Address') }}
                    </a>
                @endcan
            @endcan
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Type') }}</th>
                <th>{{ __('Address') }}</th>
                <th>{{ __('Country') }}</th>
                <th style="width: 10%">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @forelse($addresses as $address)
                <tr>
                    <td>
                        @can($editTheParent)
                            @can('edit addresses')
                                <a href="{{ route('appshell.address.edit', $address) }}?for={{$for}}&forId={{ $of->id }}">
                            @endcan
                        @endcan

                        {{ $address->name }}

                        @can($editTheParent)
                            @can('edit addresses')
                                </a>
                            @endcan
                        @endcan
                    </td>
                    <td>{{ $address->type->label() }}</td>
                    <td>
                        @component('appshell::widgets.address.short_table_row', ['address' => $address])
                        @endcomponent
                    </td>
                    <td>{{ $address->country->name }}</td>
                    <td>
                        @can($editTheParent)
                            @can('delete addresses')
                                {!! Form::open(['route' => ['appshell.address.destroy', $address],
                                            'method' => 'DELETE',
                                            'data-confirmation-text' => __('Are you sure you want to delete this address?')
                                            ])
                                    !!}
                                <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('Delete') }}</button>
                                {!! Form::close() !!}
                            @endcan
                        @endcan
                    </td>
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
