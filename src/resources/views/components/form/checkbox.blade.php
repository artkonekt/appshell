<div class="mb-3">
    <div class="form-check">
        <input type="hidden" name="{{ $name }}" value="0" />
        <input @class(['form-check-input', 'is-invalid' => $errors->has($name)])
               type="checkbox"
               value="1"
               id="checkbox_{{ $name }}"
               name="{{ $name }}"
               {{ old($name, $value) ? 'checked="checked"' : '' }}
        >
        <label class="form-check-label" for="checkbox_{{ $name }}">
            {{ $label }}
        </label>
    </div>

    @if ($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</div>
