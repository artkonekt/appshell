<div class="form-group">
    <div class="form-check">

        <input type="hidden" name="{{ $name }}" value="0" />
        <label class="form-check-label" for="checkbox_{{ $name }}">
            <input class="form-check-input @if ($errors->has($name)) is-invalid @endif"
                   type="checkbox"
                   value="1"
                   id="checkbox_{{ $name }}"
                   name="{{ $name }}"
                {{ $value ? 'checked="checked"': '' }}
            >
            {{ $label }}
        </label>

        @if ($errors->has($name))
            <div class="invalid-feedback">{{ $errors->first($name) }}</div>
        @endif
    </div>
</div>
