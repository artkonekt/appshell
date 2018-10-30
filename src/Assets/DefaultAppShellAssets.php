<?php
/**
 * Contains the DefaultAppShellAssets class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Assets;

final class DefaultAppShellAssets
{
    const JS  = ['js/appshell.js'];
    const CSS = [
        'https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i',
        'css/appshell.css',
        'https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css' => [
            'integrity'   => 'sha256-3sPp8BkKUE7QyPSl6VfBByBroQbKxKG7tsusY2mhbVY=',
            'crossorigin' => 'anonymous'
        ]
    ];
}
