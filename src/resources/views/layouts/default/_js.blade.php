<!-- Styles -->
<?php
    $cfg = config('konekt.app_shell.default_theme.custom_assets', []);
    $custom = $cfg['enabled'] ?? false;
    $js = ($custom ? ($cfg['js_link'] ?? null) : null) ?: '/js/appshell.js';
    $helper = $cfg['helper'] ?? null;
    $helper = in_array($helper, ['mix', 'asset', null], true) ? $helper : null;
?>
@if($custom)
    <script src="{{ null === $helper ? $js : $helper($js) }}"></script>
@else
    <script type="module" src="{{ $appshell->useMix ? mix('/js/appshell.js') : asset('/js/appshell.js') }}"></script>
@endif
