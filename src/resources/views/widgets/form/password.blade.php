<label class="form-control-label">{{ $label }}</label>
<div class="mb-4">
    <input class="form-control @if ($errors->has($name)) is-invalid @endif" name="{{ $name }}"
           type="password" value="{{ $value ?? '' }}" placeholder="{{ $placeholder ?? '' }}">
    <div class="invalid-feedback">{{ $errors->first($name) }}</div>
</div>
