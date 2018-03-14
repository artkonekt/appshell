<?php
/**
 * Contains the Group class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-14
 *
 */


namespace Konekt\AppShell\Settings;


use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\SettingsGroup;

class Group extends BaseSlice implements SettingsGroup
{
    /**
     * @inheritDoc
     */
    public function settings(): Collection
    {
        return $this->children->sortBy('order');
    }

    /**
     * @inheritDoc
     */
    public function allowed(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function permission()
    {
        return null;
    }
}
