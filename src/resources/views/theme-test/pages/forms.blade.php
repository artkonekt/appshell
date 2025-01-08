@extends($theme->layout('private'))

@section('content')
    <h1>Forms</h1>
    <hr>

    <div class="row">
        <div class="col col-md-6">
            <x-appshell::card accent="success">
                <x-slot:title>Simple Form</x-slot:title>
                <label class="form-control-label">Name</label>
                <input class="form-control" value="" placeholder="Enter text here">

                <label class="form-control-label">E-mail</label>
                <input class="form-control" type="email" value="x@y.com" placeholder="Enter email">

                <x-slot:footer>
                    <x-appshell::button variant="primary">Submit</x-appshell::button>
                    <x-appshell::button variant="link">Cancel</x-appshell::button>
                </x-slot:footer>
            </x-appshell::card>
        </div>
    </div>


@endsection
