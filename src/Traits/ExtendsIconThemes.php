<?php

declare(strict_types=1);

/**
 * Contains the ExtendsIconThemes trait.
 *
 * @copyright   Copyright (c) 2020 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2020-10-19
 *
 */

namespace Konekt\AppShell\Traits;

use Konekt\AppShell\IconThemes;

trait ExtendsIconThemes
{
    private function registerIconExtensions(): void
    {
        foreach ($this->icons as $abstract => $concretes) {
            foreach ($concretes as $id => $concrete) {
                $class = IconThemes::getClass($id);
                $class::extend($abstract, $concrete);
            }
        }
    }
}
