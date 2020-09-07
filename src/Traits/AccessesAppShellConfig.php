<?php
/**
 * Contains the AccessesAppShellConfig trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-09-07
 *
 */

namespace Konekt\AppShell\Traits;

trait AccessesAppShellConfig
{
    private function config(string $key, $default = null)
    {
        return config("konekt.app_shell.$key", $default);
    }
}
