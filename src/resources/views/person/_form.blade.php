<div class="row">

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('person.firstname') ? ' has-danger' : '' }}">
            {{ Form::text('person[firstname]', null, [
                    'class' => 'form-control form-control-lg',
                    'placeholder' => __('First name')
                ])
            }}

            @if ($errors->has('person.firstname'))
                <div class="form-control-feedback">{{ $errors->first('person.firstname') }}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('person.lastname') ? ' has-danger' : '' }}">
            {{ Form::text('person[lastname]', null, [
                    'class' => 'form-control form-control-lg',
                    'placeholder' => __('Last name')
                ])
            }}

            @if ($errors->has('person.lastname'))
                <div class="form-control-feedback">{{ $errors->first('person.lastname') }}</div>
            @endif
        </div>
    </div>

</div>

<div class="form-group{{ $errors->has('person.nin') ? ' has-danger' : '' }}">

    {{ Form::email('person[nin]', null, ['class' => 'form-control', 'placeholder' => __('National ID')]) }}

    @if ($errors->has('person.nin'))
        <div class="form-control-feedback">{{ $errors->first('person.nin') }}</div>
    @endif
</div>

<div class="form-group row{{ $errors->has('person.gender') ? ' has-danger' : '' }}">
    <label class="form-control-label col-md-2">{{ __('Gender') }}</label>
    <div class="col-md-10">

        @foreach(enum('gender')->choices() as $key => $value)
            <label class="radio-inline" for="type_{{ $key }}">
                {{ Form::radio('person[gender]', $key, isset($person) && ($person->gender->value() == $key), ['id' => "gender_$key"]) }}
                {{ $value }}
                &nbsp;
            </label>
        @endforeach

        @if ($errors->has('person.gender'))
            <div class="form-control-feedback">{{ $errors->first('person.gender') }}</div>
        @endif
    </div>
</div>
