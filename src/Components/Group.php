<?php

declare(strict_types=1);

/**
 * Contains the Group class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-04-27
 *
 */

namespace Konekt\AppShell\Components;

use Illuminate\View\Component;

class Group extends Component
{
    public function __construct(
        public ?string $accent = null,
    ) {
    }

    public function render()
    {
        return view('appshell::components.group');
    }
}
