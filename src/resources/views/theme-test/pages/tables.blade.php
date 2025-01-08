@extends($theme->layout('private'))

@section('content')
    <h1>Tables</h1>
    <hr>

    {!! widget('appshell::user.index.table')->render(Konekt\AppShell\Models\User::take(10)->get()) !!}

@endsection
