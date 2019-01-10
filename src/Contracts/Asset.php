<?php
/**
 * Contains the Asset interface.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Contracts;

use Illuminate\Support\Collection;
use Konekt\AppShell\Assets\AssetLocation;

interface Asset
{
    public function tag(): string;

    public function url(): string;

    public function attributes(): Collection;

    public function renderHtml(): string;

    public function defaultLocation(): AssetLocation;

    public function metadata(): Collection;

    public function getMetaValue(string $key);

    public function addMetaValue(string $key, $value): void;
}
