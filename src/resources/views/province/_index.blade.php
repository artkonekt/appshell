@foreach($provinces as $province)
    @can('edit provinces')
        <span class="dropdown" title="{{ $province->type->label() }}">
            <button class="btn btn-sm dropdown-toggle btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $province->name }}
            </button>

            <div class="dropdown-menu">
                <a href="{{ route('appshell.province.edit', [$country, $province])  }}" class="dropdown-item" type="submit">
                    {{ __('Edit ":name"', ['name' => $province->name]) }}
                </a>

                {{ Form::open([
                        'url' => route('appshell.province.destroy', [$country, $province]),
                        'style' => 'display: inline',
                        'data-confirmation-text' => __('Are you sure you want to remove :name? Any associated child provinces will also be permanently deleted.', ['name' => $province->name]),
                        'method' => 'DELETE'
                    ])
                }}

                <button class="dropdown-item" type="submit">
                    {!! icon('delete', 'danger') !!}
                    {{ __('Delete ":name"', ['name' => $province->name]) }}
                </button>

                {{ Form::close() }}
            </div>
        </span>
    @else
        <button class="btn btn-sm dropdown-toggle btn-secondary" type="button" title="{{ $province->type->label() }}">
            {{ $province->name }}
        </button>
    @endcan
@endforeach

@can('create provinces')
    <a href="{{ route('appshell.province.create', $country) }}" class="btn btn-sm btn-success" title="{{ __('Add province') }}">
        {!! icon('+') !!}
    </a>
@endcan
