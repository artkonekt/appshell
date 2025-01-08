@extends($theme->layout('private'))

@section('content')
    <h1>Cards</h1>
    <hr>

    <div class="row">
        <div class="col col-md-4">
            <x-appshell::card>
                Basic Card
            </x-appshell::card>

            <x-appshell::card>
                <x-slot:title>Card With Title</x-slot:title>
                Card Content
            </x-appshell::card>

            <x-appshell::card>
                <x-slot:title>Card With Actionbar</x-slot:title>
                <x-slot:actions>
                    <x-appshell::button size="xs" variant="outline-secondary">Action 2</x-appshell::button>
                    <x-appshell::button size="xs" variant="outline-primary">Action 1</x-appshell::button>
                </x-slot:actions>
                Card Content
            </x-appshell::card>

            <x-appshell::card>
                <x-slot:title>Card With Title & Footer</x-slot:title>
                Card Content
                <x-slot:footer><x-appshell::button variant="secondary" size="sm">Button</x-appshell::button></x-slot:footer>
            </x-appshell::card>
        </div>

        <div class="col col-md-4">
            @foreach(['primary', 'secondary', 'info'] as $accent)
                <x-appshell::card accent="{{ $accent }}">
                    <x-slot:title>Card With {{ ucfirst($accent) }} Accent</x-slot:title>
                    Content
                </x-appshell::card>
            @endforeach
        </div>

        <div class="col col-md-4">
            @foreach(['success', 'warning', 'danger'] as $accent)
                <x-appshell::card accent="{{ $accent }}">
                    <x-slot:title>Card With {{ ucfirst($accent) }} Accent</x-slot:title>
                    Content
                </x-appshell::card>
            @endforeach
        </div>
    </div>

@endsection
