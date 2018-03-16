<?php
/**
 * Contains the Tab class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-13
 *
 */


namespace Konekt\AppShell\Settings;


use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\SettingsGroup;
use Konekt\AppShell\Contracts\SettingsTab;

class Tab extends BaseSlice implements SettingsTab
{
    /**
     * @inheritDoc
     */
    public function groups(): Collection
    {
        return $this->children->sortBy('order');
    }

    public function addGroup(SettingsGroup $group)
    {
        $this->children->put($group->id(), $group);
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
