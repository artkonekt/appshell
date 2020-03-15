<?php
/**
 * Contains the DefaultAppShellTheme class.
 *
 * @copyright   Copyright (c) 2019 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2019-02-24
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\AppShell\Contracts\Theme;

class DefaultAppShellTheme implements Theme
{
    public function getName(): string
    {
        return 'AppShell Default';
    }

    public function semanticColorToHex(string $semanticColor): string
    {
        switch ($semanticColor) {
            case 'success':
                return '#23a38b';
                break;
            case 'danger':
                return '#f24236';
                break;
            case 'warning':
                return '#e8c547';
                break;
            case 'info':
                return '#0c9bd3';
                break;
            case 'primary':
                return '#385170';
                break;
            case 'secondary':
                return '#becdcf';
                break;
        }

        return '#607375';
    }
}
