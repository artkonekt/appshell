@foreach($provinces as $province)
    @can('edit provinces')
        <a href="{{ route('appshell.province.show', [$country, $province]) }}">
            <button class="btn btn-sm btn-secondary mb-2" type="button" title="{{ $province->type->label() }}">
                {{ $province->name }}
            </button>
        </a>
    @else
        <button class="btn btn-sm btn-secondary mb-2" type="button" title="{{ $province->type->label() }}">
            {{ $province->name }}
        </button>
    @endcan
@endforeach

@can('create provinces')
    @foreach($availableProvinceSeeders as $id => $class)
        {!! Form::open(['route' => ['appshell.province.store', [$country, 'seed' => $id]], 'class' => 'd-inline']) !!}
            <x-appshell::button variant="outline-secondary" size="sm" route="appshell.country.create" icon="download">
                {{ __('Generate :seeder', ['seeder' => ucfirst(Str::replace('_', ' ', Str::snake($id)))]) }}
            </x-appshell::button>
        {!! Form::close() !!}
    @endforeach

    <a href="{{ route('appshell.province.create', $country) }}" class="btn btn-sm btn-success mb-2" title="{{ __('Add province') }}">
        {!! icon('+') !!}
    </a>
@endcan
