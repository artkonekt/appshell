<?php

declare(strict_types=1);

/**
 * Contains the SaveButton class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-06-16
 *
 */

namespace Konekt\AppShell\Components;

class SaveButton extends BaseComponent
{
    public string $text;

    public function __construct(?string $text = null, ?string $modelName = null)
    {
        $this->text = $text ?? ($modelName ? __('Save :object', ['object' => $modelName]) : __('Save'));
    }
}
