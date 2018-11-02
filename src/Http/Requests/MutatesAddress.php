<?php
/**
 * Contains the MutatesAddress class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-02
 *
 */

namespace Konekt\AppShell\Http\Requests;

trait MutatesAddress
{
    public function getDataAttributes(): array
    {
        return $this->except(['for', 'forId']);
    }
}
