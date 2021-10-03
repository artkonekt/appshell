<?php

declare(strict_types=1);
/**
 * Contains the MemoryOnlyGearsBackend class.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-03-21
 *
 */

namespace Konekt\AppShell\Tests\Dummies;

use Illuminate\Support\Collection;
use Konekt\Gears\Contracts\Backend;

class MemoryOnlyGearsBackend implements Backend
{
    private $settings = [];

    private $preferences = [];

    public function allSettings(): Collection
    {
        return collect($this->settings);
    }

    public function allPreferences($userId): Collection
    {
        return collect($this->preferences);
    }

    public function getSetting(string $key)
    {
        return $this->settings[$key] ?? null;
    }

    public function getPreference($key, $userId)
    {
        return $this->preferences[$userId][$key] ?? null;
    }

    public function setSetting($key, $value)
    {
        $this->settings[$key] = $value;
    }

    public function setPreference($key, $value, $userId)
    {
        $this->preferences[$userId][$key] = $value;
    }

    public function setSettings(array $settings)
    {
        $this->settings = array_merge($this->settings, $settings);
    }

    public function setPreferences(array $preferences, $userId)
    {
        $this->preferences[$userId] = array_merge($this->settings[$userId], $preferences);
    }

    public function removeSetting($key)
    {
        unset($this->settings[$key]);
    }

    public function removePreference($key, $userId)
    {
        unset($this->preferences[$userId][$key]);
    }

    public function removeSettings(array $keys)
    {
        // not being used by tests, so fuck it, I won't implement ¯\_(ツ)_/¯
    }

    public function removePreferences(array $keys, $userId)
    {
        // LA LA LA LA ¯\_(ツ)_/¯
    }
}
