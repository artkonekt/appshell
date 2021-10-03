<?php

declare(strict_types=1);

/**
 * Contains the Parrot class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Tests\Dummies;

use Illuminate\Support\Str;

class Parrot
{
    public string $name;

    public string $link;

    public function __construct(string $name, string $link = '')
    {
        $this->name = $name;
        $this->link = $link;
    }

    public function __toString(): string
    {
        return Str::slug($this->name);
    }
}
