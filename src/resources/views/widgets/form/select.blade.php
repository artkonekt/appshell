<label class="form-control-label">{{ $label }}</label>
<div class="form-group">
    <select class="form-control @if ($errors->has($name)) is-invalid @endif" name="{{ $name }}">
        @foreach($options as $key => $label)
            <option value="{{ $key }}" @if($key == $value)selected="selected" @endif>{{ $label }}</option>
        @endforeach

    </select>
    <div class="invalid-feedback">{{ $errors->first($name) }}</div>
</div>
