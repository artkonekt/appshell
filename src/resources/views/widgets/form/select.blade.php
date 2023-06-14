<label class="form-label">{{ $label }}</label>
<div class="mb-4">
    <select class="form-control @if ($errors->has($name)) is-invalid @endif" name="{{ $name }}">
        @foreach($options as $key => $label)
            <option value="{{ $key }}" @if($key == $value)selected="selected" @endif>{{ $label }}</option>
        @endforeach

    </select>
    <div class="invalid-feedback">{{ $errors->first($name) }}</div>
</div>
