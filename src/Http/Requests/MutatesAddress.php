<?php

declare(strict_types=1);

/**
 * Contains the MutatesAddress class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-02
 * @refactored sd@groundwow.com 30-06-2021
 */

namespace Konekt\AppShell\Http\Requests;

trait MutatesAddress
{
    public function getDataAttributes(): array
    {
        $attributes = $this->validated();
        unset($attributes["forId"]);
        unset($attributes["for"]);
        return $attributes;
    }
}
