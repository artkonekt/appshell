<?php
/**
 * Contains the AnotherSettingsBackend dummy class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-12
 *
 */

namespace Konekt\AppShell\Tests\Unit\Backend;


use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\SettingsBackend;

class AnotherSettingsBackend implements SettingsBackend
{
    public function all(): Collection
    {
        return Collection::make();
    }

    public function get($setting, $user = null)
    {
        return '';
    }

    public function set($setting, $value, $user = null)
    {
        // do nothing
    }


}