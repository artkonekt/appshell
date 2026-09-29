@extends($theme->layout('private'))

@section('content')
    <h1>Alerts</h1>
    <hr>

    <div class="row">
        <div class="col col-md-8">
            @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark'] as $variant)
                <x-appshell::alert variant="{{ $variant }}">
                    {{ ucfirst($variant) }} alert with some text and with a <a href="#" class="alert-link">link within</a> the alert.
                </x-appshell::alert>
                <div>&nbsp;</div>
            @endforeach
        </div>

        <div class="col col-md-4">
            @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark'] as $variant)
                <x-appshell::alert variant="{{ $variant }}" dismissable="1">
                    This is an dismissable {{ $variant }} alert.
                </x-appshell::alert>
                <div>&nbsp;</div>
            @endforeach

        </div>

    </div>

@endsection
