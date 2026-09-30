@extends($theme->layout('private'))

@section('title')Badges
@endsection

@section('content')
    <div class="row">
        <div class="col col-md-8">
            @foreach(['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'light', 'dark'] as $variant)
                <x-appshell::badge variant="{{ $variant }}">
                    {{ $variant }}
                </x-appshell::badge>
            @endforeach
        </div>
    </div>
@endsection
