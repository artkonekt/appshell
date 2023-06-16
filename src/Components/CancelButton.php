<?php

declare(strict_types=1);

/**
 * Contains the CancelButton class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-16
 *
 */

namespace Konekt\AppShell\Components;

class CancelButton extends BaseComponent
{
    public string $text;

    public function __construct(?string $text = null)
    {
        $this->text = $text ?? __('Cancel');
    }
}
