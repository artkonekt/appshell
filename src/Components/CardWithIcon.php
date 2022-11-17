<?php

declare(strict_types=1);

/**
 * Contains the CardWithIcon class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-17
 *
 */

namespace Konekt\AppShell\Components;

class CardWithIcon extends BaseComponent
{
    public function __construct(
        public ?string $icon = null,
        public ?string $type = null,
        public string $cardBodyClass = '',
    ) {
    }
}
