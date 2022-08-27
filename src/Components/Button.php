<?php

declare(strict_types=1);

/**
 * Contains the Button class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-04-27
 *
 */

namespace Konekt\AppShell\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $tag = 'a',
        public string $variant = 'primary',
        public ?string $size = null,
        public ?string $icon = null,
        public ?string $iconPosition = 'before'
    ) {
    }

    public function render()
    {
        return view('appshell::components.button');
    }
}
