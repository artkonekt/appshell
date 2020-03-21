<?php
/**
 * Contains the AppShell2Theme class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-21
 *
 */

namespace Konekt\AppShell\Theme;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Exceptions\UnknownLayoutException;

class AppShell2Theme implements Theme
{
    public const ID = 'appshell.2';

    public static function getName(): string
    {
        return 'AppShell 2';
    }

    public function layout(string $variant)
    {
        switch ($variant) {
            case 'private': return 'appshell::layouts.v2.private';
            case 'public': return 'appshell::layouts.v2.public';
        }

        throw new UnknownLayoutException(
            sprintf(
                'Layout variant %s does not exist within the %s theme',
                $variant,
                $this->getName()
            )
        );
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
