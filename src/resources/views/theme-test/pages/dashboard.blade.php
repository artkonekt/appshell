@extends($theme->layout('private'))

@section('title'){{ $theme->getName() }} Theme Tester
@endsection

@section('content')
    <h2>Cards</h2>
    <hr>
    <x-appshell::card accent="success">
        <x-slot:title>This is a Card</x-slot:title>
    </x-appshell::card>
@endsection
