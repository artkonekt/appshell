<?php

declare(strict_types=1);

/**
 * Contains the BaseComponent class.
 *
 * @copyright   Copyright (c) 2022 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2022-11-17
 *
 */

namespace Konekt\AppShell\Components;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    protected static array $viewFileNameCache = [];

    public function render()
    {
        return $this->resolveBladePath($this->bladeFileBaseName());
    }

    protected function bladeFileBaseName(): string
    {
        if (property_exists(static::class, 'bladeFileName')) {
            return static::$bladeFileName;
        }

        return Str::kebab(class_basename($this));
    }

    protected function resolveBladePath(string $view)
    {
        $ns = theme()->viewNamespace();
        if (null === (self::$viewFileNameCache[$ns][$view] ?? null)) {
            $fqvn = theme()->viewNamespace() . "::components.$view";
            if (!View::exists($fqvn)) { // Fall back to default view
                $fqvn = "appshell::components.$view";
            }
            self::$viewFileNameCache[$ns][$view] = $fqvn;
        }

        return view(self::$viewFileNameCache[$ns][$view]);
    }
}
