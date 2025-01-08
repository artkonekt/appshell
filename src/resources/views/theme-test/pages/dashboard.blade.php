@extends($theme->layout('private'))

@section('content')
    <h1>{{ $theme->getName() }} Theme Tester</h1>
    <h2>Cards</h2>
    <hr>
    <x-appshell::card accent="success">
        <x-slot:title>This is a Card</x-slot:title>
    </x-appshell::card>
@endsection
