<?php

declare(strict_types=1);

/**
 * Contains the Alert class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-14
 *
 */

namespace Konekt\AppShell\Components;

class Alert extends BaseComponent
{
    public function __construct(
        public string $variant = 'info',
        public string $tag = 'div',
    ) {
    }
}
