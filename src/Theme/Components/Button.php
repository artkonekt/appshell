<?php

declare(strict_types=1);

/**
 * Contains the Button class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-03-21
 *
 */

namespace Konekt\AppShell\Theme\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public function render()
    {
        return theme_widget('button');
    }
}
