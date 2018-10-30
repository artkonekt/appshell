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

interface Asset
{
    public function tag(): string;

    public function url(): string;

    public function attributes(): Collection;

    public function renderHtml(): string;
}
