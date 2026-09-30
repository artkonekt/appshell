@extends($theme->layout('private'))

@section('title')Cards
@endsection

@section('content')
    <h2>Basic Cards</h2>
    <hr class="mb-4">

    <div class="row">
        @foreach([null, 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light'] as $accent)
            <div class="col col-md-3">
                <x-appshell::card :accent="$accent">
                    @if($accent)
                        Basic Card with {{ $accent }} accent
                    @else
                        Basic Card without accent
                    @endif
                </x-appshell::card>
            </div>
        @endforeach
    </div>

    <h2>Cards with Title</h2>
    <hr class="mb-4">

    <div class="row">
        @foreach([null, 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light'] as $accent)
            <div class="col col-md-3">
                <x-appshell::card :accent="$accent">
                    <x-slot:title>Card with Title + {{ ucfirst($accent ?: 'No') }} Accent</x-slot:title>
                    Content comes here. This card has <a href="#">a link</a>.
                </x-appshell::card>
            </div>
        @endforeach
    </div>

    <h2>Cards with Actions</h2>
    <hr class="mb-4">

    <div class="row">
        @foreach([null, 'primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light'] as $accent)
            <div class="col col-md-3">
                <x-appshell::card :accent="$accent">
                    <x-slot:title>Card with Title + {{ ucfirst($accent ?: 'No') }} Accent + Action</x-slot:title>
                    <x-slot:actions>
                        <x-appshell::button size="xs" variant="outline-secondary">Action</x-appshell::button>
                        <x-appshell::button size="xs" variant="outline-{{ $accent ?: 'primary' }}">{{ ucfirst($accent ?: 'primary') }}</x-appshell::button>
                    </x-slot:actions>
                    Content comes here. This card has <a href="#">a link</a>.
                </x-appshell::card>
            </div>
        @endforeach
    </div>

    <h2>Cards with Icons</h2>
    <hr class="mb-4">

    <div class="row">
        @foreach([null, 'primary', 'secondary', 'success', 'warning', 'danger'] as $type)
            <div class="col col-md-4 mb-4">
                <x-appshell::card-with-icon :type="$type" icon="time" :subtitle="ucfirst($type ?: 'None')">
                    Title
                </x-appshell::card-with-icon>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach([null, 'primary', 'secondary'] as $type)
            <div class="col col-md-4 mb-4">
                <x-appshell::card-with-icon :type="$type" icon="time" :subtitle="auth()->user()?->name ?: 'John Doe'">
                    Icon Card with Image Content
                    <x-slot:icon-slot>
                        <img src="{{ avatar_image_url(auth()->user()) }}"
                             title="{{ auth()->user()?->name ?: 'John Doe' }}"
                             class="img-avatar img-avatar-48"
                        >
                    </x-slot:icon-slot>
                </x-appshell::card-with-icon>
            </div>
        @endforeach
    </div>

@endsection
