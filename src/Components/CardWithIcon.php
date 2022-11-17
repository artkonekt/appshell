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

use Illuminate\View\Component;

class CardWithIcon extends Component
{
    public function render()
    {
        return view('appshell::components.card-with-icon');
    }
}

