<div @class(['form-floating', 'is-invalid' => $isInvalid])>
    {{ $slot }}
    <label>{{ $label }}</label>
</div>
