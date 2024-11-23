@foreach($provinces as $province)
    <x-appshell::button variant="secondary" size="sm" :title="$province->type->label()" class="mb-2"
        :href="auth()->user()->can('view provinces') ? route('appshell.province.show', [$country, $province]) : '#'"
    >
        {{ $province->name }}
    </x-appshell::button>
@endforeach

@can('create provinces')
    @foreach($availableProvinceSeeders as $id => $name)
        {!! Form::open(['route' => ['appshell.province.store', [$country, 'seed' => $id]], 'class' => 'd-inline']) !!}
            <x-appshell::button variant="outline-secondary" size="sm" route="appshell.country.create" icon="download" class="mb-2">
                {{ __('Generate :seeder_name', ['seeder_name' => $name]) }}
            </x-appshell::button>
        {!! Form::close() !!}
    @endforeach

    <x-appshell::button :href="route('appshell.province.create', $country)" :title="__('Add province')"
            variant="success" size="sm" icon="+" class="mb-2"></x-appshell::button>
@endcan
