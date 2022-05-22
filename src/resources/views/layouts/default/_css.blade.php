<!-- Styles -->
<?php
    $cfg = config('konekt.app_shell.default_theme.custom_assets', []);
    $custom = $cfg['enabled'] ?? false;
    $css = ($custom ? ($cfg['css_link'] ?? null) : null) ?: '/css/appshell.css';
    $helper = $cfg['helper'] ?? null;
    $helper = in_array($helper, ['mix', 'asset', null], true) ? $helper : null;
?>
@if($custom)
    <link href="{{ null === $helper ? $css : $helper($css) }}" media="all" type="text/css" rel="stylesheet" />
@else
    <link href="{{ $appshell->useMix ? mix('/css/appshell.css') : asset('/css/appshell.css') }}" media="all" type="text/css" rel="stylesheet" />
@endif
