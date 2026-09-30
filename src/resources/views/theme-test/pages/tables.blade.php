@extends($theme->layout('private'))

@section('title')Tables
@endsection

@section('content')

    {!! widget('appshell::user.index.table')->render(Konekt\AppShell\Models\User::take(10)->get()) !!}

@endsection
