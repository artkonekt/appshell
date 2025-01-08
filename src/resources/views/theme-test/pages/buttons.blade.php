@extends($theme->layout('private'))

@section('content')
    <h1>Buttons</h1>
    <hr>

    <div class="row">
        <div class="col col-md-8">
            <x-appshell::card>
                <x-slot:title>Buttons</x-slot:title>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="{{ $variant }}">{{ ucfirst($variant) }}</x-appshell::button>
                @endforeach

                <div class="my-4">
                    <hr>
                </div>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="{{ $variant }}" size="lg" class="mb-2">{{ ucfirst($variant) }} Large</x-appshell::button>
                @endforeach

            </x-appshell::card>
        </div>

        <div class="col col-md-4">
            <x-appshell::card>
                <x-slot:title>Small Buttons</x-slot:title>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="{{ $variant }}" size="sm" class="mb-2">{{ ucfirst($variant) }} Small</x-appshell::button>
                @endforeach

                <div class="my-4">
                    <hr>
                </div>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="{{ $variant }}" size="xs" class="mb-2">{{ ucfirst($variant) }} X-Small</x-appshell::button>
                @endforeach
            </x-appshell::card>
        </div>

        <div class="col col-md-8">
            <x-appshell::card>
                <x-slot:title>Outline Buttons</x-slot:title>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="outline-{{ $variant }}">{{ ucfirst($variant) }}</x-appshell::button>
                @endforeach

                <div class="my-4">
                    <hr>
                </div>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="outline-{{ $variant }}" size="lg" class="mb-2">{{ ucfirst($variant) }} Large</x-appshell::button>
                @endforeach

            </x-appshell::card>
        </div>

        <div class="col col-md-4">
            <x-appshell::card>
                <x-slot:title>Small Outline Buttons</x-slot:title>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="outline-{{ $variant }}" size="sm" class="mb-2">{{ ucfirst($variant) }} Small</x-appshell::button>
                @endforeach

                <div class="my-4">
                    <hr>
                </div>

                @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark', 'link'] as $variant)
                    <x-appshell::button variant="outline-{{ $variant }}" size="xs" class="mb-2">{{ ucfirst($variant) }} X-Small</x-appshell::button>
                @endforeach
            </x-appshell::card>
        </div>

    </div>

@endsection
