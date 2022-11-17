<?php

declare(strict_types=1);

/**
 * Contains the Card class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-04-27
 *
 */

namespace Konekt\AppShell\Components;

use Illuminate\View\Component;

class Card extends BaseComponent
{
    public function __construct(
        public ?string $accent = null,
    ) {
    }
}
