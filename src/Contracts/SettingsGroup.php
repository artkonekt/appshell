<?php
/**
 * Contains the SettingsGroup interface.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-14
 *
 */


namespace Konekt\AppShell\Contracts;


use Illuminate\Support\Collection;

interface SettingsGroup extends SettingsSlice
{
    /**
     * The setting items within the group
     *
     * @return Collection
     */
    public function settings() : Collection;
}
