<div class="form-group row{{ $errors->has('type') ? ' has-danger' : '' }}">
    <label class="form-control-label col-md-2">{{ __('Client type') }}</label>
    <div class="col-md-10">
        @foreach($types as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('type', $key, $client->type->value() == $key, ['id' => "type_$key", 'v-model' =>
                'clientType']) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('type'))
            <div class="form-control-feedback">{{ $errors->first('type') }}</div>
        @endif
    </div>
</div>

<hr>

<div id="client-organization" v-show="clientType == 'organization'">
    @include('appshell::organization._form')
</div>

<div id="client-individual" v-show="clientType == 'individual'">
    @include('appshell::person._form', ['person' => $client->person])
</div>

@section('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                clientType: '{{ $client->type->value() }}'
            }
        });
    </script>
@stop
